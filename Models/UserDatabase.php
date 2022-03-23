<?php
    namespace Models;
    use Bang\MVC\DbContext;
    /*與資料庫連接並處理資料*/
    class UserDatabase{
        //前台
        function checkMemberIdAndPsw($userId,$userPsw){
            $pdo = new DbContext();
            $sql = "SELECT * FROM `custom` WHERE 
            cus_id = '$userId' AND cus_password = '$userPsw'";
            $customApi = $pdo->query($sql);
            if( $customApi->rowCount()==0)
            { //查無此人
                return false;
            }else{//查找成功自資料庫中取回資料
                $customInfo = array();
                while($customRow = $customApi->fetch()){ 
                    $customInfo[] = $customRow;
                }
                return $customInfo;
            }
        }
        //購物車
        function selectCartProduct($cus_id){
            $pdo = new DbContext();
            $sql = "SELECT cus_ord.orditem_no, cus_ord.pro_no, product.pro_name, product.pro_price, product.pro_img 
            FROM cus_ord , product 
            WHERE cus_id = '$cus_id' and cus_ord.pro_no = product.pro_no
            ";
            $cart_render_api = $pdo->query($sql);
            return $cart_render_api;
        }

        function cartadd($cus_id,$pro_no){
            $pdo = new DbContext();
            $sql = "INSERT INTO cus_ord ( cus_id, pro_no )
            VALUES ( '$cus_id', '$pro_no' );
            ";
            $cart_add_api = $pdo->query($sql);
        }
        
        function deletecart($orditem_no){
            $pdo = new DbContext();
            $sql = "DELETE FROM cus_ord WHERE orditem_no = '$orditem_no'";
            $deletecart = $pdo->query($sql);
        }
        function cleancart($cus_id){
            $pdo = new DbContext();
            $sql = "DELETE FROM cus_ord WHERE cus_id = '$cus_id'";
            $deletecart = $pdo->query($sql);
        }
        //後台
        function selectAllUser(){
            $pdo = new DbContext();
            $sql = "SELECT `cus_phone`, `cus_id`, `cus_name`, `cus_address`, `cus_status` FROM `custom`";
            $customApi = $pdo->query($sql);
            if( $customApi->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $customInfo = array();
                while($customRow = $customApi->fetch()){ 
                    $customInfo[] = $customRow;
                }
                return $customInfo;
            }
        }
        function selectUserByNo($cus_no){
            $pdo = new DbContext();
            $sql = "SELECT `cus_phone`, `cus_id`, `cus_name`, `cus_address`, `cus_status` FROM `custom` Where cus_no = '$cus_no'";
            $customApi = $pdo->query($sql);
            if( $customApi->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $customInfo = array();
                while($customRow = $customApi->fetch()){ 
                    $customInfo[] = $customRow;
                }
                return $customInfo;
            }
        }
        function CountAllUser(){
            $pdo = new DbContext();
            $sql = "SELECT count(cus_id) FROM `custom`";
            $customApi = $pdo->query($sql);
            if( $customApi->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $customInfo = array();
                while($customRow = $customApi->fetch()){ 
                    $customInfo[] = $customRow;
                }
                return $customInfo;
            }
        }
        function EachPageUserData($page=0,$data_count=0){
            $page_count=($page-1)*$data_count;
            $pdo = new DbContext();
            // $sql = "SELECT * FROM `custom` LIMIT $page_count,$data_count";
            $sql = "SELECT * FROM `custom`";//用vue改寫
            $customApi = $pdo->query($sql);
            if( $customApi->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $customInfo = array();
                while($customRow = $customApi->fetch()){ 
                    $customInfo[] = $customRow;
                }
                return $customInfo;
            }
        }
        function deleteUser($cus_no){
            $pdo = new DbContext();
            $sql = "DELETE FROM custom WHERE cus_no = '$cus_no'";
            $pdo->query($sql);
        }
        //前後相關
        function checkMemberDuplicate($sign_account,$sign_phone = ""){
            $pdo = new DbContext();
            $sql = "SELECT * FROM `custom` WHERE
            cus_id = '$sign_account'";
            $customApi = $pdo->query($sql);
            if( $customApi->rowCount()==0)
            { //查無此人
                return false;
            }else{//查找成功自資料庫中取回資料
                return true;
            }
        }
        function signup($sign_account,$sign_password,$sign_phone="",$sign_name,$sign_address ="",$cus_from =""){
            $pdo = new DbContext();
            if($sign_address != ""){
                $sql = "INSERT INTO custom ( cus_phone, cus_id, cus_password, cus_name ,cus_address, cus_from)
                VALUES ( '$sign_phone', '$sign_account', '$sign_password', '$sign_name' , '$sign_address', '$cus_from');
                ";
            }else{
                $sql = "INSERT INTO custom ( cus_phone, cus_id, cus_password, cus_name, cus_from)
                VALUES ( '$sign_phone', '$sign_account', '$sign_password', '$sign_name', '$cus_from');
                ";
            }
            $cart_add_api = $pdo->query($sql);
        }
        function updateMember($cus_id,$cus_name,$cus_phone,$member_address="",$member_status=""){
            $pdo = new DbContext();
            if($member_address && $member_status){
                $sql = "UPDATE `custom` 
                SET `cus_phone`='$cus_phone',`cus_name`='$cus_name',`cus_address`= '$member_address',`cus_status`='$member_status'
                WHERE `cus_id`='$cus_id'";
            }else{
                $sql = "UPDATE `custom` 
                SET `cus_phone`='$cus_phone',`cus_name`='$cus_name'
                WHERE `cus_id`='$cus_id'";
            }
            $status = $pdo->query($sql);
        }
        function SearchMemberByPhone($key_in_text){
            $pdo = new DbContext();
            $sql = "SELECT * 
                    FROM `custom`
                    WHERE cus_phone = '$key_in_text'
                    ";
            $status = $pdo->query($sql);
            if( $status->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $search_info = array();
                while($search_row = $status->fetch()){ 
                    $search_info[] = $search_row;
                }
                return $search_info;
            }
        }

        function SearchProductByName($key_in_text){
            $pdo = new DbContext();
            $sql = "SELECT * 
                    FROM `product`
                    WHERE pro_name = '$key_in_text'
                    ";
            $status = $pdo->query($sql);
            if( $status->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $search_info = array();
                while($search_row = $status->fetch()){ 
                    $search_info[] = $search_row;
                }
                return $search_info;
            }
        }
        function SearchOrderByPhone($key_in_text){
            if(is_numeric($key_in_text)){
                $ord_no = $key_in_text;
            }else{
                $ord_no = 0;
            }
            $pdo = new DbContext();
            $sql = "SELECT *
                    FROM `order`
                    WHERE cus_phone = '$key_in_text' or ord_no = $ord_no
                    ";
            $status = $pdo->query($sql);
            if( $status->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $search_info = array();
                while($search_row = $status->fetch()){ 
                    $search_info[] = $search_row;
                }
                return $search_info;
            }
        }
        function SearchOrderByPhoneEachData($key_in_text){
            if(is_numeric($key_in_text)){
                $ord_no = $key_in_text;
            }else{
                $ord_no = 0;
            }
            $pdo = new DbContext();
            if($ord_no == 0){
                $sql = "SELECT product.pro_name, order.ord_no
                FROM `order`, `product`, `order_item`
                WHERE cus_phone = '$key_in_text'
                AND   order.ord_no = order_item.ord_no
                AND   order_item.pro_no = product.pro_no
                ";
            }else{
                $sql = "SELECT product.pro_name, order.ord_no
                FROM `order`, `product`, `order_item`
                WHERE cus_phone = '$key_in_text'  or order.ord_no = $ord_no
                AND   order.ord_no = order_item.ord_no
                AND   order_item.pro_no = product.pro_no
                ";
            }
            $status = $pdo->query($sql);
            if( $status->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $search_info = array();
                while($search_row = $status->fetch()){ 
                    $search_info[] = $search_row;
                }
                return $search_info;
            }
        }

        function CreateOrder($ord_no="",$ord_price,$ord_address,$ord_phone,$now_date,$ord_payment_method,$ord_payment_status){
            $pdo = new DbContext();
            if($ord_no == ""){
                $sql = "INSERT INTO `order` ( ord_price,ord_date, ord_address, cus_phone,ord_payment_status,ord_payment_method)
                VALUES ( '$ord_price','$now_date', '$ord_address', '$ord_phone','$ord_payment_status','$ord_payment_method');
                ";
            }else{
                $sql = "INSERT INTO `order` ( ord_no,ord_price,ord_date, ord_address, cus_phone,ord_payment_status,ord_payment_method)
                VALUES ( $ord_no,'$ord_price','$now_date', '$ord_address', '$ord_phone','$ord_payment_status','$ord_payment_method');
                ";
            }
            $last_id =$pdo->Insert($sql);
            if($last_id){
                return $last_id;
            }else{
                return false;
            }
        }

        function CreateOrderDetailsInfo($pro_no,$insert_id){
            $pdo = new DbContext();
            $value="";
            for($i=0;$i<count($pro_no);$i++){
                if($i+1 != count($pro_no)){
                    $value = $value."( $pro_no[$i],$insert_id),";
                }else{
                    $value = $value."( $pro_no[$i],$insert_id)";
                }
            }
            $sql = "INSERT INTO `order_item` ( pro_no, ord_no)
            VALUES $value;
            ";
            if($pdo->Insert($sql)){
                return true;
            }else{
                return false;
            }
        }
        function CountAllOrder(){
            $pdo = new DbContext();
            $sql = "SELECT count(ord_no) FROM `order`";
            $order_Api = $pdo->query($sql);
            if( $order_Api->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $order_Info = array();
                while($order_Row = $order_Api->fetch()){ 
                    $order_Info[] = $order_Row;
                }
                return $order_Info;
            }
        }
        function SumAllOrder(){
            $pdo = new DbContext();
            $sql = "SELECT SUM(ord_price)
                    FROM `order`;";
            $order_Api = $pdo->query($sql);
            if( $order_Api->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $order_Info = array();
                while($order_Row = $order_Api->fetch()){ 
                    $order_Info[] = $order_Row;
                }
                return $order_Info;
            }
        }
        function EachPageOrderData($page=0,$data_count=0){
            $pdo = new DbContext();
            $sql = "SELECT * 
                    FROM `order` 
                    ";
            $order_Api = $pdo->query($sql);
            if( $order_Api->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $order_Info = array();
                while($order_Row = $order_Api->fetch()){ 
                    $order_Info[] = $order_Row;
                }
                return $order_Info;
            }
        }
        function EachOrderData($ord_no){
            $pdo = new DbContext();
            $sql = "SELECT product.pro_name
                    FROM `order` , `order_item`, `product`
                    WHERE order.ord_no = '$ord_no'
                    AND   order.ord_no = order_item.ord_no
                    AND   order_item.pro_no = product.pro_no
                    ";
            $order_Api = $pdo->query($sql);
            if( $order_Api->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $order_Info = array();
                while($order_Row = $order_Api->fetch()){ 
                    $order_Info[] = $order_Row;
                }
                return $order_Info;
            }
        }
        function UpdateOrder($ord_no,$ord_status="未出貨",$ord_payment_status="未付款"){
            $pdo = new DbContext();
            $sql = "UPDATE `order` 
                    SET `ord_status`='$ord_status',`ord_payment_status` = '$ord_payment_status'
                    WHERE `ord_no` = '$ord_no'";
            $pdo->query($sql);
        }
        function CheckOrderInfo($cus_phone){
            $pdo = new DbContext();
            $sql = "SELECT `ord_no`, `ord_price`, `ord_status` 
                    FROM `order`
                    WHERE cus_phone = '$cus_phone'";
            $check_order = $pdo->query($sql);
            if( $check_order->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $check_order_Info = array();
                while($check_order_Row = $check_order->fetch()){ 
                    $check_order_Info[] = $check_order_Row;
                }
                return $check_order_Info;
            }
        }
        function ReturnPayButNoyShipmentOrder(){
            $pdo = new DbContext();
            $sql = "SELECT * 
            FROM `order`
            WHERE ord_status = '未出貨' && ord_payment_status = '已付款'";
            $data = $pdo->query($sql);
            if($data->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $order_Info = array();
                while($order_Row = $data->fetch()){ 
                    $order_Info[] = $order_Row;
                }
                return $order_Info;
            }
        }
        function UpdateUserPointAdd($ord_price,$cus_phone){
            $pdo = new DbContext();
            $sql = "UPDATE `custom` 
                    SET `cus_point`= `cus_point` + ('$ord_price' div 100)
                    WHERE `cus_phone` = '$cus_phone'
                    ";
            $pdo->query($sql);
        }
        function UpdateUserPointLess($use_point,$cus_phone){
            $pdo = new DbContext();
            $sql = "UPDATE `custom` 
                    SET `cus_point`= `cus_point` - '$use_point'
                    WHERE `cus_phone` = '$cus_phone'
                    ";
            $pdo->query($sql);
        }
        function InsertMessage($cus_phone,$mes_content,$now_date){
            $pdo = new DbContext();
            $sql = "INSERT INTO `message`(`cus_phone`, `mes_content` , `leave_time`) VALUES ('$cus_phone','$mes_content','$now_date')";
            if($pdo->Insert($sql)){
                return true;
            }else{
                return false;
            };
        }
        function SelectMemberMessage($cus_phone){
            $pdo = new DbContext();
            $sql = "SELECT * FROM `message` WHERE cus_phone = '$cus_phone' ORDER BY `message`.`id` DESC LIMIT 5";
            $Message = $pdo->query($sql);
            if( $Message->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $Message_Conten = array();
                while($Message_Row = $Message->fetch()){ 
                    $Message_Conten[] = $Message_Row;
                }
                return $Message_Conten;
            }
        }
        function CountAllemberMessage(){
            $pdo = new DbContext();
            $sql = "SELECT count(id) FROM `message`";
            $count = $pdo->query($sql);
            if( $count->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $message_Info = array();
                while($message_Row = $count->fetch()){ 
                    $message_Info[] = $message_Row;
                }
                return $message_Info;
            }
        }
        function SelectAllMemberMessage($page=0,$data_count=0){
            //$page_count=($page-1)*$data_count;      
            //$sql = "SELECT * FROM `message` ORDER BY `message`.`id` DESC LIMIT $page_count,$data_count";
            //用vue改寫
            $pdo = new DbContext();
            $sql = "SELECT * FROM `message` ORDER BY `message`.`id` DESC";
            $messageApi = $pdo->query($sql);
            if( $messageApi->rowCount()==0)
            {
                return false;
            }else{//查找成功自資料庫中取回資料
                $messageInfo = array();
                while($messageRow = $messageApi->fetch()){ 
                    $messageInfo[] = $messageRow;
                }
                return $messageInfo;
            }
        }
        function DeleteMemberMessage($delete_id){
            $pdo = new DbContext();
            $sql = "DELETE FROM `message` WHERE id = '$delete_id'";
            $pdo->query($sql);
            return true;
        }
        function AdministratorReply($reply_id,$administrator_Reply,$now_date){
            $pdo = new DbContext();
            $sql = "UPDATE `message` 
                    SET `administrator_Reply`='$administrator_Reply',`reply_time`='$now_date'
                    WHERE `id` = '$reply_id'";
            $pdo->query($sql);
            return true;
        }
        function SelectPoint($cus_phone){
            $pdo = new DbContext();
            $sql = "SELECT `cus_point` FROM `custom` WHERE `cus_phone` = '$cus_phone'";
            $user_point = $pdo->query($sql);
            if($user_point -> rowCount()==0){
                return false;
            }else{
                $messageInfo = array();
                while($messageRow = $user_point->fetch()){ 
                    $messageInfo[] = $messageRow;
                }
                return $messageInfo;
            }
        }
        function UpdataPoint($cus_phone,$point){
            $pdo = new DbContext();
            $sql = "UPDATE `custom` 
                    SET `cus_point`= '$point'
                    WHERE `cus_phone` = '$cus_phone'
                    ";
            $pdo->query($sql);
        }
    }
?>