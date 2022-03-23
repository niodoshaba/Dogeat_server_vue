<?php 
    namespace Models;

    use Models\UserDatabase;
    use Models\VegDatabase;

    class Pagination{

        function __construct($pages_count, $page) {
            $this->pages_count = $pages_count;
            $this->page = $page;
        }

        public function ShowPagination(){
            if(strpos($_SERVER['QUERY_STRING'],"action=MemberList") !== false){
                $action = "MemberList";
            }
            if(strpos($_SERVER['QUERY_STRING'],"action=ProductList") !== false){
                $action = "ProductList";
            }
            if(strpos($_SERVER['QUERY_STRING'],"action=OrderList") !== false){
                $action = "OrderList";
            }

            echo '<ul class="pagination float-right">
                    <li class="page-item ">
                        <a class="page-link" id="page_back" style="cursor:pointer"><</a>
                    </li>';
            //分頁頁碼
            for($i=1 ; $i<=$this -> pages_count ; $i++){
                if( $this -> page -10 < $i && $i < $this -> page +10 ){
                    echo '<li class="page-item">
                            <a class="page-link" href="index.php?action='.$action.'&controller=Home&Page='.$i.'">'.$i.'</a>
                        </li>';        
                }
            } 
            echo '  <li class="page-item">
                        <a class="page-link" id="page_next" style="cursor:pointer">></a>
                    </li>
                </ul>';
        }

        // public function Pagination(){
        //     $pages_count = $this -> PaginationTotalPage($this->pre_page); //總頁數(每頁幾筆)
        //     $page = $this -> PaginationCurrentPage(); //當前頁數
        //     $pagination_data = array(
        //         "pages_count" => $pages_count,
        //         "page" => $page,
        //     );
        //     return $pagination_data;
        // }

        // public function PaginationTotalDataCount(){
        //     if(strpos($_SERVER['QUERY_STRING'],"action=MemberList") !== false){
        //         $count = new UserDatabase();
        //         $data = $count->CountAllUser();
        //         if($data != false){
        //             $count_num = $data[0][0];
        //         }else{
        //             echo false;
        //         }
        //     }
            
        //     if(strpos($_SERVER['QUERY_STRING'],"action=ProductList") !== false){
        //         $count = new VegDatabase();
        //         $data = $count->CountAllProduct();
        //         if($data != false){
        //             $count_num = $data[0][0];
        //         }else{
        //             echo false;
        //         }
        //     }
        //     return $count_num;
        // }

        // public function PaginationTotalPage($pre_page){
        //     $count_num = $this -> PaginationTotalDataCount();
        //     $pre_page = $pre_page; //每頁顯示
        //     $pages_count = ceil($count_num/$pre_page); 
        //     return $pages_count; //總頁數
        // }

        // public function PaginationCurrentPage(){
        //     if (!isset($_GET["Page"])){ //假如$_GET["page"]未設置
        //         $page=1; //起始頁數
        //     }else{
        //         $page = intval($_GET["Page"]); //確認頁數只能夠是數值資料
        //     }
        //     return $page;
        // }
    }

?>