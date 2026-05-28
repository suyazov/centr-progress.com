<?if (!empty($arResult['STARTSHOP']['OFFERS'])):?>
    <script type="text/javascript">
        var <?=$sUniqueID?>_Offers = new Startshop.Catalog.Offers(<?=CUtil::PhpToJSObject(CStartShopToolsIBlock::GetOffersJSStructure($arResult))?>);
        <?=$sUniqueID?>_Offers.Events.OnOfferChange = function ($oParameters) {
            var $oRoot = $('#<?=$sUniqueID?>');

            $oRoot.find('.startshop-offers-properties .startshop-offers-property .startshop-offers-value')
                .removeClass('displayed')
                .removeClass('enabled')
                .removeClass('disabled')
                .removeClass('selected')
                .children('.startshop-offers-value-wrapper')

            Startshop.Functions.forEach($oParameters.Properties.Displayed, function ($iKey, $oPropertyValue) {
                $oRoot.find('.StartShopOffersProperty_' + $oPropertyValue['Key'] + ' .StartShopOffersValue_'  + $oPropertyValue['Value'])
                    .addClass('displayed');
            });

            Startshop.Functions.forEach($oParameters.Properties.Enabled, function ($iKey, $oPropertyValue) {
                $oRoot.find('.StartShopOffersProperty_' + $oPropertyValue['Key'] + ' .StartShopOffersValue_'  + $oPropertyValue['Value'])
                    .addClass('enabled');
            });

            Startshop.Functions.forEach($oParameters.Properties.Disabled, function ($iKey, $oPropertyValue) {
                $oRoot.find('.StartShopOffersProperty_' + $oPropertyValue['Key'] + ' .StartShopOffersValue_'  + $oPropertyValue['Value'])
                    .addClass('disabled');
            });

            Startshop.Functions.forEach($oParameters.Properties.Selected, function ($iKey, $oPropertyValue) {
                $oRoot.find('.StartShopOffersProperty_' + $oPropertyValue['Key'] + ' .StartShopOffersValue_'  + $oPropertyValue['Value'])
                    .addClass('selected').children('.startshop-offers-value-wrapper')
                        .addClass('startshop-element-background')
                        .addClass('startshop-element-border');
            });

            $oRoot.find('.startshop-information .startshop-order').css('display', 'none');
            $oRoot.find('.startshop-slider').css('display', 'none');
            $oRoot.find('.StartShopOffersPrice').html($oParameters.Offer['PRICES']['MINIMAL']['PRINT_VALUE']);
            $oRoot.find('.StartShopOffersQuantity').html($oParameters.Offer['QUANTITY']['VALUE']);
            $oRoot.find('.StartShopOffersSlider' + $oParameters.Offer['ID']).css('display', 'block');
			
			var baz = $oParameters.Offer['PRICES']['MINIMAL']['PRINT_VALUE'];
			$oRoot.find('.StartShopOffersPrice').data('price', baz).attr('data-price', baz);
			
			var id = $oParameters.Offer['ID'];
			$oRoot.find('.count_price').data('id', baz).attr('data-id', id);
			$oRoot.find('.summ').attr('id', "summ_" +id);
			$oRoot.find('#summ_' +id).html();
			
			function change($tr, val) {
				var $input = $tr.find('.quantity');
				var count = parseInt($input.val()) + val;
				count = count < 1 ? 1 : count;
				$input.val(count);
				var $price = $tr.find('#summ_' +id);
				$price.text(count * $price.data('price'));
			  }
			  $('.minus').click(function() {
				change($(this).closest('.Calc'), 0);
			  });
			  $('.plus').click(function() {
				change($(this).closest('.Calc'), 0);
			  });
			  $('input.quantity Count_' +id).on("input", function() {
				var $price = $(this).closest('.Calc').find('#summ_' +id);
				$price.text(this.value * $price.data('price'));
			  });
				 				
						
            if ($oParameters.Offer['AVAILABLE']) {
                $oRoot.find('.StartShopOffersStateAvailable').css('display', '');
                $oRoot.find('.StartShopOffersStateUnavailable').css('display', 'none');
                $oRoot.find('.StartShopOffersOrder' + $oParameters.Offer['ID']).css('display', 'block');

                if ($oParameters.Offer['QUANTITY']['VALUE'] > 0) {
                    $oRoot.find('.StartShopOffersQuantity').css('display', '');
                } else {
                    $oRoot.find('.StartShopOffersQuantity').css('display', 'none');
                }
            } else {
                $oRoot.find('.StartShopOffersStateAvailable').css('display', 'none');
                $oRoot.find('.StartShopOffersStateUnavailable').css('display', '');
            }

            Startshop.Functions.forEach($arSliders<?=$sUniqueID?>, function ($iSliderIndex, $oSlider) {
                $oSlider.Refresh();
            });
        };

        <?=$sUniqueID?>_Offers.Initialize();
    </script>
<?else:?>
    <script type="text/javascript">
		$(document).ready(function() {
		  function change($tr, val) {
			var $input = $tr.find('.quantity');
			var count = parseInt($input.val()) + val;
			count = count < 1 ? 1 : count;
			$input.val(count);
			var $price = $tr.find('.count_price');
			$price.text(count * $price.data('price'));
		  }
		  $('.minus').click(function() {
			change($(this).closest('.CalcDetail'), 0);
		  });
		  $('.plus').click(function() {
			change($(this).closest('.CalcDetail'), 0);
		  });
		  $('.quantity').on("input", function() {
			var $price = $(this).closest('.CalcDetail').find('.count_price');
			$price.text(this.value * $price.data('price'));
		  });
		});
    </script>
<?endif;?>