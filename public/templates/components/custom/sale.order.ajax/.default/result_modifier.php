<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);


foreach($arResult['JS_DATA']['ORDER_PROP']['properties'] as &$prop){
    if($prop['CODE'] == 'ADDRESSES') {
        $prop['TYPE'] = 'ENUM';
        $prop['REQUIRED'] = "Y";
        $prop['MULTIPLE'] = "N";
        $prop['OPTIONS'] = $prop['OPTIONS_SORT'] = array();
        if(count($prop['VALUE']) > 1) $prop['VALUE'] = array();
        $propVals = CSaleOrderUserPropsValue::GetList(array('ID'=>'DESC'), Array("USER_PROPS_ID"=>intval($this->arUserResult['PROFILE_ID']), "PROP_CODE" => 'ADDRESSES'));
        $arPropVal = $propVals->Fetch();

        foreach (unserialize($arPropVal['VALUE']) as $arVal) {
            $arVal = explode(',', $arVal);
            if($arVal[count($arVal) - 1] == 1) {
                if (!empty($arVal[0])) {
                    $defaultAddr = $arVal[0];
                } else {
                    unset($arVal[count($arVal) - 1]);
                    unset($arVal[0]);
                    $defaultAddr = trim(implode(',', $arVal));
                }
            }
        }

        foreach (unserialize($arPropVal['VALUE']) as $key => $arVal) {
            $arVal = explode(',', $arVal);
            $name = $arVal[0];
            unset($arVal[count($arVal) - 1]);
            unset($arVal[0]);
            if (!empty($name)){
                $prop['OPTIONS'][$name] = $name;
                if($name == $defaultAddr && empty($chosenAddr)) {
                    array_unshift($prop['OPTIONS_SORT'], $name);
                } else {
                    $prop['OPTIONS_SORT'][] = $name;
                }
            } else {
                $prop['OPTIONS'][trim(implode(',', $arVal))] = trim(implode(', ', $arVal), ',');
                if(trim(implode(',', $arVal)) == trim($defaultAddr) && empty($chosenAddr)) {
                    array_unshift($prop['OPTIONS_SORT'], trim(implode(',', $arVal)));
                } else {
                    $prop['OPTIONS_SORT'][] = trim(implode(',', $arVal));
                }
            }
        }
    }
}


if(!$arResult['JS_DATA']['IS_AUTHORIZED']){
    foreach($arResult['JS_DATA']['ORDER_PROP']['properties'] as $key => &$prop) {
        if($prop['CODE'] == 'PROFILE_ID'){
            unset($arResult['JS_DATA']['ORDER_PROP']['properties'][$key]);
        }

    }
    unset($arResult['JS_DATA']['PERSON_TYPE'][1]);
}

if($arResult['ORDER']['ID'] > 0){
    $basketRes = CSaleBasket::GetList([], ['ORDER_ID' => $arResult['ORDER']['ID']]);
    $arResult['ITEMS'] = [];
    while($ob = $basketRes->Fetch()){
        $arResult['ITEMS'][] = $ob['PRODUCT_ID'];
    }
}