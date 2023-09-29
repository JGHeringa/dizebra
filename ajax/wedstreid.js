$(document).ready(function(){
    $("#datumOpslaan").click(function(){
        var datum = $("#datum").val();
        var zeilerid = $("#zeiler-id").val();
        if (!datum || !zeilerid){
            alert("Niet alles is ingevuld")
        } else {
            console.log("adding wedstreid");
            $.post("php/newWedstreid.php",
            {
            datum: datum,
            zeilerid: zeilerid
            },
            function(data,status){
                console.log(status);
                $("#fromNote").text(data);
                $("#datum").val("");
                $("#zeiler-id").val("");
                reloadZeilers();
            });
        }
        
        setTimeout(function() {
            // Your code to execute after 8 seconds goes here
            $("#fromNote").text("");
        }, 5000);
    });
});