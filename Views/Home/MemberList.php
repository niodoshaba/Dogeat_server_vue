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
                                        <th class="th-length" style="vertical-align:initial;text-align:center;width:100px">編號</th>
                                        <th class="th-length" style="vertical-align:initial;text-align:center;width:100px">姓名</th>
                                        <th class="th-length" style="vertical-align:initial;text-align:center;width:250px">地址</th>
                                        <th class="th-length" style="vertical-align:initial;text-align:center;width:100px">手機號碼</th>
                                        <th class="th-length" style="vertical-align:initial;text-align:center;width:150px">帳號</th>
                                        <th class="th-length" style="vertical-align:initial;text-align:center;width:100px">狀態</th>
                                        <th class="th-length" style="vertical-align:initial;text-align:center;width:250px">編輯</th>
                                    </tr>
                                </thead>
                                <tbody id="user-table">
                                    <tr v-if="index < (pre_page*current_page) && index >= (pre_page*(current_page-1))" v-for="(item,index) in member_data">
                                        <td style="vertical-align:initial;text-align:center;">{{ item.cus_no }}</td>
                                        <td style="vertical-align:initial;text-align:center;">{{ item.cus_name }}</td>
                                        <td style="vertical-align:initial;text-align:center;">{{ item.cus_address }}</td>
                                        <td style="vertical-align:initial;text-align:center;">{{ item.cus_phone }}</td>
                                        <td style="vertical-align:initial;text-align:center;">{{ item.cus_id }}</td>
                                        <td style="vertical-align:initial;text-align:center;">{{ item.cus_status }}</td>
                                        <td style="vertical-align:initial;text-align:center;">
                                            <button @click="OpenEditBox" type="button" class="btn waves-effect waves-light btn-info" :data-edit="item.cus_no">編輯</button>
                                            <button @click="DeleteMember" type="button" class="btn waves-effect waves-light btn-danger" :data-delete="item.cus_no">刪除</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button @click="OpneAddBox" style="display:block;border-radius:50px;margin:0 auto;font-size:26px;color:white;font-weight:1000;line-height:30px"  class="btn waves-effect waves-light btn-warning" id="add_btn">+</button>
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

    <div style="width:100%;height:100vh;background-color:rgba(0,0,0,.3);display:none;justify-content:center;align-items:center;position:absolute;top:0;" id="add_lightbox_out">
        <div style="box-shadow:0px 3px 5px #959595;width:40%;margin:0 auto;border-radius:10px;background-color:#f9fbfd" id="add_lightbox">
            <div style="display:flex;flex-direction:column;width:250px;margin:0 auto">
                <h3 style="margin:20px auto 10px auto">會員資料</h3>
                <input style="border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" placeholder="姓名" id="add_member_name"></input>
                <input style="border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" placeholder="地址" id="add_member_address"></input>
                <input style="border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" placeholder="手機" id="add_member_phone"></input>
                <input style="border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" placeholder="帳號" id="add_member_account"></input>
                <input style="border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" placeholder="密碼" id="add_member_password"></input>
                <select name="" style="border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" id="add_member_status">
                    <option value="正常">正常</option>
                    <option value="黑名單">黑名單</option>
                </select>
                <button @click="AddFinish" class="btn waves-effect waves-light btn-warning" style="font-weight:bolder;width:30%;vertical-align:initial;text-align:center;;margin:10px 10px 20px 35%" id="add_btn_finish">新增</button>
                <button @click="EditFinish" class="btn waves-effect waves-light btn-warning" style="font-weight:bolder;width:30%;vertical-align:initial;text-align:center;;margin:10px 10px 20px 35%" id="edit_btn_finish">修改</button>
            </div>
        </div>
    </div>
</div>
<script>
    let vue = new Vue({
        el:'#vue',
        data : function(){
            return {
                member_data:<?php print_r(json_encode($pagination_data["member_data"])); ?>,
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
                    $("#pageback").css("color","#00bfff");
                    $("#pagenext").css("color","#00bfff");
                }
            },
            OpenEditBox:function(event){
                let v_this = this;
                let edit_no = event.target.getAttribute("data-edit");
                v_this.OpenEditBoxAjax(edit_no,function(edit_member_data){
                    user_id_data = JSON.parse(edit_member_data)       
                    $("#add_lightbox_out").fadeIn();
                    $("#add_lightbox_out").css("display","flex");
                    $("#add_btn_finish").css("display","none");
                    $("#edit_btn_finish").css("display","inline-block");

                    $("#add_member_name").val(user_id_data[0]["cus_name"]);
                    $("#add_member_address").val(user_id_data[0]["cus_address"]);

                    $("#add_member_account").val(user_id_data[0]["cus_id"]);
                    $("#add_member_account").attr("readonly","");
                    $("#add_member_account").attr("unselectable","on");

                    $("#add_member_phone").val(user_id_data[0]["cus_phone"]);
                    $("#add_member_phone").attr("readonly","");
                    $("#add_member_phone").attr("unselectable","on");
                })
            },
            OpneAddBox:function(){
                $("#add_lightbox_out").fadeIn()
                $("#add_lightbox_out").css("display","flex")
                $("#add_btn_finish").css("display","inline-block")
                $("#edit_btn_finish").css("display","none")
            },
            DeleteMember:function(event){
                let v_this = this;
                let delete_no = event.target.getAttribute("data-delete");
                v_this.DeleteMemberAjax(delete_no,function(result_mseeage){
                    alert(result_mseeage);
                    location.reload();
                })
            },
            AddFinish:function(event){
                let v_this = this;
                let member_name = $("#add_member_name").val();
                let member_address = $("#add_member_address").val();
                let member_phone = $("#add_member_phone").val();
                let member_account = $("#add_member_account").val();
                let member_password = $("#add_member_password").val();
                if(member_name && member_phone && member_account && member_password){
                    v_this.AddFinishAjax(member_name,member_address,member_phone,member_account,member_password,function(result_mseeage){
                        alert(result_mseeage);
                        location.reload();
                    })
                }else{
                    alert("請輸入完整");
                }
            },
            EditFinish:function(event){
                let v_this = this;
                let member_name = $("#add_member_name").val();
                let member_address = $("#add_member_address").val();
                let member_phone = $("#add_member_phone").val();
                let member_account = $("#add_member_account").val();
                let member_status = $("#add_member_status").val();
                v_this.EditFinishAjax(member_name,member_address,member_phone,member_account,member_status,function(result_mseeage){
                    alert(result_mseeage);
                    location.reload();
                })
            },
            //-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----
            //-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----
            OpenEditBoxAjax: function(edit_no, cb) {
                this.callAjax("POST","<?php echo Bang\Lib\Url::Action('showUserByNo','BackStageMemberControllers')?>",{cus_no:edit_no},"text",cb);
            },
            DeleteMemberAjax: function(delete_no, cb) {
                this.callAjax("POST","<?php echo Bang\Lib\Url::Action('deleteUser','BackStageMemberControllers')?>",{cus_no:delete_no},"text",cb);
            },
            EditFinishAjax: function(member_name,member_address,member_phone,member_account,member_status, cb) {
                this.callAjax("POST","<?php echo Bang\Lib\Url::Action('updataUser','BackStageMemberControllers')?>",{member_name:member_name,member_address:member_address,member_phone:member_phone,member_account:member_account,member_status:member_status},"text",cb);
            },
            AddFinishAjax: function(member_name,member_address,member_phone,member_account,member_password, cb) {
                this.callAjax("GET","<?php echo Bang\Lib\Url::Action('signup','BackStageMemberControllers')?>",{add_member_name:member_name,add_member_address:member_address,add_member_phone:member_phone,add_member_account:member_account,add_member_password:member_password},"text",cb);
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
