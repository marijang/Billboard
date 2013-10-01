<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Billboard
 *
 * @author      Marijan Greguric
 * @website     http://greguric.info
 * @package     
 * @subpackage  
 * @copyright   MIT
 */
class billboard extends Public_Controller
{

    /**
     * The constructor
     * @access public
     * @return void
     */
    public function __construct()
    {
      parent::__construct();
      $this->lang->load('billboard');
      $this->load->model('billboard_m');
      $this->template->append_css('module::billboard.css');
    }
     /**
     * List all billboards
     *
     *
     * @access  public
     * @return  void
     */
     public function index()
     {
      // bind the information to a key
      $data['billboard'] = (array)$this->billboard_m->get_all();
      // Build the page
      $this->template->title($this->module_details['name'])
      ->build('index', $data);
    }

  }

/* End of file billboard.php */