$(document).ready(function (){
    $("#categoryRmForm").submit(function (event){
        event.preventDefault();
        
        var form = this;
        $("#rmCatButton").toggleClass("hidden");
        
        var timer = setTimeout(function(){
            $("#cnlCatButton").addClass("hidden");
            $("#cnlCatButton").off();
            $("#rmCatButton").removeClass("hidden");
            form.submit();
        },2000);
        
        $("#cnlCatButton").removeClass("hidden");
        $("#cnlCatButton").one("click",function(){
            clearTimeout(timer);
            $("#cnlCatButton").addClass("hidden");
            $("#rmCatButton").removeClass("hidden");
        });
    })
});