$(document).ready(function() {

    $('#pmpUserMaintTable').DataTable();
    $(document).on('click', '.editUserAndRoles', function() {
        console.log(this);
        var pmp_id = this.id;
        var roleName = $(this).attr("name");
        $.ajax({
            url: './services/request_pmp_Edit_SpecificUser.php',
            // data: {  'rfcb1': checkData[0],'rfcb2': checkData[1],'rfcb3': checkData[2],'createRole1':createRole,'shortcut' :roleSF },
            data: { 'pmp_id': pmp_id },
            type: 'POST',
            datatype: 'text',
            success: function(data) {
                console.log(data);
                var response = JSON.parse(data);
                var firstname = response[0]['fname'];
                var lastname = response[0]['lname'];
                var userRole = response[0]['role'];

                $("#userMaintenanceModal").modal();
                // $("#currentRoleID").html(userRole);
                $('#editSpecificUname').html(firstname + ' ' + lastname);
            },
            error: function(err) {
                alert("err" + err);
            }
        });
    });
});

function approveUser(pmpid, clickedApproveRow) {
    $.ajax({
        url: './services/update_approve_status_user.php',
        data: { 'pmp_u_id': pmpid },
        type: 'POST',
        datatype: 'text',
        success: function(data) {
            // alert(data);
            $(clickedApproveRow).parents('tr').remove();
        }
    });
}

function rejectUser(pmpid, clickedRejectRow) {
    $.ajax({
        url: './services/update_reject_status_user.php',
        data: { 'pmp_u_id': pmpid },
        type: 'POST',
        datatype: 'text',
        success: function(data) {
            // alert(data);
            if (data == "rejected") {
                $(clickedRejectRow).parents('tr').remove();

            } else {
                alert("not rej");
            }
        }
    });
}