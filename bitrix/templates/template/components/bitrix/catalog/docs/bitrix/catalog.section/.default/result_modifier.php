<?
        $block_id = 2; //id инфоблока
        $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM"); // поля для выборки
        $arFilter = Array("IBLOCK_ID"=>IntVal($block_id), "ACTIVE"=>"Y"); // устанавливаем фильтр
        $res = CIBlockElement::GetList(Array("date_active_from" => "asc"), $arFilter, false, Array("nPageSize"=>1), $arSelect); // получаем самую первую запись в инфоблоке
         
        while ($el = $res->Fetch())
            $tmp[] = $el['DATE_ACTIVE_FROM'];
        $min = $tmp['0']; // получаем дату самой первой записи
         
        $res = CIBlockElement::GetList(Array("date_active_from" => "DESC"), $arFilter, false, Array("nPageSize"=>1), $arSelect); // получаем самую последнюю запись в инфоблоке
         
        while ($el = $res->Fetch())
            $tmp[] = $el['DATE_ACTIVE_FROM'];
        $max = $tmp['1']; // полуаем дату самой последней записи
 
        $minYear = mb_substr($min, strripos($min, ".")+1, 4); // получаем год первой записи
        $maxYear = mb_substr($max, strripos($max, ".")+1, 4); // получаем год последней записи   
         
        $minMonth = mb_substr($min, strpos($min, ".")+1, 2); // получаем месяц первой записи
        $maxMonth = mb_substr($max, strpos($max, ".")+1, 2); // получаем месяц последней записи
?>
<?
$cp = $this->__component; // объект компонента
$cp->arResult['MIN_YEAR'] = $minYear;
$cp->arResult['MAX_YEAR'] = $maxYear;
$cp->arResult['MIN_MONTH'] = $minMonth;
$cp->arResult['MAX_MONTH'] = $maxMonth;
?>