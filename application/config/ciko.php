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

$projects = array();

$project = new Model_Ciko_Project('Ciko');
$project->repository('git://github.com/zombor/Ciko.git');
$project->branch('master');
$project->runner('ls -l');

$projects['ciko'] = $project;

return array(
	'clone_path' => '/tmp/', // Full path to where projects will be cloned
	'projects' => $projects, // An array of projects to run
);