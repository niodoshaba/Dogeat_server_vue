<?php

namespace Controllers;

use Bang\Lib\Response;
use Bang\Lib\TaskResult;
use Bang\MVC\ControllerBase;
use Models\VegDatabase;

/**
 * 主頁面Controller
 * @author Bang
 */
class FrontDeskProductControllers extends ControllerBase {
    //蔬菜零食&蔬菜粉粉
    public function proList(){
        $proCataNo = $_GET['proCataNo'];
        $proList = new VegDatabase();
        $status = $proList->selectProductList($proCataNo);
        if($status->rowCount()==0){ 
            echo "沒這種類";
        }else{ 
        //自資料庫中取回資料
            $productInfo = array();
            while($productRow = $status->fetch()){ 
            $productInfo[] = $productRow;
        }
        echo json_encode($productInfo, JSON_UNESCAPED_UNICODE);
        }
    }
    public function proInfo(){
        $pro_no = $_GET['pro_no'];
        $proInfo = new VegDatabase();
        $status = $proInfo->selectProductInfo($pro_no);
        if($status->rowCount()==0){ 
            echo "沒這種類";
        }else{ 
        //自資料庫中取回資料
            $productInfo = array();
            while($productRow = $status->fetch()){ 
            $productInfo[] = $productRow;
        }
        echo json_encode($productInfo, JSON_UNESCAPED_UNICODE);
        }
    }
    //蔬菜功效
    public function vegBenefit(){
        $vegBenefit = new VegDatabase();
        $status = $vegBenefit->selectAllVegBenefit();
        if( $status->rowCount()==0){ 
            echo "沒這菜";
        }else{ 
          //自資料庫中取回資料
          $vegInfo = array();
          while($vegRow = $status->fetch()){ 
            $vegInfo[] = $vegRow;
          }

          echo json_encode($vegInfo, JSON_UNESCAPED_UNICODE);
        }
    }
}