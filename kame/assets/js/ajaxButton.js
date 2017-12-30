$(function(){
    
    let $inputComment = $("#inputComment");
    let $postComment  = $("#postComment");
    let $ajaxButton   = $("#ajaxButton");

    $postComment.on("click", function(){
        // console.log("hoge"+JSON.parse($ajaxButton.attr("data-userid")));
        $.get("./button_php/postComment.php", {
            user_id: JSON.parse($ajaxButton.attr("data-userid")),
            work_id: JSON.parse($ajaxButton.attr("data-workid")),
            content: $inputComment.val()
        }, 
        function(data) {
            console.log("hoge");
            console.log(data);
            let $result = $("#result");
            $("#result").text(data[0].content);
            $("#inputComment").val("");

        });
    });

    let $reloadComment = $("#reloadComment");
    $reloadComment.on("click", function(){
        $.get("./button_php/reloadComment.php", {
            work_id: JSON.parse($ajaxButton.attr("data-workid"))
        }, 
        function(data) {
            console.log(data);

            data = JSON.parse(data);

            // $("#result").text(data);

            // テーブルの作成
            let $table_result = $("<table>");
            $.each(data, function(key, value){
                let $tr_value = $("<tr>");

                let $td_id = $("<td>", {
                    text : value.id
                });

                let $td_content = $("<td>", {
                    text : value.content
                });
                $tr_value.append($td_content);

                let $td_user_id = $("<td>", {
                    text : value.user_id
                });
                $tr_value.append($td_user_id);

                let $td_work_id = $("<td>", {
                    text : value.work_id
                });
                $tr_value.append($td_work_id);

                let $td_created_at = $("<td>", {
                    text : value.created_at
                });
                $tr_value.append($td_created_at);

                $table_result.append($tr_value);
            });
            $("#result").append($table_result);
        });
    });
});