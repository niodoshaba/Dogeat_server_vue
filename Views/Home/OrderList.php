<?php 

    use Bang\Lib\Bundle;
    use Bang\Lib\ResponseBag;

    $pagination_data = ResponseBag::Get('pagination_data');
?>
<div id="vue">
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Column -->
                            <div class="col-md-6 col-lg-6 col-xlg-3">
                                <div class="card card-hover">
                                    <div class="p-2 bg-orange text-center">
                                        <h1 class="font-light text-white">{{ order_count_num }}</h1>
                                        <h6 class="text-white">訂單數</h6>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <div class="col-md-6 col-lg-6 col-xlg-3">
                                <div class="card card-hover">
                                    <div class="p-2 bg-cyan text-center">
                                        <h1 class="font-light text-white">{{ order_total_sum }}</h1>
                                        <h6 class="text-white">訂單金額</h6>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                <thead>
                                    <tr>
                                        <th class="th-length" style="text-align:center;width:50px">編號</th>
                                        <th class="th-length" style="text-align:center;width:100px">日期</th>
                                        <th class="th-length" style="text-align:center;width:100px;">品項</th>
                                        <th class="th-length" style="text-align:center;width:150px">會員</th>
                                        <th class="th-length" style="text-align:center;width:150px">金額</th>
                                        <th class="th-length" style="text-align:center;width:50px">付款狀態</th>
                                        <th class="th-length" style="text-align:center;width:50px">出貨狀態</th>
                                        <th class="th-length" style="text-align:center;width:250px">編輯</th>
                                    </tr>
                                </thead>
                                <tbody id="order-table">
                                    <tr v-if="index < (pre_page*current_page) && index >= (pre_page*(current_page-1))" v-for="(item,index) in order_data">
                                        <td style="vertical-align:initial;text-align:center">{{item.ord_no}}</td>
                                        <td style="vertical-align:initial;text-align:center">{{item.ord_date}}</td>
                                        <td style="vertical-align:initial;text-align:center;overflow-x:auto;max-width:400px">
                                            <span v-for="(item,index) in order_item_data[index]">{{index+1}}.{{item.pro_name}}</span>
                                        </td>
                                        <td style="vertical-align:initial;text-align:center">{{item.cus_phone}}</td>
                                        <td style="vertical-align:initial;text-align:center">{{item.ord_price}}</td>
                                        <td style="vertical-align:initial;text-align:center">{{item.ord_payment_status}}</td>
                                        <td style="vertical-align:initial;text-align:center">
                                            <div v-if="!(item.ord_no == edit_ord_no)">
                                                {{item.ord_status}}
                                            </div>
                                            <div v-else>
                                                <select name="ord_status" style="border:2px solid #e8eef3;vertical-align:initial;text-align:center;width:100%" id="ord_status">
                                                    <option value="出貨">出貨</option>
                                                    <option value="未出貨">未出貨</option>
                                                    <option value="取消">取消</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td style="vertical-align:initial;text-align:center">
                                            <div v-if="!(item.ord_no == edit_ord_no)">
                                                <button @click="OpenEditBox"type="button" class="btn waves-effect waves-light btn-info edit_btn" :data-edit="item.ord_no">編輯</button>
                                            </div>
                                            <div v-else>
                                                <button @click="EditFinish" type="button" class="btn waves-effect waves-light btn-info edit_btn_finish">完成</button>
                                                <button @click="EditCancel" type="button"class="btn waves-effect waves-light btn-danger edit_btn_cancel">取消</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <ul class="pagination float-right">
                                <li class="page-item">
                                    <a id="pageback" @click="PageBack" class="page-link" style="cursor:pointer"><</a>
                                </li>
                                <li class="page-item" v-for="index in max_page">
                                    <a @click="ClickPage" class="page-link" :data-page="index" style="cursor:pointer">{{index}}</a>
                                </li>
                                <li class="page-item">
                                    <a id="pagenext" @click="PageNext" class="page-link" style="cursor:pointer">></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
        let vue = new Vue({
        el:'#vue',
        data : function(){
            return {
                order_data:<?php print_r(json_encode($pagination_data["order_data"])); ?>,
                order_item_data:<?php print_r(json_encode($pagination_data["order_item_data"])); ?>,
                max_page:<?php print_r($pagination_data["pages_count"]); ?>,
                pre_page:<?php print_r($pagination_data["pre_page"]); ?>,
                current_page:1,
                reply_id:"",
                order_total_sum:<?php print_r($pagination_data["order_total_sum"]); ?>,
                order_count_num:<?php print_r($pagination_data["data_count_num"]); ?>,
                edit_ord_no:"",
            }
        },
        mounted: function () {
            $(`[data-page='${this.current_page}']`).css("color","#00bfff");
            if(this.current_page != this.max_page){
                $("#pagenext").css("color","#00bfff");
            }
        },
        methods : {
            PageBack:function(){
                if(this.current_page > 1){
                    $(`[data-page='${this.current_page}']`).css("color","inherit");
                    this.current_page--;
                    $(`[data-page='${this.current_page}']`).css("color","#00bfff");
                    this.ArrowChangeColor();
                }
            },
            ClickPage:function(event){
                let page = event.target.getAttribute("data-page")
                $(`[data-page='${this.current_page}']`).css("color","inherit");
                this.current_page = page;
                $(`[data-page='${this.current_page}']`).css("color","#00bfff");
                this.ArrowChangeColor();
            },
            PageNext:function(){
                if(this.current_page < this.max_page){
                    $(`[data-page='${this.current_page}']`).css("color","inherit");
                    this.current_page++;
                    $(`[data-page='${this.current_page}']`).css("color","#00bfff");
                    this.ArrowChangeColor();
                }
            },
            ArrowChangeColor:function(){
                if(this.current_page == 1){
                    $("#pageback").css("color","inherit");
                    $("#pagenext").css("color","#00bfff");
                }else if(this.current_page == this.max_page){
                    $("#pageback").css("color","#00bfff");
                    $("#pagenext").css("color","inherit");
                }else{
                    $("#pageback").css("color","#00bfff");
                    $("#pagenext").css("color","#00bfff");
                }
            },
            OpenEditBox:function(event){
                let v_this = this;
                let click_btn = event.target.getAttribute("data-edit");
                v_this.edit_ord_no = click_btn;
            },
            EditCancel:function(){
                location.reload();
            },
            EditFinish:function(){
                let v_this = this;
                let ord_status = $("#ord_status").val();
                let edit_ord_no = v_this.edit_ord_no;
                v_this.OpenEditBoxAjax(edit_ord_no,ord_status,function(resultmseeage){
                    alert(resultmseeage);
                    location.reload();
                })
            },
            //-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----
            //-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----
            OpenEditBoxAjax: function(edit_ord_no,ord_status, cb) {
                this.callAjax("POST","<?php echo Bang\Lib\Url::Action('UpdateOrder','BackStageMemberControllers')?>",{ord_no:edit_ord_no,ord_status:ord_status},"text",cb);
            },
            callAjax:function(method,url,data,dataType,cb){
                $.ajax({
                    type: method,
                    url: url,
                    data: data,
                    dataType: dataType,
                    success: function (response) {
                        cb(response);
                    },error:function(err){
                        alert("something Error!");
                    }
                });
            }
        }
    })
</script>
