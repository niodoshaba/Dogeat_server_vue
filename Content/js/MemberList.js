    // $(document).ready(function () {
    //     MemberListFunctionReady();
    // });


    // //新增資料的燈箱按下送出
    // $("#add_btn_finish").click(function(){
    //     if($("#add_member_name").val() && $("#add_member_phone").val() && $("#add_member_account").val() && $("#add_member_password").val() && $("#add_member_status").val()){
    //         $.ajax({
    //             type: "GET",
    //             url: "/dogeat_server/?controller=BackStageMemberControllers&action=signup",
    //             data: {add_member_name : $("#add_member_name").val(),
    //                 add_member_address : $("#add_member_address").val(),
    //                 add_member_phone : $("#add_member_phone").val(),
    //                 add_member_account : $("#add_member_account").val(),
    //                 add_member_password : $("#add_member_password").val()},
    //             dataType: "text",
    //             success: function (response) {
    //                 alert(response);
    //                 console.log("suss"+response);
    //                 location.reload()
    //             }
    //         });
    //     }else{
    //         alert("請輸入完整");
    //     }
    // })

    // function MemberListFunctionReady(){
    //     //刪除按鈕
    //     $(".delete_btn").click(function(){
    //         let delete_no = this.dataset.delete

    //         $.ajax({
    //             type: "POST",
    //             url: "/dogeat_server/?controller=BackStageMemberControllers&action=deleteUser",
    //             data: {cus_no:delete_no},
    //             dataType: "text",
    //             success: function (response) {
    //                 alert(response);
    //                 location.reload()
    //             }
    //         });
    //     });

    //     $(function(){
    //         $("#add_btn").click(function(){ //跳出新增資料的燈箱
    //             $("#add_lightbox_out").fadeIn()
    //             $("#add_lightbox_out").css("display","flex")
    //             $("#add_btn_finish").css("display","inline-block")
    //             $("#edit_btn_finish").css("display","none")
        
    //         })
    //     })
    //     $(function(){


    //         $(".edit_btn").click(function(){ //跳出編輯資料的燈箱
            
    //             let edit_no = this.dataset.edit
    //             console.log({cus_no:edit_no})

    //             $.ajax({
    //                 type: "POST",
    //                 url: "/dogeat_server/?controller=BackStageMemberControllers&action=showUserByNo",
    //                 data: {cus_no:edit_no},
    //                 dataType: "text",
    //                 success: function (response) {
    //                     user_id_data = JSON.parse(response)              
    //                     console.log(user_id_data);
    //                     $("#add_lightbox_out").fadeIn()
    //                     $("#add_lightbox_out").css("display","flex")
    //                     $("#add_btn_finish").css("display","none")
    //                     $("#edit_btn_finish").css("display","inline-block")

    //                     $("#add_member_account").val(user_id_data[0]["cus_id"])
    //                     $("#add_member_account").attr("readonly","")
    //                     $("#add_member_account").attr("unselectable","on")

    //                     $("#add_member_phone").val(user_id_data[0]["cus_phone"])
    //                     $("#add_member_phone").attr("readonly","")
    //                     $("#add_member_phone").attr("unselectable","on")
    //                 }
    //             });
    //         },
    //         )
    //     })
    //         //完成編輯
    //         $("#edit_btn_finish").click(function(){ 
    //             //然後Ajax
    //             $.ajax({
    //                 type: "POST",
    //                 url: "/dogeat_server/?controller=BackStageMemberControllers&action=updataUser",
    //                 data: {member_name:$("#add_member_name").val(),
    //                     member_address:$("#add_member_address").val(),
    //                     member_phone:$("#add_member_phone").val(),
    //                     member_account:$("#add_member_account").val(),
    //                     member_status:$("#add_member_status").val()},
    //                 dataType: "text",
    //                 success: function (response) {
    //                     alert(response);
    //                     location.reload()
    //                 }
    //             });
    //             //然後Ajax
    //             // location.reload()
    //         })

    //         //取消編輯
    //         $(".edit_btn_cancel").click(function(){ 
    //             location.reload()
    //         })
    //     }
    






