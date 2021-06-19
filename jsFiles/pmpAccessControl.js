$(document).ready(function() {

    $('#existing_role_table').DataTable();
    $(document).on('click', '#createRoleSubmit', function() {
        var createRole = $('#createRole').val();
        // var roleSF = $('#shortform').val();
        var chkbox1 = $('input[name="createf1"]');
        var chkbox2 = $('input[name="createf2"]');
        var chkbox3 = $('input[name="createf3"]');
        var chkbox4 = $('input[name="createf4"]');
        var chkbox5 = $('input[name="createf5"]');
        var chkbox6 = $('input[name="createf6"]');
        var chkbox7 = $('input[name="createf7"]');
        var chkbox8 = $('input[name="createf8"]');
        var chkbox9 = $('input[name="createf9"]');
        var chkbox10 = $('input[name="createf10"]');
        var chkbox11 = $('input[name="createf11"]');
        var chkbox12 = $('input[name="createf12"]');
        var chkbox13 = $('input[name="createf13"]');
        var chkbox14 = $('input[name="createf14"]');
        var chkbox15 = $('input[name="createf15"]');



        $('.error').html('');
        if (createRole == "") {
            $('#span_createRole').html("Enter Role Name " + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        } else {
            var checkData = [];
            if (chkbox1.prop("checked") == true) {
                checkData[0] = 1;
            } else {
                checkData[0] = 0;
            }
            if (chkbox2.prop("checked") == true) {
                checkData[1] = 2;
            } else {
                checkData[1] = 0;
            }
            if (chkbox3.prop("checked") == true) {
                checkData[2] = 3;
            } else {
                checkData[2] = 0;
            }
            if (chkbox4.prop("checked") == true) {
                checkData[3] = 4;
            } else {
                checkData[3] = 0;
            }
            if (chkbox5.prop("checked") == true) {
                checkData[4] = 5;
            } else {
                checkData[4] = 0;
            }
            if (chkbox6.prop("checked") == true) {
                checkData[5] = 6;
            } else {
                checkData[5] = 0;
            }
            if (chkbox7.prop("checked") == true) {
                checkData[6] = 7;
            } else {
                checkData[6] = 0;
            }
            if (chkbox8.prop("checked") == true) {
                checkData[7] = 8;
            } else {
                checkData[7] = 0;
            }
            if (chkbox9.prop("checked") == true) {
                checkData[8] = 9;
            } else {
                checkData[8] = 0;
            }
            if (chkbox10.prop("checked") == true) {
                checkData[9] = 10;
            } else {
                checkData[9] = 0;
            }
            if (chkbox11.prop("checked") == true) {
                checkData[10] = 11;
            } else {
                checkData[10] = 0;
            }
            if (chkbox12.prop("checked") == true) {
                checkData[11] = 12;
            } else {
                checkData[11] = 0;
            }
            if (chkbox13.prop("checked") == true) {
                checkData[12] = 13;
            } else {
                checkData[12] = 0;
            }

            $.ajax({
                url: './services/insert_roleCB.php',
                data: { 'rfcb1': checkData[0], 'rfcb2': checkData[1], 'rfcb3': checkData[2], 'rfcb4': checkData[3], 'rfcb5': checkData[4], 'rfcb6': checkData[5], 'rfcb7': checkData[6], 'rfcb8': checkData[7], 'rfcb9': checkData[8], 'rfcb10': checkData[9],'rfcb11': checkData[10],'rfcb12': checkData[11],'rfcb13': checkData[12], 'createRole1': createRole },
                type: 'POST',
                datatype: 'text',
                success: function(data) {
                    alert(data);
                }
            });
        }
    });

    $(document).on('click', '.editRole', function() {
        console.log(this);
        var role_ID = this.id;
        var roleName = $(this).attr("name");
        $.ajax({
            url: './services/request_pmp_fetch_role.php',
            data: { 'roleid': role_ID },
            type: 'POST',
            datatype: 'text',
            success: function(data) {
                // console.log(data);
                var response = JSON.parse(data);
                $("#updateRoleId").val(role_ID);
                $("#updateRoleName").val(roleName);

                $("#ef1").prop("checked", false);
                $("#ef2").prop("checked", false);
                $("#ef3").prop("checked", false);
                $("#ef4").prop("checked", false);
                $("#ef5").prop("checked", false);
                $("#ef6").prop("checked", false);
                $("#ef7").prop("checked", false);
                $("#ef8").prop("checked", false);
                $("#ef9").prop("checked", false);
                $("#ef10").prop("checked", false);
                $("#ef11").prop("checked", false);
                $("#ef12").prop("checked", false);
                $("#ef13").prop("checked", false);

                if (response.length == 0) {

                } else {
                    for (var i = 0; i < response.length; i++) {
                        var featurePermission = response[i];
                        $("#ef" + featurePermission.fid).prop("checked", true);
                    }
                }
                $("#myModal2").modal();
            }
        });
    });


    //update the new feature mapping
    $(document).on('click', '#editRolebtn', function() {
        var roleId = $('#updateRoleId').val();
        var chkbox1 = $('input[name="editf1"]');
        var chkbox2 = $('input[name="editf2"]');
        var chkbox3 = $('input[name="editf3"]');
        var chkbox4 = $('input[name="editf4"]');
        var chkbox5 = $('input[name="editf5"]');
        var chkbox6 = $('input[name="editf6"]');
        var chkbox7 = $('input[name="editf7"]');
        var chkbox8 = $('input[name="editf8"]');
        var chkbox9 = $('input[name="editf9"]');
        var chkbox10 = $('input[name="editf10"]');
        var chkbox11 = $('input[name="editf11"]');
        var chkbox12 = $('input[name="editf12"]');
        var chkbox13 = $('input[name="editf13"]');

        var checkData = [];
        if (chkbox1.prop("checked") == true) {
            checkData[0] = 1;
        } else {
            checkData[0] = 0;
        }
        if (chkbox2.prop("checked") == true) {
            checkData[1] = 2;
        } else {
            checkData[1] = 0;
        }
        if (chkbox3.prop("checked") == true) {
            checkData[2] = 3;
        } else {
            checkData[2] = 0;
        }
        if (chkbox4.prop("checked") == true) {
            checkData[3] = 4;
        } else {
            checkData[3] = 0;
        }
        if (chkbox5.prop("checked") == true) {
            checkData[4] = 5;
        } else {
            checkData[4] = 0;
        }
        if (chkbox6.prop("checked") == true) {
            checkData[5] = 6;
        } else {
            checkData[5] = 0;
        }
        if (chkbox7.prop("checked") == true) {
            checkData[6] = 7;
        } else {
            checkData[6] = 0;
        }
        if (chkbox8.prop("checked") == true) {
            checkData[7] = 8;
        } else {
            checkData[7] = 0;
        }
        if (chkbox9.prop("checked") == true) {
            checkData[8] = 9;
        } else {
            checkData[8] = 0;
        }
        if (chkbox10.prop("checked") == true) {
            checkData[9] = 10;
        } else {
            checkData[9] = 0;
        }
        if (chkbox11.prop("checked") == true) {
            checkData[10] = 11;
        } else {
            checkData[10] = 0;
        }
        if (chkbox12.prop("checked") == true) {
            checkData[11] = 12;
        } else {
            checkData[11] = 0;
        }
        if (chkbox13.prop("checked") == true) {
            checkData[12] = 13;
        } else {
            checkData[12] = 0;
        }
        $.ajax({
            url: './services/update_roleCB.php',
            data: { 'rfcb1': checkData[0], 'rfcb2': checkData[1], 'rfcb3': checkData[2], 'rfcb4': checkData[3], 'rfcb5': checkData[4], 'rfcb6': checkData[5], 'rfcb7': checkData[6], 'rfcb8': checkData[7], 'rfcb9': checkData[8], 'rfcb10': checkData[9], 'rfcb11': checkData[10], 'rfcb12': checkData[11], 'rfcb13': checkData[12],'roleid': roleId },
            type: 'POST',
            datatype: 'json',
            success: function(data) {
                console.log(data);
                console.log(data.indexOf("mapped"));
                if (data.indexOf("mapped") != 0) {
                    console.log("done");
                    alert("The changes have been modified");
                } else {
                    console.log("not done");
                }
                $('#myModal2').modal('hide');
            }
        });

    });
});
//update table on deativating the role
function disableRole(roleId) {
    $.ajax({
        url: './services/update_disable_role.php',
        data: { "role_ID": roleId },
        type: 'POST',
        datatype: 'text',
        success: function(data) {
            // alert(data);
            location.reload();

        }
    });
}

function enableRole(roleID) {
    $.ajax({
        url: './services/update_enable_role.php',
        data: { "role_ID": roleID },
        type: 'POST',
        datatype: 'text',
        success: function(data) {
            // alert(data);
            location.reload();

        }
    });
}