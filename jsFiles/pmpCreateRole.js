$(document).ready(function () {

    $('#existing_role_table').DataTable();
    $(document).on('click', '#createRoleSubmit', function() {
   
    var createRole = $('#createRole').val();
    var roleSF = $('#shortform').val();
    var chkbox1= $('input[name="createf1"]');
    var chkbox2= $('input[name="createf2"]');
    var chkbox3= $('input[name="createf3"]');
    

    $('.error').html('');
    if (createRole == "") {
        $('#span_createRole').html("Enter Role Name " + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
        return false;
    } else if (roleSF == "") {
        $('#span_shortForm').html("Enter Short Form " + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
        return false;
    }else{
              var checkData = [];
                if(chkbox1.prop("checked") == true){
                    checkData[0] = 1;
                }else{
                    checkData[0] = 0;
                }
                if(chkbox2.prop("checked") == true){
                    checkData[1] = 2;
                }else{
                    checkData[1] = 0;
                }
                if(chkbox3.prop("checked") == true){
                    checkData[2] = 3;
                }else{
                    checkData[2] = 0;
                }
                $.ajax({
                    url: './services/request_insert_value_rolecheckbox.php',
                    data: {  'rfcb1': checkData[0],'rfcb2': checkData[1],'rfcb3': checkData[2],'createRole1':createRole,'shortcut' :roleSF },
                    type: 'POST',
                    datatype: 'text',
                    success: function (data) {
                    alert(data);
                    }
                });
        // });
    }
    });
});