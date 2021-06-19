$(document).ready(function() {

    $(document).on('click', '#otherGenderDemo', function() {
        $('#other_reason').show();
    });

    $(document).on('click', '#fGender', function() {
        $('#other_reason').hide();
    });

    $(document).on('click', '#mGender', function() {
        $('#other_reason').hide();
    });

    $(document).on('click', '#transGender', function() {
        $('#other_reason').hide();
    });

    $(document).on('click', '.disableOtherText', function() {
        $('#other_reason').hide();
        $('#other_reason').val("");
    });

});
$("#noLoginSubmit").click(function() {

    var stuName = $('#studentName').val();
    var stuEmail = $('#email').val();

    alert(stuName + "" + stuEmail);
});

function validateLogin(e) {
    var u_name = $('#username').val();
    var pwd = $('#password').val();
    return true;
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