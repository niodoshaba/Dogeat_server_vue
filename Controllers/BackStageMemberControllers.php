<?php

namespace Controllers;

use Bang\Lib\Response;
use Bang\Lib\TaskResult;
use Bang\MVC\ControllerBase;
use Models\UserDatabase;
use Bang\Lib\ResponseBag;

/**
 * 主頁面Controller
 * @author Bang
 */
class BackStageMemberControllers extends ControllerBase {
    public function showAllUser(){
        $show = new UserDatabase();
        $data = $show->selectAllUser();
        if($data != false){
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }else{
            echo false;
        }
    }
    public function showUserByNo(){
        $cus_no = $_POST['cus_no'];
        $show = new UserDatabase();
        $data = $show->selectUserByNo($cus_no);
        if($data != false){
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }else{
            echo false;
        }
    }
    public function signup(){
        $addUser = new UserDatabase();
        $sign_phone = $_GET['add_member_phone'];
        $sign_account = $_GET['add_member_account'];
        $sign_password = md5($_GET['add_member_password']);
        $sign_address = $_GET['add_member_address'];
        $sign_name = $_GET['add_member_name'];
        if(strlen($sign_phone)==10){
            $status = $addUser->checkMemberDuplicate($sign_account,$sign_phone);
            if($status == false){
                $addUser->signup($sign_account,$sign_password,$sign_phone,$sign_name,$sign_address);
                echo $sign_account."註冊成功";
            }else{
                if($status[0]['0'] == $sign_phone && $status[0]['1'] == $sign_account){
                    echo "此手機以及帳號皆重複";
                }elseif($status[0]['0'] == $sign_phone){
                    echo "此手機重複";
                }else{
                    echo "此帳號重複";
                }
            };
        }else{
            echo "手機格式有誤";
        }
    }
    public function deleteUser(){
        $cus_no = $_POST['cus_no'];
        $deleteUser = new UserDatabase();
        $deleteUser->deleteUser($cus_no);
        echo "已刪除編號為".$cus_no."的使用者";
    }

    public function updataUser(){
        $member_name = $_POST['member_name'];
        $member_address = $_POST['member_address'];
        $member_phone = $_POST['member_phone'];
        $member_account = $_POST['member_account'];
        $member_status = $_POST['member_status'];
        $updataUser = new UserDatabase();
        $updataUser->updateMember($member_account,$member_name,$member_phone,$member_address,$member_status);
        echo "用戶".$member_account."已修改";
    }

    public function Search(){
            $key_in_text = $_GET['key_in_text'];
            $search_target_page = $_GET['search_target_page'];

            $search_user = new UserDatabase();
            
            if($search_target_page == "MemberList"){
                $search_data = $search_user -> SearchMemberByPhone($key_in_text);
            }
            if($search_target_page == "ProductList"){
                $search_data = $search_user -> SearchProductByName($key_in_text);
            }
            if($search_target_page == "OrderList"){
                $search_order = $search_user -> SearchOrderByPhone($key_in_text);
                $search_each_data = $search_user -> SearchOrderByPhoneEachData($key_in_text);
                
                $search_data = [$search_order,$search_each_data];
            }

            if($search_data == false){  
                return false;
            }else{
            echo json_encode($search_data, JSON_UNESCAPED_UNICODE);
            }
    }

    public function UpdateOrder(){
        $ord_no = $_POST["ord_no"];
        $ord_status = $_POST["ord_status"];
        $updateOrder = new UserDatabase();
        $updateOrder->UpdateOrder($ord_no, $ord_status);
        echo "訂單編號: ".$ord_no."已修改";
    }
    public function ReturnPayButNoyShipmentOrder(){
        $data = new UserDatabase();
        echo json_encode($data->ReturnPayButNoyShipmentOrder(),JSON_UNESCAPED_UNICODE);
    }
    public function DeleteMemberMessage(){
        $delete_id = $_GET["delete_id"];
        $DeleteMemberMessage = new UserDatabase();
        echo $DeleteMemberMessage->DeleteMemberMessage($delete_id);
    }
    public function ReplyMemberMessage(){
        $reply_id = $_GET["reply_id"];
        $administrator_Reply = $_GET["administrator_Reply"];
        $now_date = $_GET["now_date"];
        $AdministratorReply = new UserDatabase();
        echo $AdministratorReply->AdministratorReply($reply_id,$administrator_Reply,$now_date);
    }
}