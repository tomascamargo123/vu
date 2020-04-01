<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('auto_version'))
{

	function auto_version($url)
	{
		if (strpos($url, '/ckeditor/'))
		{
			return $url;
		}
		$path = pathinfo($url);
		$string = $path['basename'];
		$ver = '.';
		//$ver = '.version' . filemtime($_SERVER['DOCUMENT_ROOT'] . DIRECTORIO . $url) . '.';
		//var_dump($ver);var_dump($path);die();
		$str = '.';
		if (( $pos = strrpos($string, $str) ) !== false)
		{
			$search_length = strlen($str);
			$str = substr_replace($string, $ver, $pos, $search_length);
			return $path['dirname'] . '/' . $str;
		}
		else
			return $url;
	}
}

if (!function_exists('lm'))
{

	function lm($message)
	{
		log_message('error', print_r($message, TRUE));
	}
}

/* End of file zetta_helper.php */
/* Location: ./application/helpers/zetta_helper.php */