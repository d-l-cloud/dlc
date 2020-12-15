<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	use Bitrix\Main\Localization\Loc;

	Loc::loadMessages(__FILE__);
	global $USER;
    $first_order = 0;
    $arOrdersTotalSum = 0;
    $payedOrders = array();
    $lastDate = '';
    $tillDate = '';

    $arUserGroups = CUser::GetUserGroup($USER->GetID());
    $pricesGroups = array('PRICE_EURO' => 100000, 'PRICE_1_LEVEL' => 300000, 'PRICE_2_LEVEL' => 'max');
    $priceRanges = array();
    foreach($pricesGroups as $key => $priceGroup){
        $rsPricesRange = CGroup::GetList($by = "c_sort", $order = "asc", Array ("STRING_ID" => $key));
        while ($arPricesRange = $rsPricesRange->Fetch()) {
            $priceRanges[$arPricesRange['ID']]= $pricesGroups[$arPricesRange['STRING_ID']];
        }
    }

    foreach($priceRanges as $key => $priceRange){
        if(array_search($key, $arUserGroups)){
            $maxSum = $priceRange;
            if(array_search($key,  array_keys($priceRanges))!= 0) $supportSumMin = $priceRanges[array_keys($priceRanges)[array_search($key,  array_keys($priceRanges)) - 1]];
           $userPriceGroup = array_search($priceRange, $pricesGroups);
            break;
        }
    }

    if(is_array($arResult["ORDERS"]) && !empty($arResult["ORDERS"])) {
        $rsUser = CUser::GetByID($USER->GetID());
        $arUser = $rsUser->Fetch();
        foreach ($arResult["ORDERS"] as $key => $arOrder) {
            if ($arOrder['ORDER']['STATUS_ID'] == 'F') {
                $payedOrders[] = $arOrder['ORDER'];
            }
        }

        $arResult = array();

        if (!empty($payedOrders)) {
            $lastDate = $payedOrders[0]['DATE_INSERT']->format('Y-m-d');
            $orderMinDate = new DateTime($lastDate);
            $orderMinDate = $orderMinDate->modify('-3 month')->format('Y-m-d');

            foreach ($payedOrders as $key => $arOrder) {
                if ($arOrder['DATE_INSERT']->format('Y-m-d') >= $orderMinDate) {
                    $arOrdersTotalSum += $arOrder['PRICE'];
                } else {
                    unset($payedOrders[$key]);
                }
            }

            $support_to_sum = 0;


            if (isset($supportSumMin)) {
                $support = 0;
                foreach ($payedOrders as $arKey => $arOrder) {
                    $support_to_sum += $arOrder['PRICE'];
                    if ($support_to_sum < $supportSumMin) {
                        $support = $arKey;
                    } else {
                        $support_to_sum -= $arOrder['PRICE'];
                        break;
                    }
                }
            }

            if(isset($support)){
                $dateSupport = $payedOrders[$support+1]['DATE_INSERT'];
            }

            if(isset($dateSupport)){
                $arResult['SUPPORT_TO'] = new DateTime($dateSupport);
                $arResult['SUPPORT_TO'] = $arResult['SUPPORT_TO']->modify('+3 month')->format('d.m.Y');
            }

            $tillDate = new DateTime($payedOrders[count($payedOrders)-1]['DATE_INSERT']->format('Y-m-d'));
            $tillDate = $tillDate->modify('+3 month')->format('d.m.Y');
        }
    } else{
        $arResult = array();
    }

    $arResult['PRICE_GROUP'] = $userPriceGroup;

    $arResult['TOTAL_ORDER_SUM'] =  $arOrdersTotalSum;
    $arResult['TOTAL_ORDER_SUM_FORMAT'] =  CurrencyFormat($arOrdersTotalSum, 'RUB');


    if($maxSum != 'max'){
        $arResult['NEED_SUM'] = CurrencyFormat($maxSum - $arOrdersTotalSum, 'RUB');
    } else {
        $arResult['NEED_SUM'] =  CurrencyFormat(0, 'RUB');
    }

    if(!empty($tillDate)){
        $arResult['BUY_TO'] = $tillDate;
    }
    if(isset($supportSumMin)){
        $supportSum = $supportSumMin - $support_to_sum;
        $arResult['SUPPORT_SUM'] = $supportSum < 0 ? CurrencyFormat(0, 'RUB') : CurrencyFormat($supportSum, 'RUB');
    }


    if ($arResult['TOTAL_ORDER_SUM'] >= 500000) {
        $arResult['CUR_DISCOUNT_FORMAT'] = '15%';
    } elseif ($arResult['TOTAL_ORDER_SUM'] >= 250000) {
        $arResult['CUR_DISCOUNT_FORMAT'] = '10%';
    } elseif ($arResult['TOTAL_ORDER_SUM'] >= 100000) {
        $arResult['CUR_DISCOUNT_FORMAT'] = '5%';
    } else {
        $arResult['CUR_DISCOUNT_FORMAT'] = '0%';
    }

    $arResult['CUR_SCALE_PERCENT'] = ($arResult['TOTAL_ORDER_SUM'] > 500000) ? 100 : (round($arResult['TOTAL_ORDER_SUM'] / 500000) * 100);