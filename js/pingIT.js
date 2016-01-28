$(document).ready(function (){
    $("#rmCatButton").on("click", function (){
        var timer = setTimeout(function(){
            $("#cnlCatButton").toggleClass("hidden");
            $("#cnlCatButton").off();
        },2000);
        
        $("#cnlCatButton").toggleClass("hidden");
        $("#cnlCatButton").one("click",function(){
            $("#cnlCatButton").toggleClass("hidden");
            clearTimeout(timer);
        });
    })
});