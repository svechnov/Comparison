<?php

$_lang['comparison_prop_id'] = 'Id of the product to add to the list. Default is the current resource.';
$_lang['comparison_prop_tpl'] = 'Chunk for add product to the list of comparison.';
$_lang['comparison_prop_tpl_get'] = 'Chunk for templating the link of comparison.';
$_lang['comparison_prop_list'] = 'An arbitrary name for the comparison list. If you have goods of different types - specify the different names of the lists. The name specified must be in the array "&fields" of snippet "CompareList".';
$_lang['comparison_prop_list_get'] = 'The name of existing list of comparison.';
$_lang['comparison_prop_list_id'] = 'Mandatory parameter indicating the id of the page where the snippet called "ComparisonList".';
$_lang['comparison_prop_minItems'] = 'The minimum number of goods for comparison.';
$_lang['comparison_prop_maxItems'] = 'The maximum number of items to compare.';

$_lang['comparison_prop_fields'] = 'JSON string with names of lists of comparison and an array of comparable fields. For example: {"test":["price","weight"]}.';
$_lang['comparison_prop_tplRow'] = 'Chunk with one row of the table comparison shopping. As you could see placeholders [[+cells]] and [[+same]].';
$_lang['comparison_prop_tplParam'] = 'Chunk with the name of the parameter of the goods. As you could see placeholders [[+param]] and [[+row_idx]].';
$_lang['comparison_prop_tplCell'] = 'Table Cell comparison with the same value of the parameter of the goods. As you could see placeholders [[+value]], [[+classes]] and [[+cell_idx]].';
$_lang['comparison_prop_tplHead'] = 'Header Cell goods in the comparison table. Here you can use all as you could see placeholders goods.';
$_lang['comparison_prop_tplCorner'] = 'Corner cell of the table, with links to the switching comparison options. Плейсхолдеров no.';
$_lang['comparison_prop_tplOuter'] = 'Chunk-wrap comparison table. As you could see placeholders [[+head]] and [[+rows]].';
$_lang['comparison_prop_formatSnippet'] = 'An arbitrary snippet for registration of a parameter value of the goods. Gets the name of the field "$field" and its value value "$value". Should return a formatted string "$value".';
$_lang['comparison_prop_showLog'] = 'Display administrator detailed log snippet.';