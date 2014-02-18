<?php

include_once 'setting.inc.php';

$_lang['comparison_add_to_list'] = 'Добавить к сравнению';
$_lang['comparison_remove_from_list'] = 'Убрать из сравнения';
$_lang['comparison_remove'] = 'Удалить';
$_lang['comparison_go_to_list'] = 'Сравнить';
$_lang['comparison_updating_list'] = 'Обновляю список...';

$_lang['comparison_err_add_name'] = 'Не могу найти указанный список сравнения.';
$_lang['comparison_err_add_resource'] = 'Указан неверный товар для сравнения.';
$_lang['comparison_err_no_list_id'] = 'Вы должны указать id ресурса с вызовом сниппета "CompareList". Например, &list_id=`5`.';
$_lang['comparison_err_no_list'] = 'Список сравнения пуст.';
$_lang['comparison_err_min_count'] = 'Выбрано недостаточно товаров для сравнения.';
$_lang['comparison_err_max_resource'] = 'Вы добавили максимальное количество товаров для сравнения.';
$_lang['comparison_err_wrong_fields'] = 'Неверный формат параметра &fields. Вы должны ввести JSON строку с именем набора и полями для сравнения.';
$_lang['comparison_err_wrong_list'] = 'Не могу найти массив полей сравнения для набора "[[+list]]"';

$_lang['comparison_params_all'] = 'Все параметры';
$_lang['comparison_params_unique'] = 'Различающиеся';

$_lang['comparison_field_price'] = 'Цена';
$_lang['comparison_field_weight'] = 'Вес';
$_lang['comparison_field_article'] = 'Артикул';
$_lang['comparison_field_vendor.name'] = 'Производитель';
$_lang['comparison_field_color'] = 'Цвета';
$_lang['comparison_field_size'] = 'Размеры';