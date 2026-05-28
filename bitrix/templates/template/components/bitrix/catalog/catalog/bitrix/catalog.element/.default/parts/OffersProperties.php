<?if (!empty($arResult['STARTSHOP']['OFFERS'])):?>
    <div class="SelectProps startshop-offers-properties">
        <div class="startshop-offers-properties-wrapper">
            <?foreach($arResult['STARTSHOP']['OFFER']['PROPERTIES'] as $arOffersProperty):?>
                <?if ($arOffersProperty['TYPE'] == "TEXT"):?>
						<div class="Label startshop-offers-property startshop-offers-property-text StartShopOffersProperty_<?=$arOffersProperty['CODE']?>">
							<div class="startshop-offers-property-wrapper">
								<div class="Flex Baseline">
									<div class="Name startshop-offers-title"><?=$arOffersProperty['NAME']?>:</div>
									<div class="Select startshop-offers-items">
										<div class="dropdown">
											<div class="select">
												<div class="select-act">
												<?foreach ($arOffersProperty['VALUES'] as $arOffersPropertyValue):?>
													<div class="startshop-offers-value StartShopOffersValue_<?=$arOffersPropertyValue['CODE']?>">
														<div class="startshop-offers-value-wrapper" onclick="<?=$sUniqueID?>_Offers.SetCurrentOfferByPropertyValue(<?=CUtil::PhpToJSObject($arOffersProperty['CODE'])?>, <?=CUtil::PhpToJSObject($arOffersPropertyValue['CODE'])?>)"><?=$arOffersPropertyValue['TEXT']?></div>
													</div>
													<?endforeach;?>
												</div>
												<span></span>
												<i class="arrow"></i>
											</div>
											<ul class="dropdown-menu">
											<?foreach ($arOffersProperty['VALUES'] as $arOffersPropertyValue):?>
												<li class="startshop-offers-value StartShopOffersValue_<?=$arOffersPropertyValue['CODE']?>">
													<div class="startshop-offers-value-wrapper" onclick="<?=$sUniqueID?>_Offers.SetCurrentOfferByPropertyValue(<?=CUtil::PhpToJSObject($arOffersProperty['CODE'])?>, <?=CUtil::PhpToJSObject($arOffersPropertyValue['CODE'])?>)"><?=$arOffersPropertyValue['TEXT']?></div>
												</li>
											<?endforeach;?>
											</ul>
										</div>
										<div class="startshop-offers-value startshop-offers-value-empty StartShopOffersValue_">
											<div class="startshop-offers-value-wrapper" onclick="<?=$sUniqueID?>_Offers.SetCurrentOfferByPropertyValue(<?=CUtil::PhpToJSObject($arOffersProperty['CODE'])?>, '')">
												<div class="startshop-aligner-vertical"></div>
												<div class="startshop-offers-text">-</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                <?else:?>
                    <div class="Label startshop-offers-property startshop-offers-property-image StartShopOffersProperty_<?=$arOffersProperty['CODE']?>">
                        <div class="startshop-offers-property-wrapper">
							<div class="Flex Baseline">
								<div class="Name startshop-offers-title"><?=$arOffersProperty['NAME']?>:</div>
								<div class="Select startshop-offers-items">
										<div class="dropdown">
											<div class="select">
												<div class="select-act">
													<?foreach ($arOffersProperty['VALUES'] as $arOffersPropertyValue):?>
														<div class="startshop-offers-value StartShopOffersValue_<?=$arOffersPropertyValue['CODE']?>">
															<div class="startshop-offers-value-wrapper" onclick="<?=$sUniqueID?>_Offers.SetCurrentOfferByPropertyValue(<?=CUtil::PhpToJSObject($arOffersProperty['CODE'])?>, <?=CUtil::PhpToJSObject($arOffersPropertyValue['CODE'])?>)">
																<div class="startshop-offers-image">
																	<span><?=$arOffersPropertyValue['TEXT']?></span>
																	<img src="<?=$arOffersPropertyValue['PICTURE']?>" title="<?=$arOffersPropertyValue['TEXT']?>" alt="<?=$arOffersPropertyValue['TEXT']?>" />
																</div>
																<div class="startshop-offers-sprite"></div>
															</div>
														</div>
													<?endforeach;?>
												</div>
												<span></span>
												<i class="arrow"></i>
											</div>
											<ul class="dropdown-menu">
											<?foreach ($arOffersProperty['VALUES'] as $arOffersPropertyValue):?>
												<li class="startshop-offers-value StartShopOffersValue_<?=$arOffersPropertyValue['CODE']?>">
													<div class="startshop-offers-value-wrapper" onclick="<?=$sUniqueID?>_Offers.SetCurrentOfferByPropertyValue(<?=CUtil::PhpToJSObject($arOffersProperty['CODE'])?>, <?=CUtil::PhpToJSObject($arOffersPropertyValue['CODE'])?>)">
														<div class="startshop-offers-image">
															<span><?=$arOffersPropertyValue['TEXT']?></span>
															<img src="<?=$arOffersPropertyValue['PICTURE']?>" title="<?=$arOffersPropertyValue['TEXT']?>" alt="<?=$arOffersPropertyValue['TEXT']?>" />
														</div>
														<div class="startshop-offers-sprite"></div>
													</div>
												</li>
											<?endforeach;?>
											</ul>
										</div>
									<div class="startshop-offers-value startshop-offers-value-empty StartShopOffersValue_">
										<div class="startshop-offers-value-wrapper" onclick="<?=$sUniqueID?>_Offers.SetCurrentOfferByPropertyValue(<?=CUtil::PhpToJSObject($arOffersProperty['CODE'])?>, '')">
											<div class="startshop-offers-image"></div>
											<div class="startshop-offers-sprite"></div>
										</div>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                <?endif;?>
            <?endforeach;?>
        </div>
    </div>
<?endif;?>
<script type="text/javascript">
/*Dropdown Menu*/
$('.dropdown').click(function () {
        $(this).attr('tabindex', 1).focus();
        $(this).toggleClass('active');
        $(this).find('.dropdown-menu').slideToggle(300);
    });
    $('.dropdown').focusout(function () {
        $(this).removeClass('active');
        $(this).find('.dropdown-menu').slideUp(300);
    });
    $('.dropdown .dropdown-menu li').click(function () {
        $(this).parents('.dropdown').find('input').attr('value', $(this).attr('id'));
    });
/*End Dropdown Menu*/
</script>
