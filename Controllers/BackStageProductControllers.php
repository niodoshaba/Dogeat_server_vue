<?php

namespace Controllers;

use Bang\Lib\Response;
use Bang\Lib\TaskResult;
use Bang\MVC\ControllerBase;
use Models\UserDatabase;
use Models\VegDatabase;
use Models\ProcessPicture;
use Bang\Lib\ResponseBag;
/**
 * 主頁面Controller
 * @author Bang
 */
class BackStageProductControllers extends ControllerBase {
    public function showAllProduct(){
        $showAllProduct = new VegDatabase();
        $data = $showAllProduct->selectALLProduct();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    public function CountAllProduct(){
        $count = new VegDatabase();
        $data = $count->CountAllProduct();
        if($data != false){
            $count_num = $data[0][0];
            ResponseBag::Add('count_num', $count_num);
        }else{
            echo false;
        }
    }
    public function ShowEachPageProduct(){
        $page = $_GET["Page"];
        $per_page = $_GET["per_page"];
        $count = new VegDatabase();
        $data = $count->EachPageProductData($page,$per_page);
        print_r(json_encode($data));
    }
    public function showProductInformation(){
        $pro_id = $_POST["pro_id"];
        $Information = new VegDatabase();
        $data = $Information->selectProductInformation($pro_id);
        print_r(json_encode($data));
    }
    public function updateProduct(){
        $updateProduct = new VegDatabase();
        $uploadpicture = new ProcessPicture();
        $product_num  = $_POST["product_num"];
        $product_catalog = $_POST["product_catalog"];
        $product_name = $_POST["product_name"];
        $product_price = $_POST["product_price"];
        $product_status = $_POST["product_status"];
        $product_reserve = $_POST["product_reserve"];
        $product_date = $_POST["product_date"];
        $product_date_hour = $_POST["date_hour"];
        $product_date_min = $_POST["date_min"];
        $product_date = $product_date." ".$product_date_hour.":".$product_date_min;
        $img = [$_POST["tmp_base64_01"],$_POST["tmp_base64_02"],$_POST["tmp_base64_03"],$_POST["tmp_base64_04"]];
        $old_img = [$_POST["old_img_01"],$_POST["old_img_02"],$_POST["old_img_03"],$_POST["old_img_04"]];
        $product_info = $_POST["product_info"];
        $product_refrigeration = $_POST["product_refrigeration"];
        $product_freezing = $_POST["product_freezing"];
        $product_deadtime = $product_refrigeration."、".$product_freezing;
        $product_element = $_POST["product_element"];
        $product_content = $_POST["product_content"];
        $product_img = array();

        for($i=0;$i<4;$i++){
            if($img[$i] != ""){
                array_push($product_img,$uploadpicture->uploadpicture($product_num,$img[$i],$i));
            }else{
                array_push($product_img,$old_img[$i]);
            }
        }
        $status = $updateProduct->UpdateProductInfo($product_num,$product_catalog,$product_name,$product_price,$product_status,$product_img,$product_info,$product_deadtime,$product_element,$product_content,$product_date,$product_reserve);
        if($status){
            echo "<script>alert('".$product_name."修改完成');</script>";
            echo "<script>document.location.href='/dogeat_server/index.php?action=ProductList&controller=Home';</script>";
        }else{
            echo "<script>alert('".$product_name."修改失敗');</script>";
            echo "<script>document.location.href='/dogeat_server/index.php?action=ProductList&controller=Home';</script>";
        }
    }
    public function addProduct(){
        $addProduct = new VegDatabase();
        $uploadpicture = new ProcessPicture();
        $add_product_catalog = $_POST["product_catalog"];
        $add_product_name = $_POST["product_name"];
        $add_product_price = $_POST["product_price"];
        $add_product_status = $_POST["product_status"];
        $add_product_reserve = $_POST["product_reserve"];
        $product_date = $_POST["product_date"];
        $product_date_hour = $_POST["date_hour"];
        $product_date_min = $_POST["date_min"];
        $add_product_date = $product_date." ".$product_date_hour.":".$product_date_min;
        $img = [$_POST["tmp_base64_01"],$_POST["tmp_base64_02"],$_POST["tmp_base64_03"],$_POST["tmp_base64_04"]];
        $add_product_info = $_POST["product_info"];
        $product_refrigeration = $_POST["product_refrigeration"];
        $product_freezing = $_POST["product_freezing"];
        $add_product_deadtime = $product_refrigeration."、".$product_freezing;
        $add_product_element = $_POST["product_element"];
        $add_product_content = $_POST["product_content"];
        $data_num = (int)$_POST["data_num"];
        $product_img = array();
        if(isset($add_product_name) && isset($add_product_price) && isset($add_product_info) && isset($add_product_element) && isset($add_product_content) && isset($img[0]) && isset($img[1]) && isset($img[2]) && isset($img[3])){
            for($i=0;$i<4;$i++){
                array_push($product_img,$uploadpicture->uploadpicture($data_num+1,$img[$i],$i));
            }
            if($product_img){
                $addProduct->insertProductInfo($add_product_catalog,$add_product_name,$add_product_price,$add_product_status,$product_img,$add_product_info,$add_product_deadtime,$add_product_element,$add_product_content,$add_product_date,$add_product_reserve);
                echo "<script>alert('".$add_product_name."新增完成');</script>";
                echo "<script>document.location.href='/dogeat_server/index.php?action=ProductList&controller=Home';</script>";
            }else{
                echo "<script>alert('".$add_product_name."新增失敗');</script>";
                echo "<script>document.location.href='/dogeat_server/index.php?action=ProductList&controller=Home';</script>";
            }
        }else{
            echo "<script>alert('".$add_product_name."請填寫所有產品資訊');</script>";
            echo "<script>document.location.href='/dogeat_server/index.php?action=ProductList&controller=Home';</script>";
        }
    }
}