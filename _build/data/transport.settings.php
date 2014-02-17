<?php

$settings = array();

$tmp = array(
	'frontend_js' => array(
		'xtype' => 'textfield',
		'value' => '[[+assetsUrl]]js/default.js',
		'area' => 'comparison_main',
	),
	'frontend_css' => array(
		'xtype' => 'textfield',
		'value' => '[[+assetsUrl]]css/default.css',
		'area' => 'comparison_main',
	),
);

foreach ($tmp as $k => $v) {
	/* @var modSystemSetting $setting */
	$setting = $modx->newObject('modSystemSetting');
	$setting->fromArray(array_merge(
		array(
			'key' => 'comparison_'.$k,
			'namespace' => PKG_NAME_LOWER,
		), $v
	),'',true,true);

	$settings[] = $setting;
}

unset($tmp);
return $settings;
