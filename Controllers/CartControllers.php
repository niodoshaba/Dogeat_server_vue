<?php

namespace Controllers;

use Bang\Lib\Response;
use Bang\Lib\TaskResult;
use Bang\MVC\ControllerBase;
use Models\UserDatabase;
use Models\VegDatabase;

/**
 * 主頁面Controller
 * @author Bang
 */
class CartControllers extends ControllerBase {
    public function cartrender(){
        $cus_id = $_GET['cus_id'];
        $cart = new UserDatabase();
        $cart_render_api = $cart->selectCartProduct($cus_id);
        if($cart_render_api->rowCount() != 0){
            $cart_render_info = array();
            while($cart_render_row = $cart_render_api->fetch()){ 
                $cart_render_info[] = $cart_render_row;
            }
        echo json_encode($cart_render_info, JSON_UNESCAPED_UNICODE);
        }
    }
    public function cart(){
        $cart = new VegDatabase();
        $proCataNo="";
        $cart_api = $cart->selectProductList($proCataNo);
        if( $cart_api->rowCount()==0){ 
        }else{ 
          //自資料庫中取回資料
        $cart_info = array();
        while($cart_row = $cart_api->fetch()){ 
            $cart_info[] = $cart_row;
        }
        echo json_encode($cart_info, JSON_UNESCAPED_UNICODE);
          // print_r ($productInfo);
        }
    }
    public function cartadd(){
        $cus_id = $_GET['cus_id'];
        $pro_no = $_GET['pro_no'];
        $product = new VegDatabase();
        $product_info = $product->selectProductInformation($pro_no);
        $json_string = $product_info["product_reserve"];
        if($json_string > 0){
            $cartadd = new UserDatabase();
            $cartadd->cartadd($cus_id,$pro_no);
            echo "true";
        }else{
            echo "false";
        }
    }
    public function deletecart(){
        $orditem_no = $_GET['orditem_no'];
        $deletecart = new UserDatabase();
        $deletecart->deletecart($orditem_no);
    }
    public function cleancart(){
        $cus_id = $_GET['cus_id'];
        $cleancart = new UserDatabase();
        $cleancart->cleancart($cus_id);
    }
}