$(function(){
    
    let $inputComment = $("#inputComment");
    let $postComment  = $("#postComment");
    let $ajaxButton   = $("#ajaxButton");

    $postComment.on("click", function(){
        // console.log("hoge"+JSON.parse($ajaxButton.attr("data-userid")));
        if($inputComment.val())
        $.get("./postComment.php", {
            user_id: JSON.parse($ajaxButton.attr("data-userid")),
            work_id: JSON.parse($ajaxButton.attr("data-workid")),
            content: $inputComment.val()
        }, 
        function(data){
            console.log(data);
            $("#result").text(data);
            $("#inputComment").val("");
        });
    });

    let $reloadComment = $("#reloadComment");
    $reloadComment.on("click", function(){
        $.get("./reloadComment.php", {
            work_id: JSON.parse($ajaxButton.attr("data-workid"))
        }, 
        function(data){
            console.log(data);
            $("#result").text(data);
        });
    });
});