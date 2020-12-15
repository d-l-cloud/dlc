<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arProfiles = CSaleOrderUserProps::GetList(
    array("PERSON_TYPE_ID" => "ASC"),
    array("USER_ID" => $USER->GetID()), false, false, array('NAME', 'ID')
);

while ($arProfile = $arProfiles->Fetch())
{
    $arResult['USER_PROFILES'][$arProfile['ID']]['NAME'] = $arProfile['NAME'];

    $propVals = CSaleOrderUserPropsValue::GetList(array(), Array("USER_PROPS_ID"=>$arProfile['ID'], "PROP_CODE" => 'ADDRESSES'));
    while ($arPropVal = $propVals->Fetch())
    {
        $arResult['USER_PROFILES'][$arProfile['ID']]['ADDRESSES'] = $arPropVal["VALUE"];
    }
   
}

$propVals = CSaleOrderProps::GetList(array('SORT' => 'ASC'), array('PERSON_TYPE_ID' => 1, 'ACTIVE' => 'Y', 'PROPS_GROUP_ID' => 1, 'USER_PROPS' => 'Y'));
while ($arPropVal = $propVals->Fetch()) {
    $arResult['ORDER_PROPS'][] = $arPropVal;
}
