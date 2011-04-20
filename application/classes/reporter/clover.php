<?php
/**
 * Reporter class for Clover output
 *
 * @package    Ciko
 * @author     Jeremy Bush
 * @copyright  (c) 2011 Jeremy Bush
 * @license    http://github.com/zombor/Ciko/raw/develop/LICENSE
 */
class Reporter_Clover extends Reporter
{
	protected $_name = 'clover';

	/**
	 * Method for analyzing reports
	 *
	 * @return bool
	 */
	public function analyze()
	{
		// Analysis was sucessful
		return TRUE;
	}

	/**
	 * Method for rendering results as HTML
	 *
	 * @return string
	 */
	public function render_html()
	{
		// Dummy output
		return '<ul><li>Covered Methods: 50%</li><li></li>Covered Classes: 10%</ul>';
	}
}