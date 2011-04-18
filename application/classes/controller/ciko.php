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

	/**
	 * Schedules a runner job for a project
	 *
	 * @return null
	 */
	public function action_run($project = NULL)
	{
		if ( ! $project)
		{
			throw new Http_Exception_404;
		}

		if (Kohana::$is_cli OR Request::POST == $this->request->method())
		{
			// Investigate a better way to do this, should probably be
			// abstracted away somewhere, in Runner?
			shell_exec(
				'nohup ./minion ciko:run --project='.
				escapeshellcmd($project).' > /dev/null &'
			);

			$this->response->body(json_encode('running...'));
		}

		if ( ! Kohana::$is_cli)
		{
			// We only accept POST at this uri if it's a web request
			throw new Http_Exception_405;
		}
	}
}