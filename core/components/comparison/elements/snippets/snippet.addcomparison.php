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
if (empty($list)) {$list = 'cmp';}
if (empty($id)) {$id = $modx->resource->id;}
if (empty($minItems)) {$minItems = 2;}
if (empty($maxItems)) {$maxItems = 10;}
if (empty($id)) {$id = $modx->resource->id;}
if (empty($list_id) || !is_numeric($list_id)) {
	return $modx->lexicon('comparison_err_no_list_id');
}

$ids = !empty($_SESSION['Comparison'][$modx->context->key][$list])
	? $_SESSION['Comparison'][$modx->context->key][$list]['ids']
	: array();
$_SESSION['Comparison'][$modx->context->key][$list] = array(
	'list_id' => $list_id,
	'minItems' => $minItems,
	'maxItems' => $maxItems,
	'ids' => $ids,
);

$pls = array(
	'list' => $list,
	'id' => $id,
	'list_id' => $list_id,
	'added' => isset($ids[$id]),
	'can_compare' => count($ids) > 1,
	'total' => count($ids),
);

$link_params = array();
if ($list != 'default') {
	$link_params['list'] = $list;
}
if (!empty($ids)) {
	$link_params['cmp_ids'] = implode(',', array_keys($ids));
}
$pls['link'] = !empty($link_params['cmp_ids'])
	? urldecode($modx->context->makeUrl($list_id, $link_params, $modx->getOption('link_tag_scheme')))
	: '#';

$modx->regClientScript('<script type="text/javascript">Comparison.add.initialize(".comparison-'.$list.'", {minItems:'.$minItems.'});</script>', true);
return $pdoTools->getChunk($tpl, $pls);