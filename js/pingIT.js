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
        },1000);
        
        $("#cnlCatButton").removeClass("hidden");
        $("#cnlCatButton").one("click",function(){
            clearTimeout(timer);
            
            /* If AJAX */
            //$("#cnlCatButton").addClass("hidden");
            //$("#rmCatButton").removeClass("hidden");
        });
    })
});