<?php

use BMarketing\ComponentHelper;

class SeoTagsComponent extends CBitrixComponent
{
    protected array $propertyFields = [
        'URL',
        'TITLE',
        'KEYWORDS',
        'HEADER',
        'DESCRIPTION'
    ];

    public function onPrepareComponentParams($arParams): array
    {
        return $arParams;
    }

    public function executeComponent(): void
    {
        $this->mergeResult('ITEMS', $this->getData());
        $this->includeComponentTemplate();
    }

    protected function getPropertyFields(): array
    {
        return array_map(function ($prop) {
            return 'PROPERTY_' . $prop;
        }, $this->propertyFields);
    }

    private function getData(): array
    {
        global $APPLICATION;
        $curPage = $APPLICATION->GetCurPage();

        $result = [];

        $arFilter = [
            'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
            '=PROPERTY_'.$this->arParams['PROPERTY_CODE'] => $this->arParams['SECTION_ID'],
        ];

        $arSelectDefault = ['ID', 'NAME'];
        $arSelect = array_merge(
            $arSelectDefault,
            ['PROPERTY'.$this->arParams['PROPERTY_CODE'],],
            $this->getPropertyFields()
        );

        $res = CIBlockElement::GetList(
            [],
            $arFilter,
            false, false,
            $arSelect,
        );
        while ($obj = $res->GetNext())
        {
            $obj['IS_ACTIVE'] = $curPage === $obj['PROPERTY_URL_VALUE'] ? 'Y' : 'N';
            $result[] = $obj;
        }

        return $result;
    }

    final protected function mergeResult(string $key, string | array $value): void
    {
        $this->arResult = array_merge($this->arResult, [$key => $value]);
    }
}