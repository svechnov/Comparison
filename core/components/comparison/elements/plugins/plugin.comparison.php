<?php

switch ($modx->event->name) {

	case 'OnHandleRequest':
		if (empty($_REQUEST['cmp_action']) || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
			return;
		}

		$modx->lexicon->load('comparison:default');
		$response = array('success' => true, 'message' => '', 'data' => array());

		$action = trim(strtolower($_REQUEST['cmp_action']));
		switch ($action) {
			case 'add':
			case 'remove':
				$cat = !empty($_REQUEST['cat'])
					? (string) $_REQUEST['cat']
					: 'default';

				if ($cat != 'default' && !isset($_SESSION['Comparison'][$cat])) {
					$response['success'] = false;
					$response['message'] = $modx->lexicon('comparison_err_add_name');
				}
				elseif (empty($_REQUEST['resource']) || !$modx->getCount('modResource', array('id' => $_REQUEST['resource'], 'published' => 1, 'deleted' => 0))) {
					$response['success'] = false;
					$response['message'] = $modx->lexicon('comparison_err_add_resource');
				}
				else {
					$params = & $_SESSION['Comparison'][$cat];
					$id = $_REQUEST['resource'];
					if ($action == 'add') {
						if ((count($params['ids']) + 1) > $params['maxItems']) {
							$response['success'] = false;
							$response['message'] = $modx->lexicon('comparison_err_max_resource');
						}
						else {
							$params['ids'][$id] = true;
						}
					}
					else {
						unset($params['ids'][$id]);
					}
					$response['data'] = array(
						'total' => count($params['ids']),
					);
					$link_params = array('cmp_ids' => implode(',', array_keys($params['ids'])));
					if ($cat != 'default') {
						$link_params['cat'] = $cat;
					}
					$response['data']['link'] = urldecode($modx->context->makeUrl($params['list_id'], $link_params, $modx->getOption('link_tag_scheme')));
				}
				break;
		}

		@session_write_close();
		exit($modx->toJSON($response));
		break;

}