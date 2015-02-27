<?php
/** @var array $scriptProperties */
$modx->lexicon->load('comparison:default');

/** @var pdoTools $pdoTools */
$fqn = $modx->getOption('pdoTools.class', null, 'pdotools.pdotools', true);
if (!$pdoClass = $modx->loadClass($fqn, '', false, true)) {return false;}
$scriptProperties['nestedChunkPrefix'] = 'comparison_';
$pdoTools = new $pdoClass($modx, $scriptProperties);

$list = trim($modx->getOption('list', $scriptProperties, 'default'));
$tpl = $modx->getOption('tpl', $scriptProperties, 'tpl.Comparison.get');

if (!empty($_SESSION['Comparison'][$modx->context->key][$list])) {
	$params = $_SESSION['Comparison'][$modx->context->key][$list];
	$count = count($params['ids']);
	if ($count >= $params['minItems']) {
		$can_compare = true;
	}
	$added = $modx->resource->id != $params['list_id'];

	$link_params = array();
	if ($list != 'default') {
		$link_params['list'] = $list;
	}
	$link_params['cmp_ids'] = implode(',', array_keys($params['ids']));
	$link = $modx->makeUrl($params['list_id'], '', $link_params);
}
else {
	$link = '#';
	$can_compare = $added = false;
	$count = 0;
}

return $pdoTools->getChunk($tpl, array(
	'link' => $link,
	'count' => $count,
	'list' => $list,
	'can_compare' => $can_compare,
	'added' => $added
));