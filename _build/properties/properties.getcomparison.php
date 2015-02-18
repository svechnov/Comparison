<?php

$properties = array();

$tmp = array(
	'tpl' => array(
		'type' => 'textfield',
		'value' => 'tpl.Comparison.get',
	),
	'list' => array(
		'type' => 'textfield',
		'value' => 'default',
	),
);

foreach ($tmp as $k => $v) {
	$properties[] = array_merge(
		array(
			'name' => $k,
			'desc' => PKG_NAME_LOWER . '_prop_' . $k . '_get',
			'lexicon' => PKG_NAME_LOWER . ':properties',
		), $v
	);
}

return $properties;