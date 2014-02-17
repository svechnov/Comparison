<?php

$properties = array();

$tmp = array(
	'fields' => array(
		'type' => 'textfield',
		'value' => '{"default":["price","article","vendor.name","color","size"]}',
	),

	'tplRow' => array(
		'type' => 'textfield',
		'value' => 'tpl.Comparison.row',
	),
	'tplParam' => array(
		'type' => 'textfield',
		'value' => 'tpl.Comparison.param',
	),
	'tplCell' => array(
		'type' => 'textfield',
		'value' => 'tpl.Comparison.cell',
	),
	'tplHead' => array(
		'type' => 'textfield',
		'value' => 'tpl.Comparison.head',
	),
	'tplCorner' => array(
		'type' => 'textfield',
		'value' => 'tpl.Comparison.corner',
	),
	'tplOuter' => array(
		'type' => 'textfield',
		'value' => 'tpl.Comparison.outer',
	),

	'minItems' => array(
		'type' => 'numberfield',
		'value' => 2,
	),
	'maxItems' => array(
		'type' => 'numberfield',
		'value' => 10,
	),

	'formatSnippet' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'showLog' => array(
		'type' => 'combo-boolean',
		'value' => false,
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