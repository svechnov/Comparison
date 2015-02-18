<?php

$chunks = array();

$tmp = array(
	'tpl.Comparison.add' => array(
		'file' => 'add',
		'description' => '',
	),
	'tpl.Comparison.get' => array(
		'file' => 'get',
		'description' => '',
	),
	'tpl.Comparison.outer' => array(
		'file' => 'table_outer',
		'description' => '',
	),
	'tpl.Comparison.corner' => array(
		'file' => 'table_corner',
		'description' => '',
	),
	'tpl.Comparison.head' => array(
		'file' => 'table_head',
		'description' => '',
	),
	'tpl.Comparison.param' => array(
		'file' => 'table_param',
		'description' => '',
	),
	'tpl.Comparison.row' => array(
		'file' => 'table_row',
		'description' => '',
	),
	'tpl.Comparison.cell' => array(
		'file' => 'table_cell',
		'description' => '',
	),
);

// Save chunks for setup options
$BUILD_CHUNKS = array();

foreach ($tmp as $k => $v) {
	/* @avr modChunk $chunk */
	$chunk = $modx->newObject('modChunk');
	$chunk->fromArray(array(
		'id' => 0,
		'name' => $k,
		'description' => @$v['description'],
		'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/chunk.'.$v['file'].'.tpl'),
		'static' => BUILD_CHUNK_STATIC,
		'source' => 1,
		'static_file' => 'core/components/'.PKG_NAME_LOWER.'/elements/chunks/chunk.'.$v['file'].'.tpl',
	),'',true,true);

	$chunks[] = $chunk;

	$BUILD_CHUNKS[$k] = file_get_contents($sources['source_core'].'/elements/chunks/chunk.'.$v['file'].'.tpl');
}

unset($tmp);
return $chunks;