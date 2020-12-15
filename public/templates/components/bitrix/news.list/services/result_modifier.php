<?php

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as $key => $arItem) {
        if (!empty($arItem["PROPERTIES"]["IMAGE"]['VALUE'])) {
            $sFile = CFile::GetPath($arItem["PROPERTIES"]["IMAGE"]['VALUE']);

            if (!empty($sFile)) {
                $arResult['ITEMS'][$key]["IMAGE_SRC"] = $sFile;
            }
        }
    }
}
