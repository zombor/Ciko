<?php
/**
 * Tests for Model_Ciko_Project
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2011 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
class Test_Model_CikoProject extends PHPUnit_Framework_TestCase
{
	/**
	 * Provider for test_name()
	 *
	 * @return array
	 */
	public function provider_name()
	{
		return array(
			array('Ciko', 'Ciko'),
			array('Ciko Project', 'Ciko Project'),
			array('Ciko-Project', 'Ciko-Project'),
		);
	}
	/**
	 * Tests the name() method
	 * 
	 * @dataProvider provider_name
	 *
	 * @return null
	 */
	public function test_name($input, $return)
	{
		$project = new Model_Ciko_Project($input);
		$this->assertSame($return, $project->name());

		$temp_project = $project->name($input);
		$this->assertSame($return, $project->name());
		$this->assertInstanceOf('Model_Ciko_Project', $temp_project);
	}

	/**
	 * Provider for test_safe_name()
	 *
	 * @return array
	 */
	public function provider_safe_name()
	{
		return array(
			array('Ciko', 'ciko'),
			array('Ciko Project', 'ciko-project'),
			array('Ciko-Project', 'ciko-project'),
		);
	}
	/**
	 * Tests the safe_name() method
	 * 
	 * @dataProvider provider_safe_name
	 *
	 * @return null
	 */
	public function test_safe_name($input, $return)
	{
		$project = new Model_Ciko_Project($input);
		$this->assertSame($return, $project->safe_name());
	}

	/**
	 * Provider for test_repository()
	 *
	 * @return array
	 */
	public function provider_repository()
	{
		return array(
			array(
				'git://github.com/zombor/Ciko.git',
				'git://github.com/zombor/Ciko.git'
			),
		);
	}
	/**
	 * Tests the repository() method
	 * 
	 * @dataProvider provider_repository
	 *
	 * @return null
	 */
	public function test_repository($input, $return)
	{
		$project = new Model_Ciko_Project('Ciko');
		$temp_project = $project->repository($input);
		$this->assertSame($return, $project->repository());
		$this->assertInstanceOf('Model_Ciko_Project', $temp_project);
	}

	/**
	 * Provider for test_branch()
	 *
	 * @return array
	 */
	public function provider_branch()
	{
		return array(
			array('master', 'master'),
			array('develop', 'develop'),
		);
	}
	/**
	 * Tests the branch() method
	 * 
	 * @dataProvider provider_branch
	 *
	 * @return null
	 */
	public function test_branch($input, $return)
	{
		$project = new Model_Ciko_Project('Ciko');
		$temp_project = $project->branch($input);
		$this->assertSame($return, $project->branch());
		$this->assertInstanceOf('Model_Ciko_Project', $temp_project);
	}

	/**
	 * Provider for test_runner()
	 *
	 * @return array
	 */
	public function provider_runner()
	{
		return array(
			array('phpunit', 'phpunit'),
		);
	}
	/**
	 * Tests the runner() method
	 * 
	 * @dataProvider provider_runner
	 *
	 * @return null
	 */
	public function test_runner($input, $return)
	{
		$project = new Model_Ciko_Project('Ciko');
		$temp_project = $project->runner($input);
		$this->assertSame($return, $project->runner());
		$this->assertInstanceOf('Model_Ciko_Project', $temp_project);
	}

	/**
	 * Provider for test_reporters()
	 *
	 * @return array
	 */
	public function provider_reporters()
	{
		return array(
			array(
				array(
					new Reporter_Clover('build/clover.xml'),
				)
			),
		);
	}
	/**
	 * Tests the reporters() method
	 * 
	 * @dataProvider provider_reporters
	 *
	 * @return null
	 */
	public function test_reporters($input)
	{
		$project = new Model_Ciko_Project('Ciko');
		$temp_project = $project->reporters($input);
		$this->assertSame($input, $project->reporters());
		$this->assertInstanceOf('Model_Ciko_Project', $temp_project);
	}

	/**
	 * Tests that reporters() only accepts an array of Reporter objects
	 * 
	 * @expectedException Kohana_Exception
	 *
	 * @return null
	 */
	public function test_reporters_only_accepts_reporter_objects()
	{
		$this->markTestSkipped();

		$project = new Model_Ciko_Project('Ciko');
		$project->reporters(array('foo'));
	}

	/**
	 * Provider for test_notifiers()
	 *
	 * @return array
	 */
	public function provider_notifiers()
	{
		return array(
			array(
				array(
					new Notifier_IRC(
						'irc.freenode.net', array('#kohana','#kohana-dev')
					)
				)
			),
		);
	}
	/**
	 * Tests the notifiers() method
	 * 
	 * @dataProvider provider_notifiers
	 *
	 * @return null
	 */
	public function test_notifiers($input)
	{
		$project = new Model_Ciko_Project('Ciko');
		$temp_project = $project->notifiers($input);
		$this->assertSame($input, $project->notifiers());
		$this->assertInstanceOf('Model_Ciko_Project', $temp_project);
	}

	/**
	 * Tests that reporters() only accepts an array of Reporter objects
	 * 
	 * @expectedException Kohana_Exception
	 *
	 * @return null
	 */
	public function test_notifiers_only_accepts_notifier_objects()
	{
		$project = new Model_Ciko_Project('Ciko');
		$project->notifiers(array('foobar' => 'foo'));
	}
}