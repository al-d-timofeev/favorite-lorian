<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "На этой странице представлены товары, которые были добавлены в избранное.");
$APPLICATION->SetPageProperty("keywords", "Товары, избранное, цены");
$APPLICATION->SetPageProperty("title", "Товары, добавленные в избранное – интернет-магазин Лориан");
    $APPLICATION->SetTitle("Избранное");
?><div class="izbrannoe">
	 <?
    global $USER;

    if ($USER->IsAuthorized()){
        $rsUser = CUser::GetByID($USER->GetID());
        $arUser = $rsUser->Fetch();
        $favor_ar = $arUser['UF_FAVOR'];
    }else{
        $favor_cookie = $APPLICATION->get_cookie("FAVOR");
        $favor_cookie_ar = explode(' ', $favor_cookie);
        $favor_ar = $favor_cookie_ar;
    }


			$cnt = count($favor_ar);
            if (is_array($favor_ar) and !empty($favor_ar)){

                $arrFilter = array(
                    "IBLOCK_ID" => 18,
                    'ID' => $favor_ar
                );


                session_start();
                $template = 'main.tale';
                if ($_GET["show"] == 'list') {
                    $_SESSION["show_tpl"] = 'main.list';
                    $template = 'main.list';
                } elseif ($_GET["show"] == 'tale') {
                    $_SESSION["show_tpl"] = 'main.tale';
                } else {
                    if ($_SESSION["show_tpl"] == 'main.list') {
                        $template = 'main.list';
                    } else {
                        $_SESSION["show_tpl"] = 'main.tale';
                    }
                }
                if ($_GET["sort"]) {
                    switch ($_GET["sort"]) {
                        case "sort":
                            $sort = 'sort';
                            $sortOrder = 'asc';
                            break;
                        case "weight":
                            $sort = 'property_VES';
                            $sortOrder = 'asc';
                            break;
                        case "price":
                            $sort = 'CATALOG_PRICE_1';
                            $sortOrder = 'asc';
                            break;
                    }
                    $_SESSION["sort"] = $sort;
                    $_SESSION["sortOrder"] = $sortOrder;
                } elseif ($_SESSION["sort"] && $_SESSION["sortOrder"]) {
                    $sort = $_SESSION["sort"];
                    $sortOrder = $_SESSION["sortOrder"];
                } else {
                    $sort = 'CATALOG_PRICE_1';
                    $sortOrder = 'asc';
                    $_SESSION["sort"] = $sort;
                    $_SESSION["sortOrder"] = $sortOrder;
                }
?>


	<div class="catalog__block">



	<div class="col">
		<div class="sort__block border">
			<div class="sort__by">
				<div class="legend">Сортировать:</div>
				<div class="sort__by-item">
					<input class="sort-input" id="sort1" type="radio" name="sort-by" value="1"<?= $sort == "CATALOG_PRICE_1" ? " checked" : "" ?> data-link="<?= $APPLICATION->GetCurPageParam("sort=price", array("sort")) ?>">
					<label for="sort1">По цене</label>
				</div>
				<div class="sort__by-item">
					<input class="sort-input" id="sort2" type="radio" name="sort-by" value="2"<?= $sort == "property_VES" ? " checked" : "" ?> data-link="<?= $APPLICATION->GetCurPageParam("sort=weight", array("sort")) ?>">
					<label for="sort2">По весу</label>
				</div>
				<div class="sort__by-item">
					<input class="sort-input" id="sort3" type="radio" name="sort-by" value="3"<?= $sort == "sort" ? " checked" : "" ?> data-link="<?= $APPLICATION->GetCurPageParam("sort=sort", array("sort")) ?>">
					<label for="sort3">По популярности</label>
				</div>
			</div>

			<div class="sort__view">
                <? if ($template == 'main.list'): ?>
					<span><i class="icon sort-table"></i></span>
					<a href="<?= $APPLICATION->GetCurPageParam("show=tale", array("show")) ?>" title="Плитки"><i class="icon sort-card"></i></a>
                <? else: ?>
					<a href="<?= $APPLICATION->GetCurPageParam("show=list", array("show")) ?>" title="Список"><i class="icon sort-table"></i></a>
					<span><i class="icon sort-card"></i></span>
                <? endif; ?>
			</div>
		</div>
<?
     $APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
         $template,
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket.php",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CONVERT_CURRENCY" => "N",
		"CUSTOM_FILTER" => "",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => $sort,
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => $sortOrder,
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "18",
		"IBLOCK_TYPE" => "catalogs",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => array(
		),
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "12",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "18",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "base",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array(
			0 => "VES",
			1 => "MIN_PRICE_FILTER",
			2 => "",
		),
		"PROPERTY_CODE_MOBILE" => array(
			0 => "VES",
			1 => "MIN_PRICE_FILTER",
		),
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => $template,
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => array(
		),
		"FAVOR_PAGE" => true,
		"CNT" => $cnt
	),
	false
);?>
		</div>
	</div>
	            <br>
<?
            }else{
                echo '<p>Список избранного пуст.</p>';
            }
 
        ?>
</div>
 <br>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>