<?php

$properties = array();

$tmp = array(
	'tpl' => array(
		'type' => 'textfield',
		'value' => 'tpl.Comparison.add',
	),
	'cat' => array(
		'type' => 'textfield',
		'value' => 'default',
	),
	'list_id' => array(
		'type' => 'numberfield',
		'value' => 0,
	),
	'minItems' => array(
		'type' => 'numberfield',
		'value' => 2,
	),
	'maxItems' => array(
		'type' => 'numberfield',
		'value' => 10,
	),
);

foreach ($tmp as $k => $v) {
	$properties[] = array_merge(
		array(
			'name' => $k,
			'desc' => PKG_NAME_LOWER . '_prop_' . $k,
			'lexicon' => PKG_NAME_LOWER . ':properties',
		), $v
	);
}

return $properties;