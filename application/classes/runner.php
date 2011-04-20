<?php
/**
 * Interface for reporters
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2011 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
class Runner
{
	// Inputs
	protected $_command = NULL;
	protected $_cwd = NULL;
	protected $_env = NULL;

	// Outputs
	protected $_status = NULL;
	protected $_stdout = NULL;
	protected $_stderr = NULL;

	/**
	 * Creates a new instance of Runner
	 *
	 * @return Runner
	 */
	public static function factory($command, $cwd, $env = NULL)
	{
		return new Runner($command, $cwd, $env);
	}

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct($command, $cwd, $env = NULL)
	{
		$this->_command = $command;
		$this->_cwd = $cwd;
		$this->_env = $env;
	}

	/**
	 * Run the specified command
	 *
	 * @return bool
	 */
	public function execute()
	{
		$descriptorspec = array(
			1 => array('pipe', 'w'),
			2 => array('pipe', 'w'),
		);

		$pipes = array();
		
		$resource = proc_open(
			escapeshellcmd($this->_command),
			$descriptorspec,
			$pipes,
			$this->_cwd,
			$this->_env
		);

		// Capture the runner output
		$this->_stdout = stream_get_contents($pipes[1]);
		$this->_stderr = stream_get_contents($pipes[2]);

		foreach ($pipes as $pipe)
		{
			fclose($pipe);
		}

		$status = trim(proc_close($resource));

		// Invert the return from proc_close
		$this->_status = ! $status ? TRUE : FALSE;

		return $this->_status;
	}

	/**
	 * Gets the command status
	 *
	 * @return string
	 */
	public function status()
	{
		return $this->_status;
	}

	/**
	 * Gets the contents of STDOUT
	 *
	 * @return string
	 */
	public function stdout()
	{
		return $this->_stdout;
	}

	/**
	 * Gets the contents of STDERR
	 *
	 * @return string
	 */
	public function stderr()
	{
		return $this->_stderr;
	}
}