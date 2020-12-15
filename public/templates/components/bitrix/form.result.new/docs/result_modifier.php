<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arProfiles = CSaleOrderUserProps::GetList(
    array("DATE_UPDATE" => "DESC"),
    array("USER_ID" => $USER->GetID())
);

while ($arProfile = $arProfiles->Fetch())
{
    $arResult['USER_PROFILES'][$arProfile['ID']] = $arProfile['NAME'];
}

$arNewQuestions = [];
foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
    if (in_array(trim($arQuestion['CAPTION']), ['Документы', 'Куда'])) {
        $arNewQuestions['CHECKBOXES_ROW'][$FIELD_SID] = $arQuestion;
    } elseif (in_array(trim($arQuestion['CAPTION']), ['E-mail', 'Контактное лицо'])) {
        $arNewQuestions['INPUT_TEXT_ROW'][$FIELD_SID] = $arQuestion;
    } else {
        $arNewQuestions[$FIELD_SID] = $arQuestion;
    }
}

$arResult["QUESTIONS"] = $arNewQuestions;