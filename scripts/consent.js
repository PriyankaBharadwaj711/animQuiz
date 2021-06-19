$(document).ready(function () {
    $(document).on('submit', '.consentBtn', function () {
      
        var signDate = $("#signDate").val();
        // alert (signatureName);
        if (signatureName == ""){
            // alert (signatureName);
            $('#spanSigName').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter your First and Last name " + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        }
        if (signDate == ""){
            // alert (signatureName);
            $('#spandate').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp Enter Date " + " " + '<i class = "fa fa-times" aria-hidden="true"></i>');
            return false;
        }
        // console.log("clicked on consent button");
        // window.location.href = "./index.php?version="+versionSent;
    });
});
