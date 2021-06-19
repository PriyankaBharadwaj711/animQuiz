function validateLogin(e) {
    var u_name = $('#username').val();
    var pwd = $('#password').val();

    $('.error').html('');
    if (u_name == "") {
        $('#span_email').html("<p class='error_red paddingTop'>Enter FIRST NAME " + " " + '<i class = "fa fa-times" aria-hidden="true"></i></p>');
        return false;
    } else if (pwd == "") {
        $('#span_pwd').html("<p class='error_red paddingTop'>Enter LAST NAME " + " " + '<i class = "fa fa-times error_red" aria-hidden="true"></i></p>');
        return false;
    } else {
        console.log('All Validations passed the data will be inserted in to DB');
        return true;
    }
}