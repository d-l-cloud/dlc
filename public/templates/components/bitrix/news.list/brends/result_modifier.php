<?php

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as $key => $item) {
        if (!empty($item['PREVIEW_PICTURE']['ID'])) {
            $file = CFile::ResizeImageGet(
                $item['PREVIEW_PICTURE']['ID'],
                array(
                    'width' => 157,
                    'height' => 70
                ),
                BX_RESIZE_IMAGE_PROPORTIONAL,
                true
            );

            $arResult['ITEMS'][$key]['PREVIEW_PICTURE_RESIZED_SRC'] = $file['src'];
        }
    }
}
