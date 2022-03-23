//上傳檔案一變動就更新預覽圖片
$(".product_url").change(async function () {
    await verificationPicFile(this);
});
//預覽圖片
async function readURL(input){ 
    return new Promise(resolve => {
        if(input.files && input.files[0]){
            let reader = new FileReader();
            reader.onload = function (e) {
                $(input).next().children("img").attr('src', e.target.result);
                $(input).next().children("input").attr('value', e.target.result);
                resolve();
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
}
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
//設成全域變數
let vanilla;
//點擊渲染圖片
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
function ProductListFunctionReady(){
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


      