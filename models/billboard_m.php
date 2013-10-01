<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Billboard
 *
 * @author 		Marijan Greguric
 * @website		http://greguric.info
 * @package 	
 * @subpackage 	
 * @copyright 	MIT
 */
class billboard_m extends MY_Model {

	private $folder;

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'billboard_items';
		// $this->load->model('files/file_folders_m');
		// $this->load->library('files/files');
		// $this->folder = $this->file_folders_m->get_by('name', 'billboard');
	}

	//create a new item
	public function create($input)
	{
		// $fileinput = Files::upload($this->folder->id, FALSE, 'fileinput');
		$to_insert = array(
			// 'fileinput' => json_encode($fileinput);
			'title' => $input['title'],
			'description' => $input['description'],
			'date_available_from' => $input['date_available_from'],
			'date_available_to' => $input['date_available_to'],

		);

		return $this->db->insert('billboard', $to_insert);
	}

	//edit a new item
	public function edit($id = 0, $input)
	{
		// $fileinput = Files::upload($this->folder->id, FALSE, 'fileinput');
		$to_insert = array(
			'title' => $input['title'],
			'description' => $input['description'],
			'date_available_from' => $input['date_available_from'],
			'date_available_to' => $input['date_available_to'],

		);

		// if ($fileinput['status']) {
		// 	$to_insert['fileinput'] = json_encode($fileinput);
		// }

		return $this->db->where('id', $id)->update('billboard', $to_insert);
	}
}
