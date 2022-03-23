<?php
    namespace Models;
    use Bang\MVC\DbContext;
    /*與資料庫連接並處理資料*/
    class VegDatabase{
        //前台
        function selectAllVegBenefit(){
            $pdo = new DbContext();
            $sql = "SELECT * FROM `veg_benefit`";
            $vegApi = $pdo->query($sql);
            return $vegApi;
        }
        function selectProductList($proCataNo){
            $pdo = new DbContext();
            if($proCataNo != ""){
                $sql = "SELECT pro_no, pro_name, pro_price, pro_img,pro_status,pro_all_info,product_reserve
                FROM `product`
                WHERE cata_no = '$proCataNo'
                ";
            }else{
                $sql = "SELECT pro_no, pro_name, pro_price, pro_img
                FROM `product`
                ";
            }
            $productApi = $pdo->query($sql);
            return $productApi;
        }
        function selectProductInfo($pro_no){
            $pdo = new DbContext();
            $sql = "SELECT *
                    FROM `product`
                    WHERE pro_no = '$pro_no'
                    ";
            $productApi = $pdo->query($sql);
            return $productApi;
        }
        //後台
        function selectALLProduct(){
            $pdo = new DbContext();
            $sql = "select product.pro_no,product.pro_name,product.pro_price,product.pro_status,product.pro_img,catalog.cata_name
            from product, catalog where product.cata_no = catalog.cata_no";
            $data = $pdo->query($sql);
            $productInfo=array();
            while($customRow = $data->fetch()){ 
                $productInfo[] = $customRow;
            }
            return $productInfo;
        }
        function CountAllProduct(){
            $pdo = new DbContext();
            $sql = "SELECT count(pro_no) FROM `product`";
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
        function EachPageProductData($page=0,$per_page=0){
            $pdo = new DbContext();
            $sort_name = $_SESSION['sort_name'];
            $sort_by = $_SESSION['sort_by'];
            $sql = "select product.pro_no,product.pro_name,product.pro_price,product.product_reserve,product.pro_status,product.pro_img,catalog.cata_name,product.pro_all_info
            from product, catalog where product.cata_no = catalog.cata_no ORDER BY `product`.`$sort_name` $sort_by";
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
        function selectProductInformation($pro_id){
            $pdo = new DbContext();
            $sql = "SELECT * FROM `product`
            WHERE pro_no = '$pro_id'
            ";
            $productInformation = $pdo->query($sql);
            $productInfo = array();
            while($productRow = $productInformation->fetch()){ 
                $productInfo = $productRow;
            }
            return $productInfo;
        }
        // function inserProduct($add_product_catalog,$add_product_name,$add_product_price,$add_product_status,$add_product_img,$add_product_info,$add_product_deadtime,$add_product_element,$add_product_content){
        //     $pdo = new DbContext();
        //     $sql = "INSERT INTO `product`(`cata_no`, `pro_name`, `pro_price`, `pro_status`, `pro_img`,`pro_info`,`pro_deadtime`,`pro_element`,`pro_content`) 
        //     VALUES ($add_product_catalog,'$add_product_name','$add_product_price','$add_product_status','$add_product_img','$add_product_info','$add_product_deadtime','$add_product_element','$add_product_content')
        //     ";
        //     $pdo->query($sql);
        // }
        // function updateProduct($product_num,$product_catalog,$product_name,$product_price,$product_status,$product_img,$product_info,$product_deadtime,$product_element,$product_content){
        //     $pdo = new DbContext();
        //     $sql = "UPDATE `product` SET `cata_no`=$product_catalog,`pro_name`='$product_name',`pro_price`='$product_price',`pro_status`='$product_status',`pro_img`='$product_img' 
        //     ,`pro_info`='$product_info',`pro_deadtime`='$product_deadtime',`pro_element`='$product_element',`pro_content`='$product_content'
        //     WHERE `pro_no`=$product_num
        //     ";
        //     $pdo->query($sql);
        // }

        function insertProductInfo($add_product_catalog,$add_product_name,$add_product_price,$add_product_status,$add_product_img,$add_product_info,$add_product_deadtime,$add_product_element,$add_product_content,$add_product_date,$add_product_reserve){
            $pdo = new DbContext();
            $sql = "INSERT INTO `product`(`cata_no`, `pro_name`, `pro_price`,`product_reserve`, `pro_status`, `pro_img`,`pro_all_info`) 
            VALUES ('$add_product_catalog','$add_product_name','$add_product_price','$add_product_reserve','{\"status\":\"$add_product_status\",\"date\":\"$add_product_date\"}',
                '{\"img_01\": \"$add_product_img[0]\", \"img_02\": \"$add_product_img[1]\", \"img_03\": \"$add_product_img[2]\" ,\"img_04\": \"$add_product_img[3]\"}',
                '{\"pro_info\": \"$add_product_info\", \"pro_deadtime\": \"$add_product_deadtime\", \"product_element\":\"$add_product_element\", \"product_content\":\"$add_product_content\"}')
            ";
            $pdo->query($sql);
        }

        function UpdateProductInfo($product_num,$product_catalog,$product_name,$product_price,$product_status,$product_img,$product_info,$product_deadtime,$product_element,$product_content,$product_date,$product_reserve){
            $pdo = new DbContext();
            $sql = "UPDATE `product` SET `cata_no`=$product_catalog,`pro_name`='$product_name',`pro_price`='$product_price',`product_reserve`=$product_reserve,`pro_status`='{\"status\":\"$product_status\",\"date\":\"$product_date\"}',
            `pro_img`='{\"img_01\": \"$product_img[0]\", \"img_02\": \"$product_img[1]\", \"img_03\": \"$product_img[2]\" ,\"img_04\": \"$product_img[3]\"}',
            `pro_all_info`='{\"pro_info\": \"$product_info\", \"pro_deadtime\": \"$product_deadtime\", \"product_element\":\"$product_element\", \"product_content\":\"$product_content\"}'
            WHERE `pro_no`=$product_num
            ";
            $pdo->query($sql);
            return true;
        }

        function Updateproduct_reserve($pro_no,$product_reserve){
            $pdo = new DbContext();
            $sql = "UPDATE `product` SET `product_reserve`=$product_reserve
            WHERE `pro_no`=$pro_no
            ";
            $pdo->query($sql);
            return true;
        }
    }
?>
