
$(".sun").click(function () {
    $("section").show("slow",
        function () {
            $("section2").hide("slow");
        });
});

$(".moon").click(function () {
    $("section2").show("slow",
        function () {
            $("section").hide("slow");
        });

});
