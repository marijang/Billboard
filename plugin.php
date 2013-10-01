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
class Plugin_billboard extends Plugin
{
	/**
	 * Item List
	 * Usage:
	 *
	 * {{ billboard:items limit="5" order="asc" }}
	 *      {{ id }} {{ name }} {{ slug }}
	 * {{ /billboard:items }}
	 *
	 * @return	array
	 */
	function items()
	{
		$this->load->model('billboard/billboard_m');
		return $this->billboard_m->get_all();
	}
}

/* End of file plugin.php */