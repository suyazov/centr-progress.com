<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>




			<div class="swiper-container">
				<div class="swiper-wrapper">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="swiper-slide">
			<a href="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" data-fancybox="images" class="lic_item">
				<img class="brands-list__image" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>" title="<?=$arItem['NAME']?>">
			</a>
</div>

<?endforeach;?>
			</div>
		</div>



 <script >  
 	var swiper = new Swiper('.licmin_right .swiper-container', {
      //direction: 'vertical',
     autoplay: {
        delay: 5000,
       disableOnInteraction: false,
     },
	 loop: true,
	// centeredSlides: true,
	 slidesPerView: 2,
	 
	 /*
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
*/
      navigation: {
        nextEl: '.str-next',
        prevEl: '.str-prev',
      },
	  breakpoints:{
            300: {
                allowTouchMove: true,
				 slidesPerView: 1,
				 autoHeight: true,
      pagination: {
        el: '.swiper-pagination-2',
        clickable: true,
      },
            },
            800: {
                allowTouchMove: true,
				 slidesPerView: 1,
				 autoHeight: true,
            },	
            1200: {
                allowTouchMove: true,
				 slidesPerView: 1,
				 autoHeight: true,
            },		
	  }
    }); 
 	</script>