$(function(){
    let $postComment = $("#postComment");
    $postComment.on("click", function(){
        $.get("./postComment.php", {}, function(data){
            console.log(data);
            $("#result").text(data);
        });
    });

    let $reloadComment = $("#reloadComment");
    $reloadComment.on("click", function(){
        $.get("./reloadComment.php", {}, function(data){
            console.log(data);
            $("#result").text(data);
        })
    })
});