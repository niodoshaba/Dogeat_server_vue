// $(document).ready(function () {
//     OrderListFunctionReady();
// });

    
//     function OrderListFunctionReady(){

//     //編輯按鈕
//     $(".edit_btn").click(function(){ 
//         $(".edit_btn").attr("disabled", true); //disabled其他編輯鈕
//         $(".delete_btn").attr("disabled", true); //disabled其他刪除鈕
        
//         let each_tr = $(this).parent().parent()
//         each_tr.find("td:eq(6)").text("")
//         each_tr.find("td:eq(6)").append(
//             `<select name="ord_status" style="border:2px solid #e8eef3;vertical-align:initial;text-align:center;width:100%" id="ord_status">
//                 <option value="出貨">出貨</option>
//                 <option value="未出貨">未出貨</option>
//                 <option value="取消">取消</option>
//             </select>`
//             );
//         each_tr.find("td:eq(7)").text("")
//         each_tr.find("td:eq(7)").append(
//             `<button type="button" class="btn waves-effect waves-light btn-info edit_btn_finish">完成</button>
//             <button type="button"class="btn waves-effect waves-light btn-danger edit_btn_cancel">取消</button>`
//             );

//         //完成編輯
//         $(".edit_btn_finish").click(function(){ 

//             $.ajax({
//                 type: "POST",
//                 url: "/dogeat_server/?controller=BackStageMemberControllers&action=UpdateOrder",
//                 data: {
//                     ord_no : each_tr.find("td:eq(0)").text(),
//                     ord_status : $("#ord_status").val(),
//                 },
//                 dataType: "text",
//                 success: function (response) {
//                     alert(response)
//                     location.reload()
//                 },
//             })
//         })

//         //取消編輯
//         $(".edit_btn_cancel").click(function(){ 
//             location.reload()
//         })
//     })
// }