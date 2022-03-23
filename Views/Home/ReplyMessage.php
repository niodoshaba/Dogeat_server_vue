<?php 

use Bang\Lib\Bundle;
use Bang\Lib\ResponseBag;

$pagination_data = ResponseBag::Get('pagination_data');

?>
<div id="vue">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                <thead>
                                    <tr>
                                        <th class="th-length" style="vertical-align:initial;text-align:center;width:100px">使用者手機</th>
                                        <th class="th-length" style="vertical-align:initial;text-align:center;width:250px">使用者留言</th>
                                        <th class="th-length" style="vertical-align:initial;text-align:center;width:100px">留言時間</th>
                                        <th class="th-length" style="vertical-align:initial;text-align:center;width:150px">管理員回覆</th>
                                        <th class="th-length" style="vertical-align:initial;text-align:center;width:250px">編輯</th>
                                    </tr>
                                </thead>
                                <tbody id="user-table">
                                    <tr v-if="index < (pre_page*current_page) && index >= (pre_page*(current_page-1))" v-for="(item,index) in message_data">
                                        <td style="vertical-align:initial;text-align:center;">{{item.cus_phone}}</td>
                                        <td class="js_mes_content"style="vertical-align:initial;text-align:center;">{{item.mes_content}}</td>
                                        <td style="vertical-align:initial;text-align:center;">{{item.leave_time}}</td>
                                        <td style="vertical-align:initial;text-align:center;">{{item.administrator_Reply}}</td>
                                        <td style="vertical-align:initial;text-align:center;">
                                            <button @click="OpenReplyBox" v-if="item.reply_time == null " type="button" class="btn waves-effect waves-light btn-info edit_btn" :data-id="item.id">回復</button>
                                            <button @click="OpenReplyBox" v-else type="button" class="btn waves-effect waves-light btn-info edit_btn" :data-id="item.id">已回復</button>
                                            <button @click="DeleteMessage" type="button" class="btn waves-effect waves-light btn-danger delete_btn" style="margin: 0 5px;" :data-delet_id="item.id">刪除</button>
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
    <div id="reply_box" style="position: fixed;display: none;justify-content: center;align-items: center;height: 100vh;width: 88%;top: 0;background: #00000073;z-index: 50">
        <div style="width: 400px;height: 700px;background: white;text-align: center;padding: 20px;border-radius: 10px">
            <p style="text-align: start;font-size: 30px;margin: 0">使用者訊息：</p>
            <textarea id="mes_content" cols="30" rows="10" style="width: 100%;resize: none;outline: none;background:#d0d0d0;padding: 10px;" readonly></textarea>
            <p style="text-align: start;font-size: 30px;margin: 0">管理員回覆：</p>
            <textarea id="administrator_Reply" cols="30" rows="10" style="width: 100%;resize: none;outline: none;padding: 10px;"></textarea>
            <div style="margin: 15px auto;">
                <button @click="ReplyMessage" type="button" class="btn waves-effect waves-light btn-info" id="reply">回復</button>
                <button @click="CloseReplyBox" type="button" class="btn waves-effect waves-light btn-danger" id="close_reply_box">取消</button>
            </div>
        </div>
    </div>
</div>
<script>
    let vue = new Vue({
        el:'#vue',
        data : function(){
            return {
                message_data:<?php print_r(json_encode($pagination_data["message_data"])); ?>,
                max_page:<?php print_r($pagination_data["pages_count"]); ?>,
                pre_page:<?php print_r($pagination_data["pre_page"]); ?>,
                current_page:1,
                reply_id:""
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
                    console.log("sdf");
                    $("#pageback").css("color","#00bfff");
                    $("#pagenext").css("color","#00bfff");
                }
            },
            DeleteMessage:function(id){
                let v_this = this;
                let delet_id = event.target.getAttribute("data-delet_id")
                v_this.DeleteMessageAjax(delet_id,function(res){
                    alert("刪除成功");
                    location.reload();
                })
            },
            ReplyMessage:function(){
                let v_this = this;
                let reply_id = v_this.reply_id
                let date = new Date();
                let now_date=date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
                let administrator_Reply = $("#administrator_Reply").val()
                v_this.ReplyMessageAjax(reply_id,administrator_Reply,now_date,function(message){
                    alert("回復成功");
                    location.reload();
                })
            },
            OpenReplyBox:function(){
                $("#reply_box").css("display","flex");
                this.reply_id = event.target.getAttribute("data-id");
                let mes_content =  $(`[data-id='${this.reply_id}']`).parent().prev(".js_mes_content");
                console.log(mes_content);
                $("#mes_content").val(mes_content);
            },
            CloseReplyBox:function(){
                location.reload();
            },
            //-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----
            //-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----
            DeleteMessageAjax: function(id, cb) {
            this.callAjax("GET","<?php echo Bang\Lib\Url::Action('DeleteMemberMessage','BackStageMemberControllers')?>",{delete_id:id},"text",cb);
            },
            ReplyMessageAjax: function(reply_id,administrator_Reply,now_date,cb) {
            this.callAjax("GET","<?php echo Bang\Lib\Url::Action('ReplyMemberMessage','BackStageMemberControllers')?>",{reply_id:reply_id,administrator_Reply:administrator_Reply,now_date:now_date},"text",cb);
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
    });
</script>

