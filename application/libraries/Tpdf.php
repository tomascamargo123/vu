<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Tpdf
{

	function Tpdf()
	{
		$CI = & get_instance();
	}

	function load($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false)
	{
		include_once APPPATH . '/third_party/tcpdf/tcpdf.php';

		return new TCPDF($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
	}
}