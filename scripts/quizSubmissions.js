$(document).ready(function() {
    var data = "nullhkj";


});

// function $("#resetQuizAnswers").click(function () {
function resetQuiz() {

    // alert ("test reset quiz");
    var idfromphp = $('#resetID').val();

    $.ajax({
        url: 'services/delete_fbAns_to_reset.php',
        type: 'POST',
        datatype: 'text',
        data: { 'idtoReset': idfromphp },
        success: function(data) {
            if (data == "true") {
                swal({
                    title: "Yay!",
                    text: "Quiz has been reset.Please tell the student to Logout and Login to re-attempt the quiz.",
                    imageUrl: './resources/thumbsupSmiley.jpeg'
                }, function() {
                    window.location.reload();
                });

            } else {
                swal({
                    title: "Oops",
                    text: "No Quiz to reset",
                    imageUrl: './resources/thumbsDown.jpeg'
                });
            }
        }
    });
}

function showQuizResults(uid) {
    // alert(uid);
    $.ajax({
        url: 'services/pullAnswers.php',
        type: 'POST',
        datatype: 'text',
        data: { 'userid': uid },
        success: function(data) {
            // alert(data);
            $("#ansresults").html(data);
        }
    });
}

function singleReporttoexcel(uid) {
    $.ajax({
        url: 'services/pullAnswers.php',
        type: 'POST',
        datatype: 'text',
        data: { 'userid': uid },
        success: function(data) {
            $("#ansresults").html(data);
            $("#myModal ul").css("display", "none");
            $("#home").removeClass("tab-pane active");
            $("#menu1").removeClass("tab-pane fade");
            $(".resetQuiz").addClass("hideResetQuiz");
            // var x = $(".xyz").html($("#ansresults #home").html());
            // var y = $(".xyz").append($("#ansresults #menu1").html());
            // $(".xyz").show();
            $("#tbl1").table2excel({
                // exclude:".noExl",
                name: "Demographics",
                filename: "LifescreenReport.xls",
                // fileext:".xls",
                preserveColors: true
            });

        }
    });

}

function AllReportstoExcel(uid) {
    $.ajax({
        url: 'services/pullAnswers_1.php',
        type: 'POST',
        datatype: 'text',
        data: { 'userid': uid },
        success: function(data) {
            $("#ansresults").html(data);
            $("#myModal ul").css("display", "none");
            $("#home").removeClass("tab-pane active");
            $("#menu1").removeClass("tab-pane fade");
            $(".resetQuiz").addClass("hideResetQuiz");
            // var x = $(".xyz").html($("#ansresults #home").html());
            // var y = $(".xyz").append($("#ansresults #menu1").html());
            // $(".xyz").show();
            $("#tbl1").table2excel({
                // exclude:".noExl",
                name: "Demographics",
                filename: "LifescreenReport.xls",
                // fileext:".xls",
                preserveColors: true
            });

        }
    });

}