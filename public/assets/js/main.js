$(document).ready(function(){
    if($("#errorModal").length){
        $("#errorModal").modal('show');
    }
    $('.sign-in-button').on("click",function(){
       $("#signIn").modal('show')
    });
    $('.sign-up-button').on("click",function(){
        $("#signUp").modal('show')
    });
    $("#signInForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true
            }
        },
        submitHandler: function (form) {
            $('.error-login').html('');
            $.ajax({
                url: "/login",
                type: "POST",
                data: $(form).serialize(),
                dataType: "json",
                success: function(data){
                    location.reload();
                },
                error: function(data){
                    $('.error-login').html(JSON.parse(data.responseText).message);
                    $('.error-login').show();
                }
            })
        }
    });
    $("#signUpForm").validate({
        rules: {
            name: {
                required: true,
                minlength : 3
            },
            email: {
                required: true,
                email: true,
            },
            password : {
                required: true,
                minlength : 5
            },
            password_confirmation : {
                required: true,
                minlength : 5,
                equalTo : "#password"
            }
        },
        submitHandler: function (form) {
            $('.error-register').html('');
            $.ajax({
                url: "/register",
                type: "POST",
                data: $(form).serialize(),
                dataType: "json",
                success: function(data){
                    location.reload();
                },
                error: function(data){
                    $('.error-register').html(JSON.parse(data.responseText).email);
                    $('.error-register').show();
                }
            })
        }
    });
});
