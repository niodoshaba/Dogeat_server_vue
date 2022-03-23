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
class FrontDeskMemberControllers extends ControllerBase {
    //登入
    public function login(){
        $userId = $_GET['userId'];
        $userPsw = md5($_GET['userPsw']);
        $login = new UserDatabase();
        $status = $login->checkMemberIdAndPsw($userId,$userPsw);
        if($status != false)
        { //登入成功自資料庫中取回資料
            echo json_encode($status[0], JSON_UNESCAPED_UNICODE);
        }else{
            echo false;
        }
    }
    //修改會員資料
    public function MemberUpdate(){
        $cus_id = $_GET['cus_id'];
        $cus_name = $_GET['cus_name'];
        $cus_phone = $_GET['cus_phone'];
        $updateMember = new UserDatabase();
        $status = $updateMember->updateMember($cus_id,$cus_name,$cus_phone);
    }
    //註冊
    public function signup(){
        $sign_account = $_GET['sign_account'];
        $sign_password = md5($_GET['sign_password']) ;
        $sign_phone = $_GET['sign_phone'];
        $sign_name = $_GET['sign_name'];
        $cus_from = $_GET['cus_from'];
        $signup = new UserDatabase();
        $checkUser=$signup->checkMemberDuplicate($sign_account,$sign_phone);
        if($checkUser == false){
            $signup->signup($sign_account,$sign_password,$sign_phone,$sign_name,"",$cus_from);
            echo true;
        }else{
            echo false;   
        }
    }
    public function CreateOrder(){
        $ord_price = $_GET["ord_price"];
        $ord_address = $_GET["ord_address"];
        $ord_phone = $_GET["ord_phone"];
        $now_date = $_GET["now_date"];
        $pro_no = $_GET["pro_no_string"];
        $ord_payment_method = "轉帳";
        $ord_payment_status = "未付款";
        if(isset($_GET["ord_no"])){
            $ord_no = $_GET["ord_no"];
            $ord_payment_method = $_GET["ord_payment_method"];
            $ord_payment_status = $_GET["ord_payment_status"];
        }
        $pro_no_array = mb_split("_",$pro_no);
        $pro_amount_array = [];
        $pro_amount_array[0] = false;
        //---start---統計數量---start---
        for($i=0;$i<count($pro_no_array);$i++){
            if(!isset($pro_amount_array[$pro_no_array[$i]])){
                $pro_amount_array[$pro_no_array[$i]]=1;
            }else{
                $pro_amount_array[$pro_no_array[$i]]++;
            }
        }
        //---end---統計數量---end---
        //---start---檢查訂貨數量以及庫存---start---
        $product = new VegDatabase();
        foreach($pro_amount_array as $pro_id => $value){
            if($pro_id>0){
                $pro_info = $product->selectProductInformation($pro_id);
                if($pro_info["product_reserve"] < $value){
                    $pro_amount_array[0]=true;
                    $pro_amount_array[$pro_id]=$pro_info["pro_name"]."_".$pro_info["product_reserve"];//如果庫存少於訂貨的量的話會把該所引的值改成少於庫存的產品名稱
                }
            }
        }
        //---end---檢查訂貨數量以及庫存---end---
        //---start---如果有超過庫存的話就回傳---start---
        foreach($pro_amount_array as $pro_id => $value){
            if(!is_numeric($pro_amount_array[$pro_id]) && $pro_id>0){
                echo json_encode($pro_amount_array);
                die();
            }
        }
        //---end---如果有超過庫存的話就回傳---end---
        //---start---建立訂單---start---
        $CreateOrder = new UserDatabase();
        if(!isset($_GET["ord_no"])){
            $last_id = $CreateOrder->CreateOrder("",$ord_price,$ord_address,$ord_phone,$now_date,$ord_payment_method,$ord_payment_status);
        }else{
            $last_id = (int)$ord_no;
            $CreateOrder->CreateOrder($last_id,$ord_price,$ord_address,$ord_phone,$now_date,$ord_payment_method,$ord_payment_status);
        }
        if($last_id){
            if($CreateOrder->CreateOrderDetailsInfo($pro_no_array,$last_id)){
                foreach($pro_amount_array as $pro_id => $value){
                    if($pro_id>0){
                    $pro_info = $product->selectProductInformation($pro_id);
                    $product_reserve = $pro_info["product_reserve"] - $value;
                    $product -> Updateproduct_reserve($pro_id,$product_reserve);
                    }
                }
                echo json_encode($pro_amount_array);
            }else{
                echo false;
            }
        }else{
            echo false;
        }
        //---end---建立訂單---end---
    }
    public function CheckOrderInfo(){
        $cus_phone = $_GET["cus_phone"];
        $CreateOrderDetailsInfo = new UserDatabase();
        $status = $CreateOrderDetailsInfo->CheckOrderInfo($cus_phone);

        echo json_encode($status, JSON_UNESCAPED_UNICODE);
    }
    public function CancelOrder(){
        $ord_no = $_GET["ord_no"];
        if(isset($_GET["ord_status"])){
            $ord_status = $_GET["ord_status"];
        }else{
            $ord_payment_status = $_GET["ord_payment_status"];
            $ord_status = "未出貨";
        }
        $CreateOrderDetailsInfo = new UserDatabase();
        $status = $CreateOrderDetailsInfo->UpdateOrder($ord_no,$ord_status,$ord_payment_status);
    }
    public function LeaveMessage(){
        $cus_phone = $_GET["cus_phone"];
        $mes_content =$_GET["mes_content"];
        $now_date = $_GET["now_date"];
        $InsertMessage = new UserDatabase();
        echo $InsertMessage->InsertMessage($cus_phone,$mes_content,$now_date);
    }
    public function GetMemberMessage(){
        $cus_phone = $_GET["cus_phone"];
        $SelectMemberMessage = new UserDatabase();
        echo json_encode($SelectMemberMessage->SelectMemberMessage($cus_phone), JSON_UNESCAPED_UNICODE);
    }
    public function EarnPoint(){
        $ord_price = $_GET["ord_price"];
        $cus_phone = $_GET["cus_phone"];
        
        $update_user_point = new UserDatabase();
        $status = $update_user_point->UpdateUserPointAdd($ord_price,$cus_phone);
    }
    public function UsePoint(){
        $use_point = $_GET["use_point"];
        $cus_phone = $_GET["cus_phone"];
        
        $update_user_point = new UserDatabase();
        $status = $update_user_point->UpdateUserPointLess($use_point,$cus_phone);
    }
    public function ThirdPartyLogin(){
        $cus_id = $_GET["cus_id"];
        $cus_password = md5($_GET["cus_password"]);
        $cus_name = $_GET["cus_name"];
        $cus_from = $_GET["cus_from"];
        $third_party_login = new UserDatabase();
        $checkUser=$third_party_login->checkMemberDuplicate($cus_id);
        if($checkUser == false){
            $third_party_login->signup($cus_id,$cus_password,"",$cus_name,"",$cus_from);
        }
        $status = $third_party_login->checkMemberIdAndPsw($cus_id,$cus_password);
        if($status != false)
        { //登入成功自資料庫中取回資料
            echo json_encode($status[0], JSON_UNESCAPED_UNICODE);
        }else{
            echo $status;
        }
    }
    public function UsePointForGame(){
        $cus_phone = $_GET["cus_phone"];
        $Bargaining_chip = $_GET["Bargaining_chip"];
        $game = new UserDatabase();
        $point = $game->SelectPoint($cus_phone);
        $num1=rand(0,5);
        $num2=rand(0,5);
        $num3=rand(0,5);
        $point = $point[0]["cus_point"];
        $enough_point = true;
        if($point >= $Bargaining_chip){
            $point = $point-$Bargaining_chip;
        }else{
            $enough_point = false;
        }
        if($enough_point){
            if($num1 == $num2 && $num1 == $num3){
                $point = $point+$Bargaining_chip*5;
                $mes = "King";
            }else if($num1 == $num2 || $num1 == $num3 || $num2 == $num3){
                $point = $point+$Bargaining_chip*1.5;
                $mes = "Congratulations";
            }else{
                $mes = "LOSE";
            }
        }else{
            $mes = "點數不足";
        }
        $game->UpdataPoint($cus_phone,$point);
        $game_reslut = [$point,$num1,$num2,$num3,$mes];
        echo json_encode($game_reslut, JSON_UNESCAPED_UNICODE);
    }
}