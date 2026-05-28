<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>



<div class="block_lic">
	<div class="Wrapper">
		<h3 class="Title">Образцы выдаваемых документов</h3>
		<div class="sert_list2">
			<div class="str-prev2"></div>
			<div class="str-next2"></div>

 
			<div class="swiper-container">
				<div class="swiper-wrapper">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="swiper-slide">
		<div class="swiper-slide-doc">
			<a href="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" data-fancybox="images2" class="lic_item_2">
				<img class="brands-list__image" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>" title="<?=$arItem['NAME']?>">
	
			</a>
		</div>	
</div>

<?endforeach;?>
			</div>
		</div>

				<div class="swiper-pagination-3"></div>
		</div>
	</div>
</div>

 <script >  
 	var swiper = new Swiper('.sert_list2 .swiper-container', {
      //direction: 'vertical',
     // autoplay: {
     //    delay: 5000,
     //   disableOnInteraction: false,
     // },
	 loop: true,
	 centeredSlides: true,
	 slidesPerView: 1,
	

      // pagination: {
      //   el: '.swiper-pagination-3',
      //   clickable: true,
      // },

      navigation: {
        nextEl: '.str-next2',
        prevEl: '.str-prev2',
      },
	  breakpoints:{
            300: {
                allowTouchMove: true,
				 slidesPerView: 1,
				 autoHeight: true,
      // pagination: {
      //   el: '.swiper-pagination-3',
      //   clickable: true,
      // },
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