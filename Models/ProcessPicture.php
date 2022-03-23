<?php
    namespace Models;
    /*與資料庫連接並處理資料*/
    class ProcessPicture{
        public function uploadpicture($product_num,$img,$i){
            $destination_path = getcwd().DIRECTORY_SEPARATOR;
            $target_path = $destination_path . 'Content/img/'. $product_num."_".(string)$i;
            $product_img = "/backVue/Content/img/".$product_num."_".(string)$i.".jpg";
            if(is_file($target_path.".jpg")){
                unlink($target_path.".jpg");//將檔案刪除
            }
            //將base64轉成圖片
            $base64 = mb_split(",",$img)[1];
            $data = base64_decode($base64);
            file_put_contents($target_path.".jpg", $data);
            return $product_img;
        }
    }
?>