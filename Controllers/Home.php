<?php

namespace Controllers;

use Bang\MVC\ControllerBase;
use Bang\Lib\ResponseBag;
use Models\Pagination;
use Models\UserDatabase;
use Models\VegDatabase;
/**
 * 主頁面Controller
 * @author Bang
 */
class Home extends ControllerBase {

    public function index(){
        return $this -> View();
    }

    public function MemberList(){
        $_SESSION['sort_name']='pro_no';
        $_SESSION['sort_by']='ASC';
        $user_data = new UserDatabase();
        $pre_page = 5; //每頁幾筆

        $data = $user_data->CountAllUser();

        if($data != false){
            $data_count_num = $data[0][0];  //總共幾筆資料
        }else{
            echo false;
        }

        $pages_count = ceil($data_count_num/$pre_page); //總頁數

        $member_data = $user_data -> EachPageUserData();
        
        $pagination_data = array(//用vue改寫
            "member_data" => $member_data,
            "pages_count" => $pages_count,
            "pre_page" => $pre_page
        );

        ResponseBag::Add('pagination_data', $pagination_data);
        return $this -> View();
    }

    public function OrderList(){
        $_SESSION['sort_name']='pro_no';
        $_SESSION['sort_by']='ASC';
        $order_data = new UserDatabase();
        $pre_page = 5; //每頁幾筆

        $data = $order_data->CountAllOrder();
        $sum_data =  $order_data->SumAllOrder();
        $order_total_sum = $sum_data[0][0];
        
        if($data != false){
            $data_count_num = $data[0][0];  //總共幾筆資料
        }else{
            echo false;
        }

        $member_order_data = $order_data -> EachPageOrderData(); //當前頁數所有資料

        $order_item_data = array();
        foreach($member_order_data as $a){
            array_push($order_item_data,$order_data ->EachOrderData($a["ord_no"]));
        }

        $pages_count = ceil($data_count_num/$pre_page); //總頁數

        $pagination_data = array(
            "order_total_sum" => $order_total_sum,
            "data_count_num" => $data_count_num,
            "pages_count" => $pages_count,
            "order_data" => $member_order_data,
            "pre_page" => $pre_page,
            "order_item_data" =>$order_item_data,
        );

        ResponseBag::Add('pagination_data', $pagination_data);


        return $this -> View();
    }

    public function ProductList(){
        $user_data = new VegDatabase();
        $pre_page = 5; //每頁幾筆
        if(!isset($_SESSION['sort_name'])){
            $_SESSION['sort_name']='pro_no';
            $_SESSION['sort_by']='ASC';
        }else{
            if(isset($_GET["sort_name"])){//透過API呼叫
                $_SESSION['sort_name']=$_GET["sort_name"];
                $_SESSION['sort_by']=$_GET["sort_by"];
            }
        }

        $data = $user_data->CountAllProduct();

        if($data != false){
            $data_count_num = $data[0][0];  //總共幾筆資料
        }else{
            echo false;
        }

        $product_data = $user_data -> EachPageProductData(); //當前頁數所有資料
        $pages_count = ceil($data_count_num/$pre_page); //總頁數

        $pagination_data = array(
            "pages_count" => $pages_count,
            "product_data" => $product_data,
            "data_count_num" => $data_count_num,
            "pre_page" => $pre_page
        );
        
        ResponseBag::Add('pagination_data', $pagination_data);
        return $this -> View();
    }
    public function ReplyMessage(){
        $_SESSION['sort_name']='pro_no';
        $_SESSION['sort_by']='ASC';
        $user_data = new UserDatabase();
        $pre_page = 5; //每頁幾筆

        $data = $user_data->CountAllemberMessage();

        if($data != false){
            $data_count_num = $data[0][0];  //總共幾筆資料
        }else{
            echo false;
        }

        $pages_count = ceil($data_count_num/$pre_page); //總頁數

        $message_data = $user_data -> SelectAllMemberMessage(); //所有資料
        $pagination_data = array(
            "message_data" => $message_data,
            "pages_count" => $pages_count,
            "pre_page" => $pre_page
        );
        ResponseBag::Add('pagination_data', $pagination_data);

        return $this -> View();
    }
}
