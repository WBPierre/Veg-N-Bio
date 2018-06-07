<script>
$(document).ready(function(){

    sendRequest();

    function sendRequest(){
        $.ajax({
            url: "templates/kitchenInterface/kitchenAjax.php",
            success:
                function(data){
                    $('#allItem').html(data);
                },
            complete: function() {
                setTimeout(sendRequest, 1000);
            }
        });
    };
});
</script>