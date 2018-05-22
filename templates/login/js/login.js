<script>
    $(document).ready(function(){
        $('#login').on('click',function(){
            var success = 0;
            var email = $('#orangeForm-email').val();
            var password = $('#orangeForm-pass').val();
            if(email.length >= 0){
                if(password.length >= 0){
                    $.ajax({
                        method: "POST",
                        url: "/var/connection.php",
                        async: false,
                        data: { log: "login", email: email, pwd: password }
                    })
                        .done(function(text) {
                            if(text == 1){
                                success = 1;
                            }else{
                                success = 0;
                            }
                        });
                }
            }

            if(success == 1){
                toastr["success"](loginSuccess);
                var form = '<div class="card wow fadeIn" data-wow-delay="0.3s"><form action="/var/formDispatcher.php" method="POST">';
                form += '<div class="card-body"><input type="hidden" name="formName" value="userActivate">';
                form += '<div class="form-header success-color-dark"><h3> {{ trans.completeToActivate }}</h3></div>';
                form += '<div class="md-form">\n';
                form += '<input type="text" id="materialFormRegisterNameEx" name="name" class="form-control">\n';
                form += '<label for="materialFormRegisterNameEx">{{ trans.name }}</label>\n';
                form += '</div>\n<div class="md-form">\n';
                form += '<input type="text" id="materialFormRegisterEmailEx" name="firstname" class="form-control">\n';
                form += '<label for="materialFormRegisterEmailEx">{{ trans.firstname }}</label>\n';
                form += '</div>\n<div class="md-form">\n';
                form += '<div class="form-check"><input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadiosInline1" value="0" checked>';
                form += '<label class="form-check-label" for="exampleRadiosInline1">{{ trans.man }}</label></div>';
                form += '<div class="form-check"><input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadiosInline2" value="1">';
                    form += '<label class="form-check-label" for="exampleRadiosInline2">{{ trans.woman }}</label></div>';
                form += '<div class="form-check"><input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadiosInline3" value="2">';
                    form += '<label class="form-check-label" for="exampleRadiosInline3">{{ trans.other }}</label></div>';
                form += '</div><div class="md-form">\n';
                form += '<input type="number" id="materialFormRegisterPasswordEx" name="phone" class="form-control">\n';
                form += '<label for="materialFormRegisterPasswordEx">{{ trans.phone }}</label>\n</div>';
                form += '<div class="text-center">\n';
                form += '<input type="submit" class="btn success-color-dark btn-lg" id="login" value="{{ trans.activate }}">\n';
                form += '<hr>\n</div></div></form></div>';
                $('#cardBody').html(form);
            }

            if(success == 0){
                toastr["warning"](loginFail);
            }
        });
    });
</script>