<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

if (is_array($arResult["ORDERS"]) && !empty($arResult["ORDERS"]))
{
    // Собираем id заказов для получения их свойств
    $orderIds = $orderProperties = [];

    foreach ($arResult["ORDERS"] as $order) {
        $orderIds[] = $order['ORDER']['ID'];
    }

    // Сортировка заказов по дате создания на сайте и дате создания в 1С
    $ordersWithDateInsert = $DB->Query('
        select
            o.id,
            o.date_insert,
            v.value as 1c_date_insert,
            if (
                v.value,
                v.value,
                o.date_insert
            ) as real_date_insert
        from
            b_sale_order o
            left join b_sale_order_props_value v on v.order_id = o.id and v.code = "UF_DATE_CREATED_1C"
        where
            o.id in(' . implode(',', $orderIds) . ')
        order by real_date_insert desc
    ');

    $orderIdsSort = [];
    $iteration = 0;

    while ($orderWithDateInsert = $ordersWithDateInsert->Fetch()) {
        $orderIdsSort[$orderWithDateInsert['id']] = $iteration;

        $iteration++;
    }

    // Название юр. лица., создан ли при импорте из 1С
    $arOrderProps = CSaleOrderPropsValue::GetList(
        ["SORT" => "ASC"],
        [
            "ORDER_ID" => $orderIds,
            "CODE" => ['UF_NAME', 'UF_CREATED_BY_1C', 'UF_DATE_CREATED_1C']
        ]
    );

    while ($arProp = $arOrderProps->Fetch()) {
        $orderProperties[$arProp['ORDER_ID']][$arProp['CODE']] = $arProp['VALUE'];

        if ($arProp['CODE'] == 'UF_DATE_CREATED_1C') {
            $orderProperties[$arProp['ORDER_ID']]['UF_DATE_CREATED_1C_FORMATED'] = date('d.m.Y', strtotime($arProp['VALUE']));
        }
    }

    $sortedOrders = [];

    foreach ($arResult["ORDERS"] as $order) {
        $orderIndex = $orderIdsSort[$order['ORDER']['ID']];

        if (!empty($orderProperties[$order['ORDER']['ID']])) {
            $order['PROPERTIES'] = $orderProperties[$order['ORDER']['ID']];
        }

        foreach($order['SHIPMENT'] as &$shipment) {
            if ($shipment['DELIVERY_ID'] != 2){
                $arOrderAddr = '';
                $arOrderTime = '';
                $arOrderProps = CSaleOrderPropsValue::GetList(
                    array("SORT" => "ASC"),
                    array("ORDER_ID" => $shipment['ORDER_ID'], "CODE" => array('LOCATION', 'STREET', 'HOUSE', 'FLAT', 'TIME'))
                );
                while ($arProp = $arOrderProps->Fetch()) {
                    if ($arProp['CODE'] == 'LOCATION') {
                        $arVal = CSaleLocation::GetByID($arProp["VALUE"]);
                        $arOrderAddr .= htmlspecialchars($arVal["COUNTRY_NAME"] . ", " . $arVal["CITY_NAME"] . (isset($arVal["REGION_NAME"]) ? ', ' . $arVal["REGION_NAME"] : '') . ' ');
                    } else if ($arProp['CODE'] == 'TIME') {
                        $arVal = CSaleOrderPropsVariant::GetByValue($arProp['ORDER_PROPS_ID'], $arProp['VALUE']);
                        $arOrderTime = $arVal["NAME"];
                    } else {
                        $arOrderAddr .= htmlspecialchars($arProp['VALUE'] . ' ');
                    }
                }
                $shipment['ADDRESS'] = $arOrderAddr;
                $shipment['TIME'] = $arOrderTime;
            }
        }

        $sortedOrders[$orderIndex] = $order;
    }

    ksort($sortedOrders);

    $arResult["ORDERS"] = $sortedOrders;
}