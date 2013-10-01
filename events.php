<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * billboard Events Class
 *
 * @author      Marijan Greguric
 * @website     http://greguric.info
 * @package     
 * @subpackage  
 * @copyright   MIT
 */
class Events_billboard {

    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();

        //register the public_controller event
        Events::register('public_controller', array($this, 'run'));

		//register a second event that can be called any time.
		// To execute the "run" method below you would use: Events::trigger('billboard_event');
		// in any php file within PyroCMS, even another module.
		Events::register('billboard_event', array($this, 'run'));
    }

    public function run()
    {
        $this->ci->load->model('billboard/billboard_m');

        // we're fetching this data on each front-end load. You'd probably want to do something with it IRL
        $this->ci->billboard_m->limit(5)->get_all();
    }

}
/* End of file events.php */