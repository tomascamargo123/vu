<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chartjs
{

	private $shared_opts = array();
	private $opts = array();
	private $replace_keys, $orig_keys;

	public function __construct()
	{
		$this->initialize();
	}

	public function clear($shared = FALSE)
	{
		$this->opts = array();
		$this->initialize();
		if ($shared === TRUE)
		{
			$this->shared_opts = array();
		}

		return $this;
	}

	private function delimit_function($string = '')
	{
		if (strpos($string, 'function(') !== FALSE)
		{
			$this->orig_keys[] = $string;
			$string = '$$' . $string . '$$';
			$this->replace_keys[] = json_encode($string);
		}
		return $string;
	}

	public function encode($options)
	{
		$options = json_encode($options);
		return str_replace($this->replace_keys, $this->orig_keys, $options);
	}

	private function encode_function($array = array())
	{
		if (is_string($array))
		{
			$array = $this->delimit_function($array);
		}
		else if (is_array($array))
		{
			foreach ($array as $key => $value)
			{
				if (is_array($value))
				{
					$this->encode_function($value);
				}
				else
				{
					if ((is_string($value)))
					{
						$array[$key] = $this->delimit_function($value);
					}
				}
			}
		}
		return $array;
	}

	public function from_result($data = array())
	{
		if (!empty($data['data']))
		{
			$cant = 0;
			foreach ($data['data'] as $row)
			{
				$serie = 0;
				foreach ($data['series'] as $serie_name => $serie_value)
				{
					if ($serie === 0)
					{
						$this->opts['data']['labels'][] = $row->label;
					}
					switch ($this->opts['chart']['type'])
					{
						case 'line':
						case 'bar':
						case 'horizontalBar':
							$color = isset($this->opts['chart']['colors'][$serie]) ? $this->opts['chart']['colors'][$serie] : "rgba(" . rand(0, 255) . ", " . rand(0, 255) . ", " . rand(0, 255) . ", 1)";
							$this->opts['data']['datasets'][$serie]['label'] = $serie_value;
							$this->opts['data']['datasets'][$serie]['backgroundColor'] = $color;
							$this->opts['data']['datasets'][$serie]['lineTension'] = 0;
							break;
						case 'doughnut':
						case 'pie':
							$color = isset($this->opts['chart']['colors'][$cant]) ? $this->opts['chart']['colors'][$cant] : "rgba(" . rand(0, 255) . ", " . rand(0, 255) . ", " . rand(0, 255) . ", 1)";
							$this->opts['data']['datasets'][$serie]['backgroundColor'][] = $color;
							break;
					}
					$this->opts['data']['datasets'][$serie]['data'][] = $row->$serie_name;
					$serie++;
				}
				$cant++;
			}
		}
		else
		{
			$this->opts['data']['labels'][] = 'Sin Datos';
			$this->opts['data']['datasets'][0]['label'] = 'Sin Datos';
			$this->opts['data']['datasets'][0]['data'][] = 0;
		}

		return $this;
	}

	public function initialize()
	{
		$this->opts['chart']['renderTo'] = 'chartjs';
		$this->opts['chart']['height'] = 200;
		$this->opts['chart']['colors'] = array("rgba(5, 141, 199, 1)", "rgba(221, 223, 0, 1)", "rgba(255, 150, 85, 1)", "rgba(106, 249, 196, 1)", "rgba(167, 127, 255, 1)", "rgba(80, 180, 50, 1)", "rgba(237, 86, 50, 1)", "rgba(255, 242, 99, 1)", "rgba(255, 127, 215, 1)", "rgba(204, 204, 204, 1)");
	}

	public function render()
	{
		$divs = '';
		$embed = '<script type="text/javascript">' . "\n";
		$embed .= 'var ' . $this->opts['chart']['renderTo'] . 'Canvas;' . "\n";
		$embed .= 'var ' . $this->opts['chart']['renderTo'] . 'Options = {};' . "\n";
		$embed .= 'var ' . $this->opts['chart']['renderTo'] . 'Data;' . "\n";
		$embed .= 'var ' . $this->opts['chart']['renderTo'] . ';' . "\n";
		$embed .= '$(function(){' . "\n";
		$embed .= $this->opts['chart']['renderTo'] . 'Canvas = $("#' . $this->opts['chart']['renderTo'] . '");' . "\n";
		if (count($this->shared_opts) > 0)
		{
			$embed .= $this->opts['chart']['renderTo'] . 'Options = ' . $this->encode($this->shared_opts) . ';' . "\n";
		}
		$embed .= $this->opts['chart']['renderTo'] . 'Data = ' . $this->encode($this->opts['data']) . ';' . "\n";
		$embed .= $this->opts['chart']['renderTo'] . ' = new Chart(' . $this->opts['chart']['renderTo'] . 'Canvas,{type:\'' . $this->opts['chart']['type'] . '\', data: ' . $this->opts['chart']['renderTo'] . 'Data, options: ' . $this->opts['chart']['renderTo'] . 'Options});' . "\n";
		$divs .= '<canvas id="' . $this->opts['chart']['renderTo'] . '" height="' . $this->opts['chart']['height'] . '"></canvas>' . "\n";
		if (!empty($this->opts['chart']['legend_div']))
		{
			$embed .= 'document.getElementById("' . $this->opts['chart']['legend_div'] . '").innerHTML = ' . $this->opts['chart']['renderTo'] . '.generateLegend();' . "\n";
		}
		$embed .= '});' . "\n";
		$embed .= '</script>' . "\n";
		$embed .= $divs;
		return $embed;
	}

	public function get_data()
	{
		return $this->opts['data'];
	}

	public function render_to($id = '')
	{
		$this->opts['chart']['renderTo'] = $id;

		return $this;
	}

	public function set_colors($options = array())
	{
		$colors = array();
		foreach ($options as $opt_key => $opt_name)
		{
			$colors[] = $this->encode_function($opt_name);
		}
		$this->opts['chart']['colors'] = $colors;

		return $this;
	}

	public function set_global_options($options = array())
	{
		if (!empty($options))
		{
			$this->shared_opts = $this->set_local_options($options);
		}

		return $this;
	}

	public function set_height($height = 0)
	{
		$this->opts['chart']['height'] = $height;

		return $this;
	}

	public function set_legend_div($div = NULL)
	{
		if ($div AND is_string($div))
		{
			$this->opts['chart']['legend_div'] = $div;
		}

		return $this;
	}

	private function set_local_options($options = array(), $root = array())
	{
		foreach ($options as $opt_key => $opt_name)
		{
			if (is_string($opt_key))
			{
				if (is_object($opt_name))
				{
					$root[$opt_key] = array();
					$root[$opt_key] = $this->set_local_options($opt_name, $root[$opt_key]); // convert back to array
				}
				else
				{
					$root[$opt_key] = $this->encode_function($opt_name);
				}
			}
			else
			{
				$root[] = array();
				$root[count($root) - 1] = $this->set_local_options($opt_name, $root[count($root) - 1]);
			}
		}
		return $root;
	}

	public function set_type($type = '')
	{
		if ($type AND is_string($type))
		{
			$this->opts['chart']['type'] = $type;
		}

		return $this;
	}
}