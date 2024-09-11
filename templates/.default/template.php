<h1>This default template</h1>
<?php
/**
 * @global CMain $APPLICATION
 * @param array $arResult
 */
if (empty($arResult['ITEMS']))
    return;
?>
<ul>
    <?foreach ($arResult['ITEMS'] as $arItem):
        $curPage = $APPLICATION->GetCurPage();
        $isActive = $curPage === $arItem['PROPERTY_URL_VALUE'];

        if ($isActive)
        {
            if (!empty($arItem['PROPERTY_TITLE_VALUE']))
                $APPLICATION->SetPageProperty('title', $arItem['PROPERTY_TITLE_VALUE']);

            if (!empty($arItem['PROPERTY_DESCRIPTION_VALUE']))
                $APPLICATION->SetPageProperty('description', $arItem['PROPERTY_DESCRIPTION_VALUE']);

            if (!empty($arItem['PROPERTY_KEYWORDS_VALUE']))
                $APPLICATION->SetPageProperty('keywords', $arItem['PROPERTY_KEYWORDS_VALUE']);
        }
        ?>
    <li>
        <a href="<?=$arItem['PROPERTY_URL_VALUE']?>" class="<?=$isActive ? 'active' : ''?>"><?=$arItem['NAME']?></a>
    </li>
    <?endforeach;?>
</ul>
