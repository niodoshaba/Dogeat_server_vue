<?php 

    use Bang\Lib\Bundle;
    use Models\Pagination;
    use Bang\Lib\ResponseBag;

    $pagination_data = ResponseBag::Get('pagination_data');
?>
<?php
Bundle::Css('test_css', array(
    '/Content/css/croppie.css'
));
?>
<style>
    .inventory_shortage{
        background: #e823236e;
    }
</style>
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

                        </div>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                <thead>
                                    <tr>
                                        <th class="th-length" style="text-align:center;width:50px;">編號</th>
                                        <th class="th-length" style="cursor: pointer;text-align:center;width:100px" id="cata_no">類別</th>
                                        <th class="th-length" style="text-align:center;width:150px">品名</th>
                                        <th class="th-length" style="cursor: pointer;text-align:center;width:50px" id="pro_price">金額</th>
                                        <th class="th-length" style="text-align:center;width:100px">容量</th>
                                        <th class="th-length" style="cursor: pointer;text-align:center;width:100px" id="product_reserve">庫存</th>
                                        <th class="th-length" style="text-align:center;width:150px">成分</th>
                                        <th class="th-length" style="text-align:center;width:100px">保存期限</th>
                                        <th class="th-length" style="text-align:center;width:120px">照片</th>
                                        <th class="th-length" style="text-align:center;width:250px">產品簡介</th>
                                        <th class="th-length" style="cursor: pointer;text-align:center;width:50px" id="pro_status">狀態</th>
                                        <th class="th-length" style="text-align:center;width:100px">編輯</th>
                                    </tr>
                                </thead>
                                <tbody id="product-table">
                                    <tr v-if="index < (pre_page*current_page) && index >= (pre_page*(current_page-1))" :class="item.product_reserve == 0 ? 'inventory_shortage':''" v-for="(item,index) in product_data">
                                        <td style="vertical-align:initial;text-align:center">{{item.pro_no}}</td>
                                        <td style="vertical-align:initial;text-align:center">{{item.cata_name}}</td>
                                        <td style="vertical-align:initial;text-align:center">{{item.pro_name}}</td>
                                        <td style="vertical-align:initial;text-align:center">{{item.pro_price}}</td>
                                        <td style="vertical-align:initial;text-align:center">{{JSON.parse(item.pro_all_info).product_content}}g/包</td>
                                        <td style="vertical-align:initial;text-align:center">{{item.product_reserve}}/包</td>
                                        <td style="vertical-align:initial;text-align:center">{{JSON.parse(item.pro_all_info).product_element}}</td>
                                        <td style="vertical-align:initial;text-align:center">{{JSON.parse(item.pro_all_info).pro_deadtime}}</td>
                                        <td style="vertical-align:initial;text-align:center;">
                                            <img style="width:80px;margin: 0 5px;" :src="JSON.parse(item.pro_img).img_01" alt="">
                                            <img style="width:80px;margin: 0 5px;" :src="JSON.parse(item.pro_img).img_02" alt="">
                                            <img style="width:80px;margin: 0 5px;" :src="JSON.parse(item.pro_img).img_03" alt="">
                                            <img style="width:80px;margin: 0 5px;" :src="JSON.parse(item.pro_img).img_04" alt="">
                                        </td>
                                        <td style="vertical-align:initial;text-align:center;max-width:250px;overflow:hidden;text-overflow: ellipsis;">{{JSON.parse(item.pro_all_info).pro_info}}</td>
                                        <td style="vertical-align:initial;text-align:center">
                                            <p style="margin: 0;">{{JSON.parse(item.pro_status).status=="1" ?"上架":"撤架"}}時間：{{JSON.parse(item.pro_status).date}}</p>
                                        </td>
                                        <td style="vertical-align:initial;text-align:center">
                                            <button @click="OpenEditBox" type="button" class="btn waves-effect waves-light btn-info edit_btn" :data-no="item.pro_no">編輯</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button @click="OpenAddBox" style="display:block;border-radius:50px;margin:0 auto;font-size:26px;color:white;font-weight:1000;line-height:30px"  class="btn waves-effect waves-light btn-warning">+</button>
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
    <form action="" method="POST" enctype="multipart/form-data" id="form">
        <div id="update_box" style="width:100%;height:100vh;background-color:rgba(0,0,0,.3);display:none;justify-content:center;align-items: start;position:absolute;top:80px;">
            <div id="update_product" style="width: 390px;background: #fff;display: flex;flex-direction: column;justify-content: center;padding: 10px 0;margin: 10px;">
                <input style="display:none" name="product_num" id="product_num"></input>
                <div style="margin:0 10px">
                    <span>商品名稱：</span><input style="width: 270px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" placeholder="品名" name="product_name"  id="product_name"></input>                      
                </div>
                <div style="margin:0 10px">
                    <span>商品成分：</span><input style="width: 270px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" placeholder="成分" name="product_element"  id="product_element"></input>                      
                </div>
                <div style="margin:0 auto">
                    <span>保存期限：</span>
                    <select style="width: 120px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:11px;" name="product_refrigeration" id="product_refrigeration">
                        <option value="冷藏1周">冷藏1周</option>
                        <option value="冷藏2周">冷藏2周</option>
                        <option value="冷藏3周">冷藏3周</option>
                        <option value="冷藏4周">冷藏4周</option>
                        <option value="冷藏5周">冷藏5周</option>
                    </select>
                    <select style="width: 120px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:11px" name="product_freezing" id="product_freezing">
                        <option value="冷凍1周">冷凍1周</option>
                        <option value="冷凍2周">冷凍2周</option>
                        <option value="冷凍3周">冷凍3周</option>
                        <option value="冷凍4周">冷凍4周</option>
                        <option value="冷凍5周">冷凍5周</option>
                    </select>
                </div>
                <div style="margin: 0 9px;">
                    <span>商品種類：</span>
                    <select style="width: 120px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px;" name="product_catalog" id="product_catalog">
                        <option value="1">蔬菜零食</option>
                        <option value="2">蔬菜粉粉</option>
                    </select>
                    <br>
                    <span>商品狀態：</span>
                    <select style="width: 120px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" name="product_status" id="product_status">
                        <option value="1">上架</option>
                        <option value="0">撤架</option>
                    </select>
                </div>
                <div style="margin:0 10px;position: relative;">
                    <span>商品庫存：</span><input style="width: 270px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" name="product_reserve" placeholder="庫存" id="pro_reserve"></input>
                    <span style="position: absolute;right: 15px;transform: translateY(-50%);top: 50%;border-left: 2px solid #e8eef3;height: 30px;line-height: 30px;text-align: center;width: 45px;">/包</span>                          
                </div>
                <div style="margin: 0 9px;"> 
                    <span>更新時間：</span>
                    <input id="pro_date" type="date" name="product_date" style="width: 145px;border: 2px solid rgb(232, 238, 243);vertical-align: initial;text-align: center;margin: 10px 0 10px 10px;height: 26px;">
                    <select style="width: 55px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;" name="date_hour" id="date_hour">
                        <option value="-1">時</option>
                        <option v-for="n in 24" :value="n < 10 ? '0'+n:n">{{n < 10 ? '0'+n:n}}</option>
                    </select>
                    <select style="width: 55px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;" name="date_min" id="date_min">
                        <option value="-1">分</option>
                        <option v-for="n in 60" :value="n < 10 ? '0'+n:n">{{n < 10 ? '0'+n:n}}</option>
                    </select>
                </div>
                <div style="margin:0 10px;position: relative;">
                    <span>商品容量：</span><input style="width: 270px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" name="product_content" placeholder="容量" id="product_content"></input>
                    <span style="position: absolute;right: 15px;transform: translateY(-50%);top: 50%;border-left: 2px solid #e8eef3;height: 30px;line-height: 30px;text-align: center;">g/包</span>                          
                </div>
                <div style="margin:0 10px;position: relative;">
                    <span>商品金額：</span><input style="width: 270px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" name="product_price" placeholder="金額" id="product_price"></input>                            
                    <span style="width:35px;position: absolute;left: 90px;transform: translateY(-50%);top: 50%;border-right: 2px solid #e8eef3;height: 30px;line-height: 30px;text-align: center;">NT</span> 
                </div>
                <div>
                    <input accept=".jpg,.png" type="file" style="overflow: hidden;width: 250px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" name="product_file[]" class="product_url"></input>
                    <div style="display: inline-block;">
                        <img src="" style="width:50px;height:50px;cursor: pointer;"  class="product_picture" alt="尚未上傳" title="裁剪圖片" id="tmp_base64_01">
                        <input type="text" style="visibility: hidden;width: 0;height: 0;margin: 0;padding: 0;" name="tmp_base64_01">
                    </div>
                </div>
                <div>
                    <input accept=".jpg,.png" type="file" style="overflow: hidden;width: 250px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" name="product_file[]" class="product_url"></input>
                    <div style="display: inline-block;">
                        <img src="" style="width:50px;height:50px;cursor: pointer;"  class="product_picture" alt="尚未上傳" title="裁剪圖片" id="tmp_base64_02">
                        <input type="text" style="visibility: hidden;width: 0;height: 0;margin: 0;padding: 0;" name="tmp_base64_02">
                    </div>
                </div>
                <div>
                    <input accept=".jpg,.png" type="file" style="overflow: hidden;width: 250px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" name="product_file[]" class="product_url"></input>
                    <div style="display: inline-block;">
                        <img src="" style="width:50px;height:50px;cursor: pointer;"  class="product_picture" alt="尚未上傳" title="裁剪圖片" id="tmp_base64_03">
                        <input type="text" style="visibility: hidden;width: 0;height: 0;margin: 0;padding: 0;" name="tmp_base64_03">
                    </div>
                </div>
                <div>
                    <input accept=".jpg,.png" type="file" style="overflow: hidden;width: 250px;border:2px solid #e8eef3;vertical-align:initial;text-align:center;margin:10px" name="product_file[]" class="product_url"></input>
                    <div style="display: inline-block;">
                        <img src="" style="width:50px;height:50px;cursor: pointer;"  class="product_picture" alt="尚未上傳" title="裁剪圖片" id="tmp_base64_04">
                        <input type="text" style="visibility: hidden;width: 0;height: 0;margin: 0;padding: 0;" name="tmp_base64_04">
                    </div>
                </div>
                
                <div style="margin:0 10px">
                    <p style="margin: 5px;">商品簡介：</p><textarea style="resize:none;width: 370px;height: 100px;border:2px solid #e8eef3;" name="product_info" placeholder="商品簡介" id="product_info"></textarea>                            
                </div>                         
                <div style="margin:0 auto">
                    <button @click="Determine('upload')" type="button" class="btn waves-effect waves-light btn-info" id="upload">上傳</button>
                    <button @click="Determine('edit_sql')" type="button" class="btn waves-effect waves-light btn-info" id="edit_sql_but">上傳</button>
                    <button @click="EditCancel" type="button" class="btn waves-effect waves-light btn-danger" id="close_update_box">取消</button>
                </div>
            </div>
            <div id="edit_picture" style="padding: 20px 0;margin: 5px;width: 330px;height: 460px;background: #fff;display: none;flex-direction: column;align-items: center;">
                <input type="text" style="visibility: hidden;width: 0;height: 0;margin: 0;padding: 0;" id="temp_img">
                <p style="margin: 0;">裁剪圖片</p>
                <div style="margin: 5px;">
                    <button type="button" class="btn waves-effect waves-light btn-info vanilla-result cutpicture" style="background:#9e5fe8">裁剪</button>                       
                    <input type="number" placeholder="裁剪尺寸" id="cutSize" min="0" max="300" step="10" style="width: 240px;">
                </div>
                <div style="width: 300px;height: 300px;">
                    <div id="demo" style="position: relative;"></div>
                </div>
                <input type="text" style="visibility: hidden;width: 0;height: 0;margin: 0;padding: 0;" name="data_num" value=<?php echo $pagination_data["data_count_num"]?>>
                <input type="text" style="visibility: hidden;width: 0;height: 0;margin: 0;padding: 0;" name="old_img_01" id="old_img_01">
                <input type="text" style="visibility: hidden;width: 0;height: 0;margin: 0;padding: 0;" name="old_img_02" id="old_img_02">
                <input type="text" style="visibility: hidden;width: 0;height: 0;margin: 0;padding: 0;" name="old_img_03" id="old_img_03">
                <input type="text" style="visibility: hidden;width: 0;height: 0;margin: 0;padding: 0;" name="old_img_04" id="old_img_04">
            </div>
        </div>                      
    </form>
</div>
<?php 
    Bundle::Js('test_js', array(
        '/Content/js/croppie.js',
    ));
?>
<script>
    let vanilla;
    let vue = new Vue({
        el:'#vue',
        data : function(){
            return {
                product_data:<?php print_r(json_encode($pagination_data["product_data"])); ?>,
                max_page:<?php print_r($pagination_data["pages_count"]); ?>,
                pre_page:<?php print_r($pagination_data["pre_page"]); ?>,
                current_page:1,
                reply_id:"",
                edit_pro_no:""
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
                let click_btn = event.target.getAttribute("data-no");
                v_this.edit_pro_no = click_btn;
                $("#update_box").css("display","flex");
                $("#upload").css("display", "none");
                $(".edit_btn").attr("disabled", true); //disabled其他編輯鈕
                $(".delete_btn").attr("disabled", true); //disabled其他刪除鈕
                v_this.OpenEditBoxAjax(click_btn,function(response){
                    $("#product_num").attr("value",response["pro_no"]);
                    $("#product_name").attr("value",response["pro_name"]);
                    $("#product_price").attr("value",response["pro_price"]);
                    let pro_all_info = JSON.parse(response["pro_all_info"]);
                    $("#product_info").val(pro_all_info["pro_info"]);
                    $("#product_element").attr("value",pro_all_info["product_element"]);
                    $("#product_content").attr("value",pro_all_info["product_content"]);
                    $("#pro_reserve").attr("value",pro_all_info["pro_reserve"]);
                    let pro_deadtime = pro_all_info["pro_deadtime"].split("、");
                    $("#product_refrigeration").find("option[value = '"+pro_deadtime[0]+"']").attr("selected","selected");
                    $("#product_freezing").find("option[value = '"+pro_deadtime[1]+"']").attr("selected","selected");
                    let status = JSON.parse(response["pro_status"]);
                    $("#product_status").find("option[value = '"+status["status"]+"']").attr("selected","selected");
                    let date = status["date"].split(" ");
                    $("#pro_date").val(date[0]);
                    $("#date_hour").find("option[value = '"+(date[1].split(":"))[0]+"']").attr("selected","selected");
                    $("#date_min").find("option[value = '"+(date[1].split(":"))[1]+"']").attr("selected","selected");
                    $("#product_catalog").find("option[value = '"+response["cata_no"]+"']").attr("selected","selected");
                    $("#product_catalog,#product_status,#product_refrigeration,#product_freezing").trigger("change");
                    let pro_all_img = JSON.parse(response["pro_img"]);
                    $("#old_img_01").val(pro_all_img["img_01"]);
                    $("#old_img_02").val(pro_all_img["img_02"]);
                    $("#old_img_03").val(pro_all_img["img_03"]);
                    $("#old_img_04").val(pro_all_img["img_04"]);
                    ready();
                })
            },
            OpenAddBox:function(){
                $("#update_box").css("display","flex");
                $("#pro_num").css("display","none");
                $("#edit_sql_but").css("display", "none");
                ready();
            },
            EditCancel:function(){
                location.reload();
            },
            Determine:function(statue){
                console.log("ert");
                let picture_size_conform;
                let err_picture;
                let date_hour = $("select[name='date_hour']").val()
                let date_min = $("select[name='date_min']").val()
                if(date_hour < 0 || date_min< 0){
                    alert("請輸入完整訊息");
                    return false;
                }
                let img = [document.getElementById('tmp_base64_01'),document.getElementById('tmp_base64_02'),document.getElementById('tmp_base64_03'),document.getElementById('tmp_base64_04')];
                for(let i=0;i<4;i++){
                    if(img[i].naturalWidth == img[i].naturalHeight){
                        picture_size_conform = true;
                    }else{
                        picture_size_conform = false;
                        err_picture = i+1;
                        break;
                    }
                }
                if(picture_size_conform){
                    if(statue == "edit_sql"){
                        $("#form").attr("action","/dogeat_server/index.php?action=updateProduct&controller=BackStageProductControllers");
                    }else{
                        $("#form").attr("action","/dogeat_server/index.php?action=addProduct&controller=BackStageProductControllers");
                    }
                    $("#form").submit();
                }else{
                    alert("第"+err_picture+"張圖片尺寸不合");
                }
            },
            //-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----
            //-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----Ajax-----
            OpenEditBoxAjax: function(pro_id, cb) {
                this.callAjax("POST","<?php echo Bang\Lib\Url::Action('showProductInformation','BackStageProductControllers')?>",{pro_id:pro_id},"json",cb);
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
    $(".product_url").change(async function () {
        await verificationPicFile(this);
    });
    //圖片尺寸驗證
    function verificationPicFile(file) {
        return new Promise(resolve => {
            var filePath = file.value;
            if(filePath){
                //讀取圖片數據
                var filePic = file.files[0];
                var reader = new FileReader();
                reader.onload = function (e) {
                    var data = e.target.result;
                    //加載圖片獲取圖片真實寬度和高度
                    var image = new Image();
                    image.onload=async function(){
                        var width = image.width;
                        var height = image.height;
                        if (width ==  height){
                            alert("文件尺寸符合！");
                            await readURL(file);
                            resolve();
                        }else{
                            alert("文件尺寸長寬需相等！");
                            await readURL(file);
                            resolve();
                        }
                    };
                    image.src= data;
                };
                reader.readAsDataURL(filePic); 
            }else{
                return false;
            }
        });
    }
    //預覽圖片
    async function readURL(input){
    return new Promise(resolve => {
        if(input.files && input.files[0]){
            let reader = new FileReader();
            reader.onload = function (e) {
                $(input).next().children("img").attr('src', e.target.result);
                $(input).next().children("input").attr('value', e.target.result);
                if(vanilla){
                    vanilla.destroy();
                }
                renderingpicture($(input).next().children("img"));
                resolve();
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
    }
    //點擊圖片放大預覽
    function renderingpicture(picture){
        let el = document.getElementById('demo');
        vanilla = new Croppie(el, {
            viewport: { width: "", height: ""},
            boundary: { width: 300, height: 300 },
            showZoomer: true,
        });
        vanilla.bind({
            url: $(picture).attr("src"),
            orientation: 4
        });
        $(".cr-overlay").attr("style",'width: 266.342px; height: 199.93px; top: 38.0659px; left: 6.83209px;');
        $("#temp_img").attr("value",$(picture).attr("id"));
    }
    function ready(){
        //放大預覽
        $(".product_picture").click(function () {
            if(vanilla){
                vanilla.destroy();
            }
            if($(this).attr("src") != ""){
                $("#edit_picture").css("display","flex");
                renderingpicture(this);
            }else{
                alert("請先上傳");
            }
        });
        $("#cutSize").bind("input propertychange",function () {
            let cutSize = $("#cutSize").val();
            $(".cr-vp-square").css("width",cutSize);
            $(".cr-vp-square").css("height",cutSize);
        });
    }
    //點擊後裁切圖片
    $('.cutpicture').click(function () {
        vanilla.result({
            type: 'base64'
        }).then(function (base64) {
            if(vanilla.options.viewport.width == undefined){
                alert("請輸入裁剪尺寸");
            }else{
                if(parseInt($("#cutSize").val()) > parseInt($(".cr-overlay").css("width").split("px")[0]) ){
                    alert("裁剪框不得小於圖片尺寸");
                }else{
                    $('#'+$("#temp_img").attr("value")).next().attr("value",base64);
                    $('#'+$("#temp_img").attr("value")).attr("src",base64);
                    alert("裁剪成功");
                }
            }
        });
    });
</script>
<script>
    //排序
    let previous_id="<?php echo $_SESSION['sort_name'];?>";
    let sort_by="<?php echo $_SESSION['sort_by']?>";
    //重整頁面後當前用誰排序給予底色及上下的img
    $("#"+previous_id).css("background","#dbe8f3");
    if(sort_by == "ASC"){
    $("#"+previous_id).append('<img src="/dogeat_server//Content/img/images/up-arrow.png" style = "margin: 0 5px 2px;" alt="">');
    }else{
        $("#"+previous_id).append('<img src="/dogeat_server//Content/img/images/down-arrow.png" style = "margin: 0 5px 2px;" alt="">');
    }
    //切換排序
    $("#cata_no,#pro_price,#pro_status,#product_reserve").click(function () { 
        if($(this).attr("id") == $('#'+previous_id).attr("id")){
            //點擊同一個id改變排序方法
            if(sort_by == "ASC"){
                $(this).children().attr("src","/dogeat_server//Content/img/images/up-arrow.png");
                sort_by = "DESC";
            }else{
                $(this).children().attr("src","/dogeat_server//Content/img/images/down-arrow.png");
                sort_by = "ASC";
            }
        }else{
            //點擊不同的id改變排序對象
            $('#'+previous_id).css("background","#fff");
            $('#'+previous_id).children().remove();
            previous_id = $(this).attr("id");
            $(this).css("background","#dbe8f3");
            $(this).append('<img src="/dogeat_server//Content/img/images/down-arrow.png" style = "margin: 0 5px 2px;" alt="">');
            sort_by = "ASC";
        }
        $.ajax({
            type: "GET",
            url: "/dogeat_server/index.php?action=ProductList&controller=Home",
            data: {"sort_name":previous_id,"sort_by":sort_by},
            dataType: "text",
            success: function (response) {
                location.reload();
            }
        });
    });
</script>
