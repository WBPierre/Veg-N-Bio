<script>
$(document).ready(function(){
    $('#confirm').on('click',function(){
        var email = $('#getEmail').val();
        $.ajax({
            method: "POST",
            url: "/var/changePassword.php",
            async: false,
            data: { data: email }
        })
            .done(function( msg ) {
                if(msg == 1){
                    {% if lang == 'fr' %}
                        toastr["success"]("Nouveau mot de passe envoyé par email. Redirection dans 10s.");
                    {% else %}
                        toastr["success"]("New password sent by email. Redirection in 10s");
                    {% endif %}
                }else{
                    {% if lang == 'fr' %}
                        toastr["warning"]("Action impossible");
                    {% else %}
                        toastr["warning"]("Action impossible");
                    {% endif %}
                }
            });
    })
});
</script>