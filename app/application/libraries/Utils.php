<?php
class Utils {

     public function __construct() {
        }

     public function __destruct(){
       }

     public function getImageBase64($imageFile,$mimeType){

    $getBytesFile = base64_encode(file_get_contents($imageFile,FILE_USE_INCLUDE_PATH));
    $image = '<img src="data:'.$mimeType.';base64,'.$getBytesFile.'"/>';

    return $image;

    }

     public function getTemplateString($template){
      return file_get_contents($template,FILE_USE_INCLUDE_PATH);

    }

     public function replaceValue($search,$replace,$str){
        return  str_replace($search,$replace,$str);
    }

    public function increaseSize($search,$replace,$str){
       $nuevo = '<h3>'.$replace.'<h3/>';
       return $nuevo;
   }
}
?>
