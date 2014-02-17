<?php
/** @var array $scriptProperties */
/** @var Comparison $Comparison */
$Comparison = $modx->getService('comparison','Comparison',$modx->getOption('comparison_core_path',null,$modx->getOption('core_path').'components/comparison/').'model/comparison/',$scriptProperties);
if (!($Comparison instanceof Comparison)) return '';
$Comparison->initialize($modx->context->key);
/** @var pdoTools $pdoTools */
$fqn = $modx->getOption('pdoTools.class', null, 'pdotools.pdotools', true);
if (!$pdoClass = $modx->loadClass($fqn, '', false, true)) {return false;}
$scriptProperties['nestedChunkPrefix'] = 'comparison_';
$pdoTools = new $pdoClass($modx, $scriptProperties);

if (empty($tpl)) {$tpl = 'tpl.Comparison.add';}
if (empty($cat)) {$cat = 'cmp';}
if (empty($id)) {$id = $modx->resource->id;}
if (empty($minItems)) {$minItems = 2;}
if (empty($maxItems)) {$maxItems = 10;}
if (empty($id)) {$id = $modx->resource->id;}
if (empty($list_id) || !is_numeric($list_id)) {
	return $modx->lexicon('comparison_err_no_list_id');
}

$ids = !empty($_SESSION['Comparison'][$cat])
	? $_SESSION['Comparison'][$cat]['ids']
	: array();
$_SESSION['Comparison'][$cat] = array(
	'list_id' => $list_id,
	'minItems' => $minItems,
	'maxItems' => $maxItems,
	'ids' => $ids,
);

$pls = array(
	'cat' => $cat,
	'id' => $id,
	'list_id' => $list_id,
	'added' => isset($ids[$id]),
	'can_compare' => count($ids) > 1,
	'total' => count($ids),
);

$link_params = array('cmp_ids' => implode(',', array_keys($ids)));
if ($cat != 'default') {
	$link_params['cat'] = $cat;
}
$pls['link'] = urldecode($modx->context->makeUrl($list_id, $link_params, $modx->getOption('link_tag_scheme')));

$modx->regClientScript('<script type="text/javascript">Comparison.add.initialize(".comparison-'.$cat.'", {minItems:'.$minItems.'});</script>', true);
return $pdoTools->getChunk($tpl, $pls);