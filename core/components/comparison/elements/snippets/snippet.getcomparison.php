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

if (!empty($_SESSION['Comparison'][$list])) {
	$items = $_SESSION['Comparison'][$list];
	$count = count($items['ids']);
	if ($count >= $items['minItems']) {
		$can_compare = true;
	}
	$link = $modx->makeUrl($items['list_id'], '', array('cmp_ids' => implode(',', $items['ids'])));
	$added = $modx->resource->id != $items['list_id'];
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