<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Runs a project
 *
 * Available config options: 
 *
 * --project=ciko
 *  
 *  Specify the project to run. It must be defined in config/ciko.php
 *
 *  This is a required config option
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2010 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
class Minion_Task_Ciko_Run extends Minion_Task
{
	/**
	 * An array of config options that this task can accept
	 */
	protected $_config = array('project');

	/**
	 * Executes a job
	 *
	 * @return Something
	 */
	public function execute(array $config)
	{
		if (empty($config['project']))
		{
			return Minion_CLI::write('Please specify a project.', 'red');
		}

		$project = Kohana::config('ciko.projects.'.$config['project']);
		if (NULL === $project)
		{
			return Minion_CLI::write('That project doesn\'t exist!', 'red');
		}

		// Clone the source
		Git::$git_path = trim(`which git`);
		$git = new Git(
			Kohana::config('ciko.clone_path').url::title($project->name())
		);
		Minion_CLI::write(
			$git->clone_remote(
				$project->repository(), '-b '.$project->branch().' --recursive',
				TRUE
			),
			'yellow'
		);

		// Run the runner command
		$descriptorspec = array(
			1 => array('pipe', 'w'),
			2 => array('pipe', 'w'),
		);

		$pipes = array();
		$resource = proc_open(
			escapeshellcmd($project->runner()),
			$descriptorspec,
			$pipes,
			'/tmp/'.url::title($project->name())
		);

		// Capture the runner output
		$stdout = stream_get_contents($pipes[1]);
		$stderr = stream_get_contents($pipes[2]);
		foreach ($pipes as $pipe) {
			fclose($pipe);
		}

		$status = trim(proc_close($resource));

		$project->write($stdout, $stderr, $status);

		if ($status)
		{
			return Minion_CLI::write(
				'There was an error executing the runner ('.$status.'):'.
					"\n$stderr",
				'red'
			);
		}

		return Minion_CLI::write(
			'Job successfully ran for project '.$config['project'].":\n$stdout",
			'green'
		);
	}
}