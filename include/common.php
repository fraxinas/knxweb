<?

	require_once('include/config.inc.php');
	require_once('include/tpl.php');
	require_once('include/lang.php');

	$_objectTypes = array(
	    '1.001' => '1.001: switching (on/off) (EIS1)',
	    '3.007' => '3.007: dimming (EIS2)',
	    '3.008' => '3.008: blinds',
	    '5.xxx' => '5.xxx: 8bit unsigned integer (EIS6)',
	    '5.001' => '5.001: scaling (from 0 to 100%)',
	    '5.003' => '5.003: angle (from 0 to 360deg)',
	    '6.xxx' => '6.xxx: 8bit signed integer (EIS14)',
	    '7.xxx' => '7.xxx: 16bit unsigned integer (EIS10)',
	    '8.xxx' => '8.xxx: 16bit signed integer',
	    '9.xxx' => '9.xxx: 16 bit floating point number (EIS5)',
	    '10.001' => '10.001: time (EIS3)',
	    '11.001' => '11.001: date (EIS4)',
	    '12.xxx' => '12.xxx: 32bit unsigned integer (EIS11)',
	    '13.xxx' => '13.xxx: 32bit signed integer',
	    '14.xxx' => '14.xxx: 32 bit IEEE 754 floating point number',
	    '16.000' => '16.000: string (EIS15)',
	    '20.102' => '20.102: heating mode',
	    '29.xxx' => '29.xxx: signed 64bit value'
	);
	
	$_objectFlags = array(
		'c' => 'Communication',
		'r' => 'Read',
		'w' => 'Write',
		't' => 'Transmit',
		'u' => 'Update',
		'f' => 'Force',
		'i' => 'Init'
	);

	function getWidgets()
	{
		$plugins = glob('widgets/*', GLOB_ONLYDIR);
		$ret=array();
		foreach ($plugins as $path)
		{
			if (file_exists($path . '/manifest.xml'))
			{
				$xml = simplexml_load_file($path . '/manifest.xml');
				$ret[(string)$xml->name]=array(
					"path"	=>	$path,
					"label"	=>	(string)$xml->label,
					"description"	=>	(string)$xml->description,
					"version" => (string)$xml->version,
					"category" => (string)$xml->category
				);
			}
		}
		return $ret;
	}

	function getWidgetsByCategory()
	{
		$plugins = glob('widgets/*', GLOB_ONLYDIR);
		$ret=array();
		foreach ($plugins as $path)
		{
			if (file_exists($path . '/manifest.xml'))
			{
				$xml = simplexml_load_file($path . '/manifest.xml');
				if (!isset($ret[(string)$xml->category])) $ret[(string)$xml->category]=array();
				$ret[(string)$xml->category][]=array(
					"name" 	=>	(string)$xml->name,
					"path"	=>	$path,
					"label"	=>	(string)$xml->label,
					"description"	=>	(string)$xml->description,
					"version" => (string)$xml->version
				);
			}
		}
		return $ret;
	}
	
	function addWidgetsJsCssToTpl($isEdit = false)
	{
		$widgets = getWidgets();
		foreach($widgets as $name => $info)
		{
//			tpl()->addJs($info['path'] . '/js/display.js');
//			if ($isEdit) tpl()->addJs($info['path'] . '/js/edit.js');
			if (file_exists($info['path'] . '/widget.css')) tpl()->addCss($info['path'] . '/widget.css');
		}
	}
	
?>