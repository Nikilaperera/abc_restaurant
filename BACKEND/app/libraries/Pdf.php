<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * CodeIgniter PDF Library
 *
 * Generate PDF's in your CodeIgniter applications.
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Chris Harvey
 * @license			MIT License
 * @link			https://github.com/chrisnharvey/CodeIgniter-PDF-Generator-Library
 */
define("DOMPDF_FONT_HEIGHT_RATIO", 0.75);
//require_once(dirname(__FILE__) . '\dompdf\autoload.inc.php');
require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');


use Dompdf\Dompdf;

class Pdf
{
	var $html;
	var $path;
	var $filename;
	var $paper_size;
	var $orientation;
	/**
	 * Get an instance of CodeIgniter
	 *
	 * @access	protected
	 * @return	void
	 */
	function __construct($params = array())
	{
		$this->CI = &get_instance();

		if (count($params) > 0) {
			$this->initialize($params);
		}

		log_message('debug', 'PDF Class Initialized');
	}
	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	function initialize($params)
	{
		$this->clear();
		if (count($params) > 0) {
			foreach ($params as $key => $value) {
				if (isset($this->$key)) {
					$this->$key = $value;
				}
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Set html
	 *
	 * @access	public
	 * @return	void
	 */
	function html($html = NULL)
	{
		$this->html = $html;
	}

	// --------------------------------------------------------------------

	/**
	 * Set path
	 *
	 * @access	public
	 * @return	void
	 */
	function folder($path)
	{
		$this->path = $path;
	}

	// --------------------------------------------------------------------

	/**
	 * Set path
	 *
	 * @access	public
	 * @return	void
	 */
	function filename($filename)
	{
		$this->filename = $filename;
	}

	// --------------------------------------------------------------------


	//Anushka | 2022/10/17
	// --------------------------------------------------------------------
	/**
	 * Set path
	 *
	 * @access	public
	 * @return	void
	 */
	function password($password)
	{
		$this->password = $password;
	}

	// --------------------------------------------------------------------



	/**
	 * Set paper
	 *
	 * @access	public
	 * @return	void
	 */
	function paper($paper_size = NULL, $orientation = NULL)
	{
		$this->paper_size = $paper_size;
		$this->orientation = $orientation;
	}

	// --------------------------------------------------------------------


	/**
	 * Load a CodeIgniter view into domPDF
	 *
	 * @access	public
	 * @param	string	$view The view to load
	 * @param	array	$data The view data
	 * @return	void
	 */
	public function create($mode = 'download')
	{

		if (is_null($this->html)) {
			show_error("HTML is not set");
		}

		if (is_null($this->path)) {
			show_error("Path is not set");
		}

		if (is_null($this->paper_size)) {
			show_error("Paper size not set");
		}

		if (is_null($this->orientation)) {
			show_error("Orientation not set");
		}

		$dompdf = new DOMPDF();
		$dompdf->load_html($this->html, 'UTF-8');
		$dompdf->set_paper($this->paper_size, $this->orientation);
		$dompdf->set_option('defaultMediaType', 'all');
		$dompdf->set_option('isFontSubsettingEnabled', true);
		$dompdf->render();

		//Password Protection |Anushka | 2022/10/20
		$dompdf->getCanvas()
			->get_cpdf()
			->setEncryption($this->password);

		if ($mode == 'save') {
			$this->CI->load->helper('file');
			if (write_file($this->path . $this->filename, $dompdf->output())) {
				return $this->path . $this->filename;
			} else {
				show_error("PDF could not be written to the path");
			}
		} else {

			if ($dompdf->stream($this->filename)) {
				return TRUE;
			} else {
				show_error("PDF could not be streamed");
			}
		}
		/*$html = $this->ci()->load->view($view, $data, TRUE);

		$this->load_html($html);*/
	}
}
