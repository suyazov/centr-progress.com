<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div itemscope itemtype="http://schema.org/FAQPage">
		<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
        <div class="question-block" id="<?=$this->GetEditAreaId($arItem['ID']);?>" itemprop="mainEntity" itemscope itemtype="http://schema.org/Question">
            <a class="btn btn-question collapsed" data-toggle="collapse" href="#question<?=$arItem['ID']?>" role="button" aria-expanded="false" aria-controls="question<?=$arItem['ID']?>" itemprop="name"><?=$arItem['PREVIEW_TEXT']?><i class="fa fa-angle-down"></i></a>
			<?if($arItem["DETAIL_TEXT"]):?>
            <div class="panel-collapse collapse" id="question<?=$arItem['ID']?>" itemscope itemprop="acceptedAnswer" itemtype="http://schema.org/Answer">
                <div class="AnswerText" itemprop="text">
					<?=$arItem['DETAIL_TEXT']?>
                </div>
            </div>
			<?endif;?>
        </div>
		<?endforeach;?>
</div>