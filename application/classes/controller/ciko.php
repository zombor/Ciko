<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Main Ciko controller, displays project runner results and schedules runners
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2010 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
class Controller_Ciko extends Controller
{
	/**
	 * Shows all projects and their latest status
	 *
	 * @return null
	 */
	public function action_index()
	{
		$this->response->body(new View_Ciko_Index);
	}

	/**
	 * Shows all runner jobs for a project
	 *
	 * @return null
	 */
	public function action_project($project = NULL)
	{
		$this->response->body(new View_Ciko_Project);
	}
}