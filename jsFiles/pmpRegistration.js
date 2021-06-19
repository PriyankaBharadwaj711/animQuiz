$(document).ready(function() {

    $(document).on('change', '#roleSelect', function() {
        var role = "";
        role = $("#roleSelect option:selected").val();
        //   alert (role);
        if (role == 19) {
            $("#testSelect").show();
        } else {
            $("#testSelect").hide();
        }
    });

    $(document).on('click', '#sbtRegistrationForm', function() {
        var f_name = $('#f_name').val();
        var l_name = $('#l_name').val();
        var ud_name = $('#ud_name').val();
        var org = $('#organization').val();
        var password = $('#password').val();
        var confpwd = $('#confirmpassword').val();
        var email_at_registration = $('#email_at_registration').val();
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        var roleSelect = $('#roleSelect').val();
        // alert(roleSelect);
        $('.error').html('');
        if (f_name == "") {
            $('#spanf_name').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter First Name " + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        } else if (l_name == "") {
            $('#spanl_name').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter Last Name " + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        } else if (ud_name == "") {
            $('#spanud_name').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter User Name " + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        } else if (email_at_registration == "") {
            $('#spanEmail_at_registration').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter Email" + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        }
        //  else if (!($('#email_at_registration').val().length > 1) || (!mailformat.test($('#email_at_registration').val()))) {
        //     $('#spanEmail_at_registration').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter valid Email Address");
        //     $('#email_at_registration').focus();
        //     return false;
        // } 
        else if (roleSelect == "Select") {
            $('#spanSelectRole').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter user role" + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        } else if (org == "") {
            $('#spanOrganization').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter ORGANIZATION Name" + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        } else if (password == "") {
            $('#spanpassword').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter USER PASSWORD" + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        } else if (confpwd == "") {
            $('#spanconfirmpassword').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Re-type PASSWORD" + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        } else if (password != confpwd) {
            $('#spanconfirmpassword').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp ***Re-Type the same password given above ");
            return false;
        } else {
            console.log('All Validations passed the data will be inserted in to DB');
            //alert('Success validations');
            return true;
         }
    });

});

//Check if email is already existing in DB or not
$(document).on("input", '#email_at_registration', function() {
    // alert("akjfl;j");
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var cgemail = $('#email_at_registration').val().trim();
    if (($('#email_at_registration').val().length > 1) && (mailformat.test($('#cgemail').val()))) {

        $('#spanEmail_at_registration').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter valid Email Address");
        $('#email_at_registration').focus();

        alert(cgemail);
        $.ajax({
            url: './services/check_email_availability.php',
            data: {
                'CGemail': cgemail
            },
            type: 'POST',
            datatype: 'text',
            success: function(data) {
                if (data == "failure") {
                    $('#spanEmail_at_registration').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Email already exists");
                    $('#spanEmail_at_registration').removeClass("error_green").addClass("error_red");
                    return false;
                } else {
                    $('#spanEmail_at_registration').html("<i class='fa fa-thumbs-up' aria-hidden='true'></i>&nbsp Email available");
                    $('#spanEmail_at_registration').removeClass("error_red").addClass("error_green");
                }
            }
        });
    }
});