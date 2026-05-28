<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>



<div class="block_lic">
	<div class="Wrapper">
		<h3 class="Title">Сертификаты/Лицензии</h3>
		<div class="sert_list">
			<div class="str-prev"></div>
			<div class="str-next"></div>


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
				<div class="lic_name"><?=$arItem['NAME']?></div>
			</a>
</div>

<?endforeach;?>
			</div>
		</div>

				<div class="swiper-pagination-2"></div>
		</div>
	</div>
</div>

 <script >  
 	var swiper = new Swiper('.sert_list .swiper-container', {
      //direction: 'vertical',
     // autoplay: {
     //    delay: 5000,
     //   disableOnInteraction: false,
     // },
	 loop: true,
	 centeredSlides: true,
	 slidesPerView: 3,
	 
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
				 slidesPerView: 2,
				 autoHeight: true,
            },	
            1200: {
                allowTouchMove: true,
				 slidesPerView: 3,
				 autoHeight: true,
            },		
	  }
    }); 
 	</script>