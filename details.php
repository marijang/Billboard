<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_billboard extends Module {

	public $version = '1.0';
    public $namespace = 'billboard';

	public function info()
	{
		$this->load->language($this->namespace.'/'.$this->namespace);
		return array(
			'name' => array(
				'en' => 'Billboard'
				),
			'description' => array(
				'en' => 'Billboard'
				),
			'frontend' => true,
			'backend' => true,
			'menu' => 'content', // You can also place modules in their top level menu. For example try: 'menu' => 'billboard',
			'sections' => array(
                'item' => array(
                    'name' => $this->namespace.':label:item',
                    'uri' => 'admin/'.$this->namespace.'',
                    'shortcuts' => array(
                        array(
                            'name' => $this->namespace.':shortcuts:create_item',
                            'uri' => 'admin/'.$this->namespace.'/create',
                            'class' => 'add'
                            ),
                        ),
                    ),
                ),
			);
	}

	public function install()
	{
		$this->dbforge->drop_table('billboard');
		//$this->db->delete('settings', array('module' => 'billboard'));

		// $this->load->library('files/files');
		// Files::create_folder(0, 'billboard');

		/* custom_data
    	-------------------------------------------------- */
    	$streams = array('items');

    	$fields_assignment = array(
        'items' => array('title', 'slug', 'description', 'published','image1','image2','image3','image4','available_from','available_to','location')
        );

    	$streams_options = array(
        'items' => array(
            'view_options' => array('title', 'slug', 'description', 'published'),
            'title_column' => 'title'
            )
        );

    	/* dependencies
    	-------------------------------------------------- */
    	$this->load->driver('streams');
    	$this->load->language($this->namespace.'/'.$this->namespace);

    	/* uninstall
    	-------------------------------------------------- */
    	if( ! $this->uninstall())
        return false;

    	/* streams
    	-------------------------------------------------- */
    	$streams_id = $this->add_streams($streams, $streams_options);

    	/* folders
    	-------------------------------------------------- */
    	$array = array();
    	$folders = $this->create_folders($array);
    	$folder_id = $folders[$this->namespace]->id;

    	/* fields
    	-------------------------------------------------- */
    	$fields = array();

    	// global
    	$fields['title']     	  = array('name' => $this->lang('title'), 'slug' => 'title', 'type' => 'text', 'unique' => true);
    	$fields['slug']           = array('name' => $this->lang('slug'), 'slug' => 'slug', 'type' => 'slug', 'extra' => array('max_length' => 255, 'slug_field' => 'title', 'space_type' => '-'), 'unique' => TRUE);
    	$fields['description']    = array('name' => $this->lang('description'), 'slug' => 'description', 'type' => 'textarea');
        $fields['available_from'] = array('name' => $this->lang('available_from'), 'slug' => 'available_from', 'type' => 'datetime','extra'=>array('input_type'=>'Dropdown'),'required'=>false);
        $fields['available_to']   = array('name' => $this->lang('available_to'), 'slug' => 'available_to', 'type' => 'datetime','extra'=>array('input_type'=>'Dropdown'),'required'=>false);
    	$array = array('draft', 'published');
    	$fields['published'] 	  = $this->build_choice_field($array, 'published', 'dropdown', 'draft');
    	$fields['image1'] 		  = array('name'=> $this->lang('image1'), 'slug'=> 'image1', 'type'=>'image','extra'=> array('folder'=> $folder_id ),'required'=>false);
    	$fields['image2'] 		  = array('name'=> $this->lang('image2'), 'slug'=> 'image2', 'type'=>'image','extra'=> array('folder'=> $folder_id ),'required'=>false);
    	$fields['image3'] 		  = array('name'=> $this->lang('image3'), 'slug'=> 'image3', 'type'=>'image','extra'=> array('folder'=> $folder_id ),'required'=>false);
    	$fields['image4'] 		  = array('name'=> $this->lang('image4'), 'slug'=> 'image4', 'type'=>'image','extra'=> array('folder'=> $folder_id ),'required'=>false);
    	$fields['location'] 	  = array('name'=> $this->lang('location'), 'slug'=> 'location', 'type'=>'geocoder','required'=>false);
    	$this->add_fields($fields);

    	/* fields_assignment
    	-------------------------------------------------- */
    	$this->add_fields_assignment($streams, $fields, $fields_assignment);

    	return true;
	}

	public function uninstall()
	{
		$this->load->library('files/files');
		$this->load->model('files/file_folders_m');
		$folder = $this->file_folders_m->get_by('name', 'billboard');
		Files::delete_folder($folder->id);
		$this->dbforge->drop_table('billboard');
		$this->load->driver('streams');
        $this->streams->utilities->remove_namespace($this->namespace);
		//$this->db->delete('settings', array('module' => 'billboard'));
		return TRUE;
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}

	public function add_streams($streams, $streams_options)
	{

	    $streams_id = array();
	    foreach ($streams as $stream)
	    {
	        //print_R($stream);
	        if ( ! $this->streams->streams->add_stream($this->lang($stream), $stream, $this->namespace, $this->namespace.'_', null)) return false;
	        else
	            $streams_id[$stream] = $this->streams->streams->get_stream($stream, $this->namespace)->id;

	        $this->update_stream_options($stream, $streams_options[$stream]);
	    }

	    return $streams_id;
	}

	public function update_stream_options($stream, $stream_options)
	{
	        // Update about, title_column and view options
	    $update_data = array(
	        'about'        => 'lang:'.$this->namespace.':'.$stream.':about',
	        'view_options' => $stream_options['view_options'],
	        'title_column' => $stream_options['title_column']
	        );
	    $this->streams->streams->update_stream($stream, $this->namespace, $update_data);
	}

	public function build_template($stream = null)
	{
	    if($stream)
	        return array('title_column' => FALSE, 'required' => TRUE, 'unique' => FALSE);
	    else
	        return array('namespace' => $this->namespace, 'type' => 'text');
	}

	public function create_folders($array)
	{
	    $this->load->library('files/files');
	    $this->load->model('files/file_folders_m');

	    $folder = Files::search($this->namespace);
	    if( ! $folder['status'])
	        Files::create_folder($parent = '0', $folder_name = $this->namespace);
	    $folders[$this->namespace] = $this->file_folders_m->get_by('name', $this->namespace);

	    foreach ($array as $label)
	    {
	        $folder = Files::search($label);
	        if( ! $folder['status'])
	            Files::create_folder($parent = $folders[$this->namespace]->id, $folder_name = $label);
	        $folders[$label] = $this->file_folders_m->get_by('name', $label);
	    }

	    return $folders;
	}

	public function add_fields($fields)
	{
	    foreach($fields AS &$field)
	        //print_r($field);
	        $field = array_merge($this->build_template(), $field);
	    $this->streams->fields->add_fields($fields);
	}

	public function add_fields_assignment($streams, $fields, $fields_assignment)
	{

	    foreach ($streams as $stream)
	    {
	        $assign_data = array();
	        foreach($fields_assignment[$stream] as $field_assignment)
	            $assign_data[] = array_merge($this->build_template($stream), $fields[$field_assignment]);
	     
	        foreach($assign_data as $assign_data_row)
	        {
	            $field_slug = $assign_data_row['slug'];
	            unset($assign_data_row['name']);
	            unset($assign_data_row['slug']);
	            unset($assign_data_row['type']);
	            unset($assign_data_row['extra']);
	            //echo '-'.$field_slug.':<br>';
	            $this->streams->fields->assign_field($this->namespace, $stream, $field_slug, $assign_data_row);
	        }
	    }

	}

	public function build_choice_field($array, $label, $choice_type, $default_value = 0)
	{
	    $flag = true;
	    $string = '';
	    foreach ($array AS $key)
	    {
	        if($flag)
	            $flag = false;
	        else
	            $string .= "\n";

	        $string .= "$key : ".$this->lang($key);
	    }

	    return array('name' => 'lang:'.$this->namespace.':label:'.$label, 'slug' => $label, 'type' => 'choice', 'extra' => array('choice_data' => $string, 'choice_type' => $choice_type, 'default_value' => $default_value));
	}


	public function lang($label, $type = 'label')
	{
	    return 'lang:'.$this->namespace.':'.$type.':'.$label;
	}
}
/* End of file details.php */
