// talking function starts
// var iOS = /safari|iPad|iPhone|iPod/i.test(navigator.userAgent) && !window.MSStream && navigator.userAgent.indexOf("Chrome")  === -1;
// var iPhone = /iPad|iPhone|iPod/.test(navigator.userAgent);
var iosIssue = false;

$(document).click(function (e) {
    if($('#modalCommon').css("display") == "block") {
        console.log("modalcommon" + $(e.target));
        if($(e.target).is('#modalCommon')) {
            $("#modalCommon").modal("show");
        }
    }
});
$(document).ready(function() {
//to catch the result of voice recording method 
  
    $("#closebtn").click(function(){
        $('#modalCommon').modal('hide');
      });
try {
    // adddlert("Welcome guest!");
    navigator.mediaDevices.getUserMedia({
        audio: true,// We are only interested in the audio,
        video: false
        }).then(function (stream) {
            // safari
                // $("#main").hide();
                // $("#main1").show();
                $("#recordArea").show();
                // iosIssue = true;
        })
            .catch(function (err) {
                // chrome browser
                console.log(err);
                // $("#main").show();
                // $("#main1").hide();
                $("#recordArea").hide();
                iosIssue = true;
            });
    }
    catch(err) {
        // $("#main").show();
        // $("#main1").hide();
        $("#recordArea").hide();
        iosIssue = true;
    }


    


    // console.log("0.5.5");

    // if(iOS){
    //     console.log(questions[currentQuestionIndex].id);
    //     if(questions[currentQuestionIndex].id == 19){
    //         console.log("insideidfbos");
    //         $("#iosNote").hide();
    //         $("#iosNoteLastQues").show();
    //     } else{

    //         $("#iosNoteLastQues").hide();
    //         $("#iosNote").show();
    //     }
        // console.log(questions[currentQuestionIndex].id);
    // }
    // if(iOS){
    //     console.log("hi tinku how r u");
    // // if(navigator.userAgent.match('CriOS') == 'CriOS'){
    //     $("#main1").show();   
    // $("#main").hide();
    // }
    // else{
    //     console.log ("content should be comming here");
    //     $("#main").show();
    //     $("#main1").hide();
    // }
    
    $(".wrapper").hide();
    audioElement = document.querySelector('.js-audio');
    startButton = document.querySelector('.js-start');
    stopButton = document.querySelector('.js-stop');

    // Add event listeners to the start and stop button
    var talker_id;
    var voicelist = responsiveVoice.getVoices();
    // console.log(voicelist);

    $("#talkerVoiceList").change(function() {
        // console.log("voice changed to : " + $(this).val());
        voice_type = $(this).val();
    });

    $(document).on('click', '.play', function() {
        // $('#avatar,#selectAvatarBtn').show();
        id = $(this).attr('id');
        //   console.log(id);
        $('.pause').hide();
        $('.resume').hide();
        talker_id = id.split('_')[0];
        var text = $('.' + talker_id).text();
        responsiveVoice.cancel();
        responsiveVoice.speak(text, "UK English Female");
        $('.talker_controls .fa').css('color', 'black');
        $('#' + talker_id + '_play').css('color', 'red');
        $('#' + talker_id + '_pause').show();
        $('#' + talker_id + '_resume').show();
    });
    $(document).on('click', '.pause', function() {
        // $('#avatar,#selectAvatarBtn').hide();
        $('.talker_controls .fa').css('color', 'black');
        $('.pause').css('color', 'red');
        responsiveVoice.pause();
    });
    $(document).on('click', '.resume', function() {
        // $('#avatar,#selectAvatarBtn').show();
        $('.talker_controls .fa').css('color', 'black');
        $('.resume').css('color', 'red');
        responsiveVoice.resume();
    });
    // to show other text field on click of Other Radio Button 
   

});
//taklking function ends

function PlaySound(soundobj) {
    var thissound=document.getElementById(soundobj);  
    if($("#startRecordBtn").is(":disabled")){
        thissound.pause();
    } else {
        thissound.play();
    }
}

function StopSound(soundobj) {
    var thissound=document.getElementById(soundobj);
    thissound.pause();
    thissound.currentTime = 0;
}

// We'll save all chunks of audio in this array.
var chunks = [];

// We will set this to our MediaRecorder instance later.
let recorder = null;

// We'll save some html elements here once the page has loaded.
let audioElement = null;
let startButton = null;
let stopButton = null;

/**
 * Save a new chunk of audio.
 * @param  {MediaRecorderEvent} event 
 */
const saveChunkToRecording = (event) => {
    // console.log(event);
    chunks.push(event.data);
};

/**
 * Save the recording as a data-url.
 * @return {[type]}       [description]
 */
const saveRecording = () => {
    const blob = new Blob(chunks, {
        type: 'video/mp4;'
    });
    const url = URL.createObjectURL(blob);
    var sourceElement = document.createElement('source');
    sourceElement.src=url;
    sourceElement.type = 'video/mp4'; 
    $(".js-audio").empty();
    audioElement.appendChild(sourceElement);
    audioElement.load();
};

/**
 * Start recording.
 */
function startRecording(){
    document.querySelector('.recording-btn').click();
    $("#mySound")[0].pause();
        $(".audio-wrapper").hide();
        $("#startRecording").show();
    $('#startRecordBtn').prop('disabled',true);
    $('#stopRecordBtn').prop('disabled',false);
    console.log("start recording now");
    getRecordingPermission();
    if(recorder) {
        chunks = [];
        recorder.start();
        recorder.ondataavailable = function(event){
          chunks.push(event.data);
        
        };
        recorder.onstop = function(e){
            saveRecording();
        };
    }
}

/**
 * Stop recording.
 */
function stopRecording(){
    document.querySelector('.recording-btn').click();
    $(".audio-wrapper").show();

    $("#startRecording").hide();
    $('#stopRecordBtn').prop('disabled', true);
    $('#startRecordBtn').prop('disabled',false);
    console.log("stop recording now");
    recorder.stop();
}

 function getRecordingPermission(){
    console.log("getRecordingPermission");
    // We'll get the user's audio input here.
    $("#video1").removeAttr("autoplay");
    $("#video1").removeAttr("playsinline");
     navigator.mediaDevices.getUserMedia({
      audio: true ,// We are only interested in the audio,
      video:false
  }).then(function(stream){
    // console.log("streaming",stream);
      // Create a new MediaRecorder instance, andeprovide the audio-stream.
      recorder = new MediaRecorder(stream,{type:"audio/webm"});
    
    //   console.log("streaming",recorder);
      // Set the recorder's eventhandlers
      chunks = [];
      recorder.start();
      recorder.ondataavailable = function(event){
        // console.log(event.data);
        chunks.push(event.data);
      
      };
      recorder.onstop = function(e){
          saveRecording();
      };
  }).catch(function(err) {
   console.log(err);
  });
  }