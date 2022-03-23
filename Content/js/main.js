
// 頁面標題
$(function(){
if(window.location.search.indexOf("MemberList") > 0){
    PageTitle("會員管理");
    $("#search").attr("placeholder","輸入手機")
}else if(window.location.search.indexOf("ProductList") > 0){
    PageTitle("商品管理");
    $("#search").attr("placeholder","輸入商品名")
}else if(window.location.search.indexOf("OrderList") > 0){
    PageTitle("訂單管理");
    $("#search").attr("placeholder","輸入手機")
}
})

function PageTitle($each_title){
    $("#page_title").text($each_title)
};

//分頁功能(上一頁&下一頁)
$(function(){
    if(window.location.href.indexOf("Page=") != -1 ){ //若有Page參數
    let url = ""
    url_current = window.location.href.split('=');
    url = url_current[0]+"="+url_current[1]+"="+url_current[2]+"="
    
    console.log(url)

    url_back = parseInt(url_current[url_current.length-1])-parseInt(1);
    url_next = parseInt(window.location.href.substring(window.location.href.lastIndexOf("=")+1))+parseInt(1);

        if(url_back == 0){
            $("#page_back").attr("disable",true);
        }else{
            $("#page_back").attr("href",url+ url_back)
        }
        if(url_next > pages_count){
            $("#page_next").attr("disable",true);
        }else{
            $("#page_next").attr("href",url+ url_next)
        }

    }else{ //若沒有Page參數
        let url = ""
        url_current = window.location.href.split('=');
        url = url_current[0]+"="+url_current[1]+"="+url_current[2]+"&Page="

        console.log(url)
        $("#page_back").attr("disable",true);
        $("#page_next").attr("href",url+ 2);
    }
})

//搜尋
$(function(){
    $("#search_btn").click(function(){
        $.ajax({
            type: "GET",
            url: "/dogeat_server/?controller=BackStageMemberControllers&action=Search",
            data: { key_in_text: $("#search").val(),
                    search_target_page: $("#search-page-target").val()
                    },
            dataType: "text",
            success: function (response) {
                if($("#search-page-target").val() == "MemberList"){
                    if(response == false || $("#search").val() == ""){
                        $("#user-table").children().remove()
                        $("#user-table").append(`
                        <tr>
                            <td colspan="${$(".th-length").length}" style="text-align:center">查無資料</td>
                        </tr>
                        `)
                    }
                    else{
                        $("#user-table").children().remove()
                        search_data = JSON.parse(response)
                        for(i=0;i<search_data.length;i++){
                            $("#user-table").append(`
                            <tr>
                                <td style="vertical-align:initial;text-align:center;">${search_data[i]["cus_no"]}</td>';
                                <td style="vertical-align:initial;text-align:center;">${search_data[i]["cus_name"]}</td>';
                                <td style="vertical-align:initial;text-align:center;">${search_data[i]["cus_address"]}</td>';
                                <td style="vertical-align:initial;text-align:center;">${search_data[i]["cus_phone"]}</td>';
                                <td style="vertical-align:initial;text-align:center;">${search_data[i]["cus_id"]}</td>';
                                <td style="vertical-align:initial;text-align:center;">${search_data[i]["cus_status"]}</td>';
                                <td>
                                    <button type="button" class="btn waves-effect waves-light btn-info edit_btn" data-edit="${search_data[i]["cus_no"]}">編輯</button>
                                    <button type="button" class="btn waves-effect waves-light btn-danger delete_btn" data-delete="${search_data[i]["cus_no"]}">刪除</button>
                                </td>
                            </tr>
                            `)
                        }
                    }
                MemberListFunctionReady()
                }

                if($("#search-page-target").val() == "ProductList"){
                    console.log(response)
                    if(response == false || $("#search").val() == ""){
                        $("#product-table").children().remove()
                        $("#product-table").append(`
                        <tr>
                            <td colspan="${$(".th-length").length}" style="text-align:center">查無資料</td>
                        </tr>
                        `)
                    } else{
                        $("#product-table").children().remove()
                        search_data = JSON.parse(response)
                        for(i=0;i<search_data.length;i++){
                            $("#product-table").append(`
                            <tr>
                                <td style="vertical-align:initial;text-align:center">${search_data[i]["pro_no"]}</td>
                                <td style="vertical-align:initial;text-align:center"">${search_data[i]["cata_no"]}</td>
                                <td style="vertical-align:initial;text-align:center"">${search_data[i]["pro_name"]}</td>
                                <td style="vertical-align:initial;text-align:center"">${search_data[i]["pro_price"]}</td>
                                <td style="vertical-align:initial;text-align:center"">${JSON.parse(search_data[0]["pro_all_info"])["product_content"]}g/包</td>
                                <td style="vertical-align:initial;text-align:center"">${JSON.parse(search_data[0]["pro_all_info"])["product_element"]}</td>
                                <td style="vertical-align:initial;text-align:center"">${JSON.parse(search_data[0]["pro_all_info"])["pro_deadtime"]}</td>
                                <td style="vertical-align:initial;text-align:center;">
                                <img style="width:80px;margin: 0 5px;" src="${JSON.parse(search_data[0]["pro_img"])["img_01"]}" alt="">
                                <img style="width:80px;margin: 0 5px;" src="${JSON.parse(search_data[0]["pro_img"])["img_02"]}" alt="">
                                <img style="width:80px;margin: 0 5px;" src="${JSON.parse(search_data[0]["pro_img"])["img_03"]}" alt="">
                                <img style="width:80px;margin: 0 5px;" src="${JSON.parse(search_data[0]["pro_img"])["img_04"]}" alt="">
                                </td">
                                <td style="vertical-align:initial;text-align:center;max-width:250px;overflow:hidden;text-overflow: ellipsis;"">${JSON.parse(search_data[0]["pro_all_info"])["pro_info"]}</td>
                                <td style="vertical-align:initial;text-align:center"">${search_data[i]["pro_status"]}</td>
                                <td style="vertical-align:initial;text-align:center">
                                <button type="button" class="btn waves-effect waves-light btn-info edit_btn" id="${search_data[i]["pro_no"]}">編輯</button>
                                </td>
                            </tr>
                            `)
                        }
                    }
                ProductListFunctionReady()
                }

                if($("#search-page-target").val() == "OrderList"){
                    if(response == false || $("#search").val() == ""){
                        $("#order-table").children().remove()
                        $("#order-table").append(`
                        <tr>
                            <td colspan="${$(".th-length").length}" style="text-align:center">查無資料</td>
                        </tr>
                        `)
                    }
                    else{
                        $("#order-table").children().remove()       
                        search_data = JSON.parse(response)
                        let each_search_data = new Array;
                        console.log(search_data[0]);
                        for(i=0;i<search_data[0].length;i++){
                            let combine_search_data = new Array;
                            for(j=0;j<search_data[1].length;j++){
                                if(search_data[0][i]["ord_no"] == search_data[1][j]["ord_no"]){
                                    combine_search_data.push(search_data[1][j]["pro_name"])
                                }
                            }   
                            each_search_data.push([combine_search_data])
                            $("#order-table").append(`
                            <tr>
                            <td style="vertical-align:initial;text-align:center">${search_data[0][i]["ord_no"]}</td>
                            <td style="vertical-align:initial;text-align:center">${search_data[0][i]["ord_date"]}</td>
                            <td id="order_table_each_product" style="vertical-align:initial;text-align:center;overflow-x:auto;max-width:400px">`+
                            each_search_data[i]
                            +`</td>
                            <td style="vertical-align:initial;text-align:center">${search_data[0][i]["cus_phone"]}</td>
                            <td style="vertical-align:initial;text-align:center"">${search_data[0][i]["ord_price"]}</td>
                            <td style="vertical-align:initial;text-align:center"">${search_data[0][i]["ord_payment_status"]}</td>
                            <td style="vertical-align:initial;text-align:center"">${search_data[0][i]["ord_status"]}</td>
                            <td style="vertical-align:initial;text-align:center">
                            <button type="button" class="btn waves-effect waves-light btn-info edit_btn" id="${search_data[0][i]["ord_no"]}">編輯</button>
                            </td>
                            </tr>
                            `)
                        }
                    }
                    OrderListFunctionReady()
                }
            },error:function(res){
                console.log(res);
            }
        })
    })
})

//顯示是否有以付款但未出貨之訂單
$(function(){
    $.ajax({
        type: "GET",
        url: "/dogeat_server/?controller=BackStageMemberControllers&action=ReturnPayButNoyShipmentOrder",
        dataType: "json",
        success: function (response) {
            console.log(response);
            if(response != false){
                $("#li_bell").append('<svg id="bell" style="cursor: pointer;" height="30px" viewBox="-21 0 512 512" width="30px" xmlns="http://www.w3.org/2000/svg"><path d="m448 232.148438c-11.777344 0-21.332031-9.554688-21.332031-21.332032 0-59.839844-23.296875-116.074218-65.601563-158.402344-8.339844-8.339843-8.339844-21.820312 0-30.164062 8.339844-8.339844 21.824219-8.339844 30.164063 0 50.371093 50.367188 78.101562 117.335938 78.101562 188.566406 0 11.777344-9.554687 21.332032-21.332031 21.332032zm0 0"></path><path d="m21.332031 232.148438c-11.773437 0-21.332031-9.554688-21.332031-21.332032 0-71.230468 27.734375-138.199218 78.101562-188.566406 8.339844-8.339844 21.824219-8.339844 30.164063 0 8.34375 8.34375 8.34375 21.824219 0 30.164062-42.304687 42.304688-65.597656 98.5625-65.597656 158.402344 0 11.777344-9.558594 21.332032-21.335938 21.332032zm0 0"></path><path d="m434.753906 360.8125c-32.257812-27.265625-50.753906-67.117188-50.753906-109.335938v-59.476562c0-75.070312-55.765625-137.214844-128-147.625v-23.042969c0-11.796875-9.558594-21.332031-21.332031-21.332031-11.777344 0-21.335938 9.535156-21.335938 21.332031v23.042969c-72.253906 10.410156-128 72.554688-128 147.625v59.476562c0 42.21875-18.496093 82.070313-50.941406 109.503907-8.300781 7.105469-13.058594 17.429687-13.058594 28.351562 0 20.589844 16.746094 37.335938 37.335938 37.335938h352c20.585937 0 37.332031-16.746094 37.332031-37.335938 0-10.921875-4.757812-21.246093-13.246094-28.519531zm0 0" style="fill: #e6e62c;"></path><path d="m234.667969 512c38.632812 0 70.953125-27.542969 78.378906-64h-156.757813c7.421876 36.457031 39.742188 64 78.378907 64zm0 0"></path></svg>');
                for(let i=0;i<response.length;i++){
                    if(i+1 == response.length){
                        $("#pay_but_not_shipment_order").append('<span>訂單編號：</span><span style="cursor: pointer;" class="ord_no">'+response[i]["ord_no"]+'</span>'+
                        '<div><span>訂單日期：</span><span>'+response[i]["ord_date"]+'</span></div>'+
                        '<div><span style="color:#dc3434">'+response[i]["ord_payment_status"]+'</span></div>');
                    }else{
                        $("#pay_but_not_shipment_order").append('<span >訂單編號：</span><span style="cursor: pointer;" class="ord_no">'+response[i]["ord_no"]+'</span>'+
                        '<div><span>訂單日期：</span><span>'+response[i]["ord_date"]+'</span></div>'+
                        '<div><span style="color:#dc3434">'+response[i]["ord_payment_status"]+'</span></div>'+
                        '<hr style="border-width: 5px;background: #fff;border-radius: 30px;margin: 5px 0;">');
                    }
                }
                $(".ord_no").click(function () {
                    if($("#search-page-target").val() == "OrderList"){
                        $("#search").val($(this).text());
                        $('#search_btn').trigger("click");
                        OrderListFunctionReady();
                    }else{
                        alert("請至訂單頁面搜尋");
                    }
                });
                $("#bell").click(function(){
                    if($('#pay_but_not_shipment_order').css("display") == "none"){
                        $('#pay_but_not_shipment_order').css("display","block")
                    }else{
                        $('#pay_but_not_shipment_order').css("display","none")
                    }
                });             
            }else{
                $("#bell").append('<svg style="cursor: pointer;" height="30px" viewBox="-21 0 512 512" width="30px" xmlns="http://www.w3.org/2000/svg"><path d="m448 232.148438c-11.777344 0-21.332031-9.554688-21.332031-21.332032 0-59.839844-23.296875-116.074218-65.601563-158.402344-8.339844-8.339843-8.339844-21.820312 0-30.164062 8.339844-8.339844 21.824219-8.339844 30.164063 0 50.371093 50.367188 78.101562 117.335938 78.101562 188.566406 0 11.777344-9.554687 21.332032-21.332031 21.332032zm0 0"></path><path d="m21.332031 232.148438c-11.773437 0-21.332031-9.554688-21.332031-21.332032 0-71.230468 27.734375-138.199218 78.101562-188.566406 8.339844-8.339844 21.824219-8.339844 30.164063 0 8.34375 8.34375 8.34375 21.824219 0 30.164062-42.304687 42.304688-65.597656 98.5625-65.597656 158.402344 0 11.777344-9.558594 21.332032-21.335938 21.332032zm0 0"></path><path d="m434.753906 360.8125c-32.257812-27.265625-50.753906-67.117188-50.753906-109.335938v-59.476562c0-75.070312-55.765625-137.214844-128-147.625v-23.042969c0-11.796875-9.558594-21.332031-21.332031-21.332031-11.777344 0-21.335938 9.535156-21.335938 21.332031v23.042969c-72.253906 10.410156-128 72.554688-128 147.625v59.476562c0 42.21875-18.496093 82.070313-50.941406 109.503907-8.300781 7.105469-13.058594 17.429687-13.058594 28.351562 0 20.589844 16.746094 37.335938 37.335938 37.335938h352c20.585937 0 37.332031-16.746094 37.332031-37.335938 0-10.921875-4.757812-21.246093-13.246094-28.519531zm0 0" style="fill: #000;"></path><path d="m234.667969 512c38.632812 0 70.953125-27.542969 78.378906-64h-156.757813c7.421876 36.457031 39.742188 64 78.378907 64zm0 0"></path></svg>');
            }
        }
    });
})