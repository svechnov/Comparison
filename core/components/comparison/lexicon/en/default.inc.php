<?php

include_once 'setting.inc.php';

$_lang['comparison_add_to_list'] = 'Add to comparison';
$_lang['comparison_remove_from_list'] = 'Remove from the comparison';
$_lang['comparison_remove'] = 'Delete';
$_lang['comparison_go_to_list'] = 'Compare';
$_lang['comparison_updating_list'] = 'Updating...';

$_lang['comparison_err_add_name'] = 'Cannot find the specified list of comparisons.';
$_lang['comparison_err_add_resource'] = 'Invalid goods for comparison.';
$_lang['comparison_err_no_list_id'] = 'You must specify a resource id with a call to a snippet "CompareList". For example, &list_id=`5`.';
$_lang['comparison_err_no_list'] = 'Compare list is empty.';
$_lang['comparison_err_min_count'] = 'You selected not enough goods for comparison.';
$_lang['comparison_err_max_resource'] = 'You have added the maximum number of items to compare.';
$_lang['comparison_err_wrong_fields'] = 'Invalid format of the parameter &fields. You must enter a JSON string with the dataset name, and fields for comparison.';
$_lang['comparison_err_wrong_list'] = 'Cannot find an array of fields for comparison set of "[[+list]]"';

$_lang['comparison_params_all'] = 'All options';
$_lang['comparison_params_unique'] = 'Unique';

$_lang['comparison_field_price'] = 'Price';
$_lang['comparison_field_weight'] = 'Price';
$_lang['comparison_field_article'] = 'Article';
$_lang['comparison_field_vendor.name'] = 'Vendor';
$_lang['comparison_field_color'] = 'Color';
$_lang['comparison_field_size'] = 'Sizes';