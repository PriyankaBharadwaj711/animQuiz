$(document).ready(function() {
    $('li.list-group-item').removeClass("active");
    var selectedProfile = "";
    console.log(typeof(character));
    $( "li.list-group-item" ).each(function() {
        if($(this).attr("value") == character) {
            $(this).addClass("active");
            selectedProfile = $('this').attr("value");
        }

      });
    $('.alignList').on('click', 'li', function() {
        // console.log("clicked");
        $('li.list-group-item.active').removeClass("active"); 
        $(this).addClass("active");
        selectedProfile = $(this).attr("value");
        
    });
    console.log(selectedProfile);
    $("#selectProfile").click(function() {
        selectData = selectedProfile;
        saveSelectedProfile(selectData).then(function(data){
            console.log(data);
            swal({type: "success",title: 'Success',text: "Profile selection Updated Successfully",confirmButtonClass: "btn-success",confirmButtonText: 'Ok'});
        
        }).catch(function(error){
            //TODO error handle errors
        })
    });
});
function saveSelectedProfile(selectData){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "./Controllers/AnimationController.php",
            type: "POST",
            data: {"type": "selectView", "selection": selectData },
            // datatype: text,
            success: function(data){
                resolve(data);
            },
            error: function(data){
                reject(data);
            }
        })
    });
}