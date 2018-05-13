<script>
new WOW().init();


$(document).ready(function() {


    $('.carousel').carousel({
        interval: 20000
    });

    $('#choice1').click(function(){
        $('.carousel').carousel(0);
    });
    $('#choice2').click(function(){
        $('.carousel').carousel(1);
    });
    $('#choice3').click(function(){
        $('.carousel').carousel(2);
    });
    $('#choice4').click(function(){
        $('.carousel').carousel(3);
    });
    $('#choice5').click(function(){
        $('.carousel').carousel(4);
    });


});

</script>