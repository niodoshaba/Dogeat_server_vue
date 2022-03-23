
    // $(".delete_btn").click(function () { 
    //     let delete_id=$(this).attr("data-delete");
    //     $.ajax({
    //         type: "GET",
    //         url: "/dogeat_server/index.php?action=DeleteMemberMessage&controller=BackStageMemberControllers",
    //         data: {"delete_id":delete_id},
    //         dataType: "text",
    //         success: function (response) {
    //             if(response){
    //                 alert("刪除成功");
    //                 location.reload();
    //             }else{
    //                 alert("刪除失敗");
    //                 location.reload();
    //             }
    //         }
    //     });
    // });
    // $(".edit_btn").click(function () {
    //     $("#reply_box").css("display","flex");
    //     let reply_id = $(this).attr("data-edit");
    //     let mes_content = $(this).parents().prev().prev().prev().text();
    //     $("#mes_content").val(mes_content);
    //     let date = new Date();
    //     let now_date=date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
    //     $("#reply").click(function () { 
    //         $.ajax({
    //             type: "GET",
    //             url: "/dogeat_server/index.php?action=ReplyMemberMessage&controller=BackStageMemberControllers",
    //             data: {"reply_id":reply_id,"administrator_Reply":$("#administrator_Reply").val(),"now_date":now_date},
    //             dataType: "text",
    //             success: function (response) {
    //                 if(response){
    //                     alert("回復成功");
    //                     location.reload();
    //                 }else{
    //                     alert("回復失敗");
    //                     location.reload();
    //                 }
    //             }
    //         });
    //     });
    // });
    // $("#close_reply_box").click(function (e) { 
    //     location.reload();
    // });
