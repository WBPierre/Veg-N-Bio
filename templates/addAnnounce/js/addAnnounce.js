<script>
$(document).ready(function(){


    $("#submitAd").click(function(){

        var title = $('#inputTitle').val();
        var description = $('#inputDescription').val();
        var filePath = $('#inputFilePath').val();

        var params = {
            title: title,
            description: description,
            filePath: filePath
        };

        var ser_data = jQuery.param(params);

        $.ajax({
            type: 'POST',
            url: "templates/addAnnounce/ajax.php",
            data: ser_data,
            success: function(data){
                window.location.replace('/?url=marketPlace');
            }
        })
    });

});
</script>