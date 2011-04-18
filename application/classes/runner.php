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
	protected $command = NULL;
	protected $cwd = NULL;
	protected $env = NULL;

	// Outputs
	protected $status = NULL;
	protected $stdout = NULL;
	protected $stderr = NULL;

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
		$this->command = $command;
		$this->cwd = $cwd;
		$this->env = $env;
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
			escapeshellcmd($this->command),
			$descriptorspec,
			$pipes,
			$this->cwd,
			$this->env
		);

		// Capture the runner output
		$this->stdout = stream_get_contents($pipes[1]);
		$this->stderr = stream_get_contents($pipes[2]);

		foreach ($pipes as $pipe)
		{
			fclose($pipe);
		}

		$status = trim(proc_close($resource));

		// Invert the return from proc_close
		$this->status = ! $status ? TRUE : FALSE;

		return $this->status;
	}

	/**
	 * Gets the command status
	 *
	 * @return string
	 */
	public function status()
	{
		return $this->status;
	}

	/**
	 * Gets the contents of STDOUT
	 *
	 * @return string
	 */
	public function stdout()
	{
		return $this->stdout;
	}

	/**
	 * Gets the contents of STDERR
	 *
	 * @return string
	 */
	public function stderr()
	{
		return $this->stderr;
	}
}