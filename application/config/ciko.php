<?php
/**
 * Config file for Ciko. Specify your projects here in this format:
 * 
 * 	$project = new Model_Ciko_Project('Ciko');
 * 	$project->repository('git://github.com/zombor/Ciko.git');
 * 	$project->branch('master');
 * 	$project->runner('phpunit');
 * 	
 * 	$projects['ciko'] = $project;
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2010 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */

return array(
	'clone_path' => '/tmp/', // Full path to where projects will be cloned
	'projects' => array( // An array of projects to run
		'ciko' => Model_Ciko_Project::factory('Ciko')
			->repository('../.') // Location of the remote repository
			->branch('develop') // branch to build
			->runner( // Runner(s) to execute,
				array(
					'touch /tmp/foo.txt',
					'phpunit --configuration phpunit.xml'
				)
			)
			->notifiers(
				array(
					'git' => new Notifier_Git,
				)
			),
	),
);