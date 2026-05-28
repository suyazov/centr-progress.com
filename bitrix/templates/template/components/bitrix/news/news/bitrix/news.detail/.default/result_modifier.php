<?  
$arResult["PHOTO"] = array();   
   if(isset($arResult["PROPERTIES"]["PHOTO"]["VALUE"]) && is_array($arResult["PROPERTIES"]["PHOTO"]["VALUE"]))   
   {   
      foreach($arResult["PROPERTIES"]["PHOTO"]["VALUE"] as $FILE)   
      {   
         $FILE = CFile::GetFileArray($FILE);   
         if(is_array($FILE))   
            $arResult["PHOTO"][]=$FILE;   
      }   
   }   
?>  