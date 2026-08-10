<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/lib/CentrProgress/Catalog/EducationProgramFiles.php';

$programFiles = \CentrProgress\Catalog\EducationProgramFiles::fromDisplayProperty(
    isset($arResult['DISPLAY_PROPERTIES']['PROGRAMM']) && is_array($arResult['DISPLAY_PROPERTIES']['PROGRAMM'])
        ? $arResult['DISPLAY_PROPERTIES']['PROGRAMM']
        : array()
);

if (!$programFiles) {
    return;
}
?>
<div class="Files EducationProgramFiles">
    <?php foreach ($programFiles as $programFile): ?>
        <div class="EducationProgramFile">
            <a href="<?=htmlspecialcharsbx($programFile['SRC'])?>">Образовательная программа</a><?php
            if ($programFile['FILE_SIZE'] > 0): ?>
                <span class="Size"><?=htmlspecialcharsbx(formatFileSize($programFile['FILE_SIZE']))?></span>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
