$(document).on('click', '#sbtRegistrationForm', function() {
    var f_name = $('#fname').val();
    var l_name = $('#lname').val();
    var password = $('#password').val();
    var confirmPassword = $('#confirmPassword').val();
    var username = $('#username').val();
    var phnum = $('#phnum').val();
    var email = $('#email').val();
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var age = $('#age').val();
    var gridRadios = $('#gridRadios').val();
    var org = $('#org').val();
    var addr1 = $('#addr1').val();
    var city = $('#city').val();
    var state = $('#state').val();
    var zipcode = $('#zipcode').val();


    // alert(roleSelect);
    $('.error').html('');
        if (f_name == "") {
            $('#spanf_name').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter First Name " + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        } 
        else if (l_name == "") {
            $('#spanl_name').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter Last Name " + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        } else if (password == "") {
                $('#spanpassword').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter USER PASSWORD" + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
                return false;
        } else if (confirmPassword == "") {
            $('#spanconfirmpassword').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Re-type PASSWORD" + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false; 
        } else if (username == "") {
            $('#spanEmail_at_registration').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter Username" + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        }
    //  else if (!($('#email_at_registration').val().length > 1) || (!mailformat.test($('#email_at_registration').val()))) {
    //     $('#spanEmail_at_registration').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter valid Email Address");
    //     $('#email_at_registration').focus();
    //     return false;
    // } 
    // else if (roleSelect == "Select") {
    //     $('#spanSelectRole').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter user role" + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
    //     return false;
    // } else if (org == "") {
    //     $('#spanOrganization').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter ORGANIZATION Name" + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
    //     return false;
    // } else if (password != confpwd) {
    //     $('#spanconfirmpassword').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp ***Re-Type the same password given above ");
    //     return false;
    // }
     else {
        console.log('All Validations passed the data will be inserted in to DB');
        //alert('Success validations');
        return true;
    }
});
