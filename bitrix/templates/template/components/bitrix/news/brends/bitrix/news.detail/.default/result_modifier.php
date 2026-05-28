<?  
$arResult["PHOTO"] = array();   
   if(isset($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) && is_array($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]))   
   {   
      foreach($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $FILE)   
      {   
         $FILE = CFile::GetFileArray($FILE);   
         if(is_array($FILE))   
            $arResult["PHOTO"][]=$FILE;   
      }   
   }   
?>  