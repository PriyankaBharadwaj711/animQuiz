
var currentQuestionIndex = 0;
var optionNum = 0; 
var enableNext = function(){}
var optionTimer ;
// var iosIssue = false;
    

$(document).ready(function () {
  // to identify wether record function works ornot in IOS Chrome
 
  console.log("cwdfl function");
  playQuestion();
  $("#submitQuiz").hide();
  $("#nextbtn").hide();
  // $("#debugLog").empty();
  // $("#debugLog").append("next btn:"+currentQuestionIndex+":"+iosIssue);
  
  enableNext = function() {
    if (questions[currentQuestionIndex].id == 1) {
      $("#vedioNote").hide();
      ans = "null";
      $('.modal').modal('toggle'); 
      $("#nextbtn").show();
      //After Intro  next button click function in modal 
   $("#nextbtn").click(function () {
    questions[currentQuestionIndex].answer = ans;
    console.log(currentQuestionIndex + " enable next");

      answerValidation(ans,questions[currentQuestionIndex].id,"");  
      $('.modal').modal('toggle');
        currentQuestionIndex += 1;
        playQuestion();
      });
      $("#saveAndNext").hide();
     
    }
    else if (currentQuestionIndex < questions.length){
      $('.modal').modal('toggle'); 
      $("#nextbtn").hide();
      $("#saveAndNext").show();
    } 
    else {
      console.log(currentQuestionIndex + "last question");
    $(".wrapper").show();
      // $("#optionsHolder").hide();
      $('.modal').modal('toggle'); 
      // $("#nextbtn").hide();
      $("#saveAndNext,#nextbtn, #closebtn, #optionsHolder").hide();
      $("#submitQuiz").show();
    }
    document.getElementById("mySound").play();
    optionNum=0;
    $("#submitQuiz").attr("disabled", false);
  };
    //save question and go got next
  $("#saveAndNext").click(function () {
    clearTimeout(optionTimer);
    var ans = $("input:radio[name ='question']:checked").val();
    if ( questions[currentQuestionIndex].id>1) {
      if (!ans) {
        swal({ type: "error", title: 'Error!', text: 'Please check any one option to view next question!', confirmButtonClass: "btn-danger", confirmButtonText: 'OK' });
        return;
      } else {
        questions[currentQuestionIndex].answer = ans;
        answerValidation(ans,questions[currentQuestionIndex].id,"");  
        $('.modal').modal('toggle');
      }
    }else if (questions[currentQuestionIndex].id==1){
      //intro video
      answerValidation("intro",questions[currentQuestionIndex].id,"");
    }
    currentQuestionIndex += 1;
    var ql = questions.length;
    //last question
    if (currentQuestionIndex == questions.length ) {
      $("#saveAndNext").hide();
    }
    else{
    }
    // if(currentQuestionIndex == questions.length-1 && iosIssue == true){  
    //   $('.modal').modal('toggle'); 
    //   $(".modal-header").html("Thank you for completing the survey");
    //   $(".modal-body").html("vedio should be appended here");
    //   $("#submitQuiz").show();
    //   return;
    // }
    playQuestion();
  });

});
//Document Ready ends

function answerValidation(ans,currentQuestionIndex,key){
  $.ajax({
    data : {'selectedAns': ans,'questionID':currentQuestionIndex},
    url:'./services/insert_feedback_ans.php',
    type: 'POST',
    datatype: 'text',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data){
     console.log(data);
     if(key=="last"){
        saveAudioFeedback();
     }
    }
  });
}

function saveAudioFeedback(){
  var formData = new FormData();
    formData.append('audio', new Blob(chunks, {
          type: 'audio/mp4; codecs=opus'
      }));
        formData.append('name',"feedback.mp4");
  $.ajax({
    url:'./services/save_feedback.php',
    type: 'POST',
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function(data){
     console.log(data);
     window.location = "./home.php?qs=1";
    },
    error: function(data){
      console.log("error",data);
    }
  });
}

function formSubmit() {
  
      swal({
        title: "Are you sure you want to submit ?",
        text: "Once Submitted you cannot go back.",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "Yes",
        closeOnConfirm: false
      },
      function(){
        questions[currentQuestionIndex].answer = "Yes";
        answerValidation("Yes",questions[currentQuestionIndex].id,"last");
        saveAudioFeedback();
      });     
   // }      
}
function playVid() { 
  var vid = document.getElementById("video1"); 
  vid.play(); 
} 
function playQuestion() {
  $("#debugLog").empty();
  $("#debugLog").append(currentQuestionIndex+":"+iosIssue);
  // if a device has IOS issue Thank you kaprea note should be played immediately after question 7
  if(currentQuestionIndex == questions.length-1 && iosIssue == true){
    $('.modal').modal('toggle'); 
      $(".modal-header").html("Thank you for completing the survey");
      $(".modal-body").html('<video id="video1" width="500" height="345" controls playsinline><source src="./vedios/thankyouKapreaNote.mp4"> type="video/mp4"> </video>');
      $("#submitQuiz").show();
      $("#saveAndNext").hide();
      $("#closebtn").hide();
      $("#nextbtn").hide();
      
  }else{
    console.log(currentQuestionIndex + "inside playQuestion");
    var videoFile = './vedios/' + questions[currentQuestionIndex].videoPath;
    $('#divVideo video source').attr('src', videoFile);
    $("#divVideo video")[0].load();
  
    
  
    $("#questionHeader").html(questions[currentQuestionIndex].heading);
    // Appending options into Input tag
    var optionsContent = "";
    //  i is index, d is value of each index in array
    $.each(questions[currentQuestionIndex].options, function (i, d) {
      console.log(d);
      optionsContent += '<label class="checkbox-inline" style="padding:10px"><input id="question" class="question" type="radio"  name="question" value="' + d + '"required> ' + d + '</label>';
    });
  
    if (currentQuestionIndex == questions.length - 1) {
      $("#submitQuiz").show();
      $("#saveAndNext").hide();
    }
  
   var qs_narrate = questions[currentQuestionIndex].question_text;
  
   var quesAudioFile = './vedios/questions/' + questions[currentQuestionIndex].q_narrate;
    $('#mySound source').attr('src', quesAudioFile);
    $("#mySound")[0].load();
    
   var temp_qs = "<p class='qs_narrate_audio' onmouseover='PlaySound(\"mySound\")' onmouseout='StopSound(\"mySound\")'>" + qs_narrate + "</p>";
   $(".modal-title").html(temp_qs);
  
  $("#optionsHolder").html(optionsContent);
  //whenever yes no sometimes is clicked the responsive voice should stop
  stopsPlaybackOptions();
  }
 

}
//Responsive code Hamberger Menu
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}

function playOptions(){
  if(currentQuestionIndex == questions.length ){
    return;
  }
  console.log("play options called ");
  if(optionNum < $("#optionsHolder label").length){
    responsiveVoice.speak($($("#optionsHolder label")[optionNum]).text(), "UK English Female",{
      onstart: optionStartCallback,
      onend: optionEndCallback
    });
  } 
}

function optionStartCallback() {
  $($("#optionsHolder label")[optionNum]).addClass("activeOption");
}

function optionEndCallback() {
  $($("#optionsHolder label")[optionNum]).removeClass("activeOption");
  optionNum +=1;
  optionTimer = setTimeout(playOptions,250);
}
//whenever yes no sometimes is clicked the responsive voice should stop
function stopsPlaybackOptions(){
  $(".question").click(function(){
    $("#mySound")[0].pause()
    responsiveVoice.cancel();
  });
}