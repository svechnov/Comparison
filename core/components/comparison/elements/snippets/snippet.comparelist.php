<?php
/** @var array $scriptProperties */
/** @var Comparison $Comparison */
$Comparison = $modx->getService('comparison','Comparison',$modx->getOption('comparison_core_path',null,$modx->getOption('core_path').'components/comparison/').'model/comparison/',$scriptProperties);
if (!($Comparison instanceof Comparison)) return '';
$Comparison->initialize($modx->context->key);
/** @var pdoFetch $pdoFetch */
$fqn = $modx->getOption('pdoFetch.class', null, 'pdotools.pdofetch', true);
if (!$pdoClass = $modx->loadClass($fqn, '', false, true)) {return false;}
$pdoFetch = new $pdoClass($modx, $scriptProperties);

$list = !empty($_REQUEST['list'])
	? (string) $_REQUEST['list']
	: 'default';
if (empty($_SESSION['Comparison'][$modx->context->key][$list]) && empty($_REQUEST['cmp_ids'])) {
	return $modx->lexicon('comparison_err_no_list');
}

if (empty($fields)) {$fields = '{"default":["price","article","vendor.name","color","size"]}';}
if (empty($tplRow)) {$tplRow = 'tpl.Comparison.row';}
if (empty($tplParam)) {$tplParam = 'tpl.Comparison.param';}
if (empty($tplCell)) {$tplCell = 'tpl.Comparison.cell';}
if (empty($tplHead)) {$tplHead = 'tpl.Comparison.head';}
if (empty($tplCorner)) {$tplCorner = 'tpl.Comparison.corner';}
if (empty($tplOuter)) {$tplOuter = 'tpl.Comparison.outer';}
if (empty($minItems)) {$minItems = 2;}
if (empty($maxItems)) {$maxItems = 10;}
if (!isset($scriptProperties['showUnpublished'])) {$scriptProperties['showUnpublished'] = false;}
if (!isset($scriptProperties['showDeleted'])) {$scriptProperties['showDeleted'] = false;}

$fields = $modx->fromJSON($fields);
if (empty($fields) || !is_array($fields)) {
	return $modx->lexicon('comparison_err_wrong_fields');
}
elseif (!isset($fields[$list])) {
	if ($modx->user->isAuthenticated('mgr')) {
		return $modx->lexicon('comparison_err_wrong_list', array('list' => $list));
	}
	else {
		return $modx->lexicon('comparison_err_no_list');
	}
}
$fields = $fields[$list];

$format = null;
if (!empty($formatSnippet)) {
	/** @var modSnippet $format */
	$format = $modx->getObject('modSnippet', array('name' => $formatSnippet));
}

// Joining MS2 tables
if (file_exists(MODX_CORE_PATH . 'components/minishop2/model/minishop2/minishop2.class.php')) {
	$class = 'msProduct';
	$leftJoin = array(
		array('class' => 'msProductData', 'alias' => 'Data', 'on' => '`'.$class.'`.`id`=`Data`.`id`'),
		array('class' => 'msVendor', 'alias' => 'Vendor', 'on' => '`Data`.`vendor`=`Vendor`.`id`'),
	);

	$select = array(
		$class => !empty($includeContent) ?  $modx->getSelectColumns($class, $class) : $modx->getSelectColumns($class, $class, '', array('content'), true),
		'Data' => $modx->getSelectColumns('msProductData', 'Data', '', array('id'), true),
		'Vendor' => $modx->getSelectColumns('msVendor', 'Vendor', 'vendor.', array('id'), true),
	);

	$thumbsSelect = array();
	if (!empty($includeThumbs)) {
		$thumbs = array_map('trim',explode(',',$includeThumbs));
		if(!empty($thumbs[0])){
			foreach ($thumbs as $thumb) {
				$leftJoin[] = array(
					'class' => 'msProductFile',
					'alias' => $thumb,
					'on' => "`$thumb`.`product_id` = `{$class}`.`id` AND `$thumb`.`parent` != 0 AND `$thumb`.`path` LIKE '%/$thumb/'"
				);
				$select[$thumb] = "`$thumb`.`url` as `$thumb`";
			}
		}
	}
}
else {
	$class = 'modResource';
	$leftJoin = $select = array();
}

// Add custom parameters
foreach (array('leftJoin','select') as $v) {
	if (!empty($scriptProperties[$v])) {
		$tmp = $modx->fromJSON($scriptProperties[$v]);
		if (is_array($tmp)) {
			$$v = array_merge($$v, $tmp);
		}
	}
	unset($scriptProperties[$v]);
}

$ids = !empty($_SESSION['Comparison'][$modx->context->key][$list]['ids'])
	? array_keys($_SESSION['Comparison'][$modx->context->key][$list]['ids'])
	: explode(',', preg_replace('/[^0-9\,]/', '', $_REQUEST['cmp_ids']));

$properties = array(
	'class' => $class,
	'parents' => 0,
	'resources' => implode(',', $ids),
	'includeTVs' => implode(',', $fields),
	'leftJoin' => $leftJoin,
	'select' => $select,
	'return' => 'data',
	'nestedChunkPrefix' => 'comparison_'
);
$pdoFetch->setConfig(array_merge($scriptProperties, $properties), false);
$resources = $pdoFetch->run();

$output = $rows = '';
if (count($ids) < $minItems) {
	$output = $modx->lexicon('comparison_err_min_count');
}
elseif (count($ids) > $maxItems) {
	$output = $modx->lexicon('comparison_err_max_resource');
}
else {
	$row_idx = 1;
	foreach ($fields as $field) {
		$cells = $pdoFetch->getChunk($tplParam, array('field' => $field, 'param' => $modx->lexicon('comparison_field_'.$field)));
		$cell_idx = 1;
		$previous_value = null;
		$same = true;
		foreach ($resources as $resource) {
			$value = array_key_exists($field, $resource)
				? $resource[$field]
				: null;
			// Send value to special snippet
			if ($format) {
				$format->_cacheable = false;
				$format->_processed = false;
				$format->_content = '';
				$value = $format->process(array(
					'name' => $field,
					'field' => $field,
					'input' => $value,
					'value' => $value,
					'resource' => $resource,
					'pdoTools' => $pdoFetch,
					'pdoFetch' => $pdoFetch,
				));
			}
			else {
				if (is_array($value)) {
					natsort($value);
					$value = implode(',', $value);
				}
				/** @var miniShop2 $miniShop2 */
				if ($class == 'msProduct' && $miniShop2 = $modx->getService('minishop2')) {
					switch ($field) {
						case 'price':
							$value = $miniShop2->formatPrice($value) . ' ' . $modx->lexicon('ms2_frontend_currency');
							break;
						case 'weight':
							$value = $miniShop2->formatWeight($value) . ' ' . $modx->lexicon('ms2_frontend_weight_unit');
							break;
					}
				}
			}

			if ($same && $cell_idx > 1) {
				$same = $previous_value == $value;
			}
			$cells .= $pdoFetch->getChunk($tplCell, array('value' => $value, 'cell_idx' => $cell_idx ++, 'classes' => ' field-'.$field));
			$previous_value = $value;
		}
		$rows .= $pdoFetch->getChunk($tplRow, array('cells' => $cells, 'row_idx' => $row_idx ++, 'same' => $same));
	}

	$cells = $pdoFetch->getChunk($tplCorner);
	foreach ($resources as $resource) {
		$cells .= $pdoFetch->getChunk($tplHead, $resource);
	}
	$head = $pdoFetch->getChunk($tplRow, array('cells' => $cells, 'list' => $list));

	$output = $pdoFetch->getChunk($tplOuter, array('head' => $head, 'rows' => $rows));
}

if ($modx->user->hasSessionContext('mgr') && !empty($showLog)) {
	$output .= '<pre class="CompareListLog">' . print_r($pdoFetch->getTime(),1) . '</pre>';
}

$modx->regClientScript('<script type="text/javascript">Comparison.list.initialize(".comparison-table", {minItems:'.$minItems.'});</script>', true);
return $output;