<?php
require_once("connect_db_remodeled.php");
function getBrowser() { 
  $u_agent = $_SERVER['HTTP_USER_AGENT'];
  $bname = 'Unknown';
  $platform = 'Unknown';
  $version= "";

  //First get the platform?
  if (preg_match('/linux/i', $u_agent)) {
    $platform = 'linux';
  }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
    $platform = 'mac';
  }elseif (preg_match('/windows|win32/i', $u_agent)) {
    $platform = 'windows';
  }

  // Next get the name of the useragent yes seperately and for good reason
  if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  }elseif(preg_match('/Firefox/i',$u_agent)){
    $bname = 'Mozilla Firefox';
    $ub = "Firefox";
  }elseif(preg_match('/OPR/i',$u_agent)){
    $bname = 'Opera';
    $ub = "Opera";
  }elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
    $bname = 'Google Chrome';
    $ub = "Chrome";
  }elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
    $bname = 'Apple Safari';
    $ub = "Safari";
  }elseif(preg_match('/Netscape/i',$u_agent)){
    $bname = 'Netscape';
    $ub = "Netscape";
  }elseif(preg_match('/Edge/i',$u_agent)){
    $bname = 'Edge';
    $ub = "Edge";
  }elseif(preg_match('/Trident/i',$u_agent)){
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  }

  // finally get the correct version number
  $known = array('Version', $ub, 'other');
  $pattern = '#(?<browser>' . join('|', $known) .
')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
  if (!preg_match_all($pattern, $u_agent, $matches)) {
    // we have no matching number just continue
  }
  // see how many we have
  $i = count($matches['browser']);
  if ($i != 1) {
    //we will have two since we are not using 'other' argument yet
    //see if version is before or after the name
    if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
        $version= $matches['version'][0];
    }else {
        $version= $matches['version'][1];
    }
  }else {
    $version= $matches['version'][0];
  }

  // check if we have a number
  if ($version==null || $version=="") {$version="?";}

  return array(
    'userAgent' => $u_agent,
    'name'      => $bname,
    'version'   => $version,
    'platform'  => $platform,
    'pattern'    => $pattern
  );
} 


// now try it
$ua=getBrowser();
$sql = "INSERT INTO users (username, fname, lname, role) VALUES ('$ua[name]', '$ua[version]', '$ua[platform]', '$ua[userAgent]');";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- search static content-->
    <script src="https://cdn.jsdelivr.net/mark.js/7.0.0/jquery.mark.min.js"></script>

    <link rel="stylesheet" type="text/css" href="design/styleSheet.css">
    <link rel="manifest" href="./manifest.webmanifest">

    <script>
        // function openNav() {
        //     document.getElementById("mySidebar").style.width = "250px";
        //     document.getElementById("main").style.marginLeft = "250px";
        // }

        // function closeNav() {
        //     document.getElementById("mySidebar").style.width = "0";
        //     document.getElementById("main").style.marginLeft = "0";
        // }
        function openNav() {

            if (document.getElementById("mySidebar").style.width == "300px" || document.getElementById("mySidebar").style.width == "0px") {
                document.getElementById("overlay").style.display = "block";
                document.getElementById("mySidebar").style.width = "300px";
                document.getElementById("mySidebar").classList.toggle('active');
                // document.getElementById("main1").style.marginLeft = "0";
            } else {
                document.getElementById("mySidebar").style.width = "0px";
                // document.getElementById("main1").style.marginLeft = "200px";
            }
        }

        /* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
        function closeNav() {
            document.getElementById("overlay").style.display = "none";
            document.getElementById("mySidebar").style.width = "0";
            // document.getElementById("main1").style.marginLeft = "0";
        }

        //ADd smooth scroll to 
        $(document).ready(function () {
            // Add smooth scrolling to all links in navbar 
            $(".ul li a").on('click', function (event) {
                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 900, function () {

                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                } // End if
            });

            // $(function() {
            //     $("input").on("input.highlight", function() {
            //         // Determine specified search term
            //         var searchTerm = $(this).val();
            //         // Highlight search term inside a specific context
            //         $("#result_div").unmark().mark(searchTerm);
            //     }).trigger("input.highlight").focus();
            //     });
                        })
        //ass slidein animation
        $(window).scroll(function () {
            $(".slideanim").each(function () {
                var pos = $(this).offset().top;

                var winTop = $(window).scrollTop();
                if (pos < winTop + 600) {
                    $(this).addClass("slide");
                }
            });
        });


    </script>

    <script src="./index.js"></script>
    <!--  
         <link href="/App512.png" sizes="512x512" rel="apple-touch-startup-image" />
    <link href="/App192.png" sizes="192x192" rel="apple-touch-startup-image" /> -->
</head>
<style>
    .h1Green {
        color: white;
        border: 5px solid #33c733;
        background-color: #33c733;
    }

    .h1purple {
        color: white;
        border: 5px solid #7b45c1;
        background-color: #7b45c1;
    }

    .h1orange {
        color: white;
        border: 5px solid #d25134;
        background-color: #d25134;
    }

    .h1blue {
        color: white;
        border: 5px solid #5391de;
        background-color: #5391de;
    }

    .h1red {
        color: white;
        border: 5px solid #8c2323;
        background-color: #8c2323;
    }

    .h1lightBlue {
        color: white;
        border: 5px solid #61c7de;
        background-color: #61c7de;
    }

    .h1pink {
        color: white;
        border: 5px solid #d021ca;
        background-color: #d021ca;
    }

    .h1navyBlue {
        color: white;
        border: 5px solid #13086b;
        background-color: #13086b;
    }

    mark {
        background: orange;
        color: black;
    }

    /* Media Queries: Tablet Landscape */
    @media screen and (max-width: 1060px) {
        #primary { width:67%; }
        #secondary { width:30%; margin-left:3%;}  
    }

    /* Media Queries: Tabled Portrait */
    @media screen and (max-width: 768px) {
        #primary { width:100%; }
        #secondary { width:100%; margin:0; border:none; }
    }

    @media (min-width: 640px) { body {font-size:1rem;} } 
    @media (min-width:960px) { body {font-size:1.2rem;} } 
    @media (min-width:1100px) { body {font-size:1.5rem;} } 

    img { max-width: 100%; height: auto; }

    html { font-size:100%; }
    
    .imgDimensions {
        text-align: center;
    }

    .collapse li a {
        padding-left: 5px;
    }

    .mainList {
        font-size: 24px !important;
    }

    ul.collapse a {
        font-size: 20px !important;
    }

</style>

<body>
    <div class="">
        <div id="mySidebar" class="sidebar">

            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">X</a>
            <div id="introduction">
                <a href="#intro" class="mainList" data-toggle="collapse"><i class="fa fa-book"></i> Introduction </a>
                <ul class="collapse " id="intro" style="margin-left: 20px;">
                    <li id="1" class="link">
                        <a href="#dedication" class='tab ' id='Topic1.1'>Dedication</a>
                    </li>

                    <li id="2" class="link">
                        <a href="#IntroTraumaProgram" class='tab ' id='Topic1.2'>Introduction and Program Mission</a>
                    </li>
                    <li id="3" class="link">
                        <a href="#traumaOrgChart" class='tab' id='Topic1.3'>Trauma Organizational Chart</a>
                    </li>
                    <li id="4" class="link">
                        <a href="#Consultant" class='tab' id='Topic1.4'>Consultant Contact Information</a>
                    </li>
                    <li id="5" class="link">
                        <a href="#surgeryTraumaEmergency" class='tab' id='Topic1.5'>Surgery/Trauma/Emergency Medical
                            Phone Numbers</a>
                    </li>
                </ul>
            </div>
            <div id="#traumaActivations">
                <a href="#trauma" class="mainList" data-toggle="collapse"><i class="fa fa-book"></i> Trauma Activations
                </a>
                <ul class="collapse " id="trauma">
                    <li id="t2.1" class="link">
                        <a href="#topic2_1" class='tab ' id='Topic 2.1'>CHKD Trauma Triage Criteria</a>
                    </li>
                    <li id="t2.2" class="link">
                        <a href="#topic2_2" class='tab ' id='Topic 2.2'>Trauma Admission Protocol</a>
                    </li>
                    <li id="t2.3" class="link">
                        <a href="#topic2_3" class='tab' id='Topic 2.3'>Patient Access Technician - ED</a>
                    </li>
                    <li id="t2.4" class="link">
                        <a href="#topic2_4" class='tab' id='Topic 2.4'>CHKD Transfer Center - Kid Comm</a>
                    </li>
                    <li id="t2.5" class="link">
                        <a href="#topic2_5" class='tab' id='Topic 2.5'>Activation of the Trauma System from Scene by
                            EMS</a>
                    </li>
                    <li id="t2.6" class="link">
                        <a href="#topic2_6" class='tab' id='Topic 2.6'>Activation of the Trauma System Walk-In
                            Patients</a>
                    </li>
                    <li id="t2.7" class="link">
                        <a href="#topic2_7" class='tab' id='Topic 2.7'>Trauma Team Activation Pathway</a>
                    </li>
                    <li id="t2.8" class="link">
                        <a href="#topic2_8" class='tab' id='Topic 2.8'>Trauma/Medical Resuscitation Pre-Arrival
                            Checklist</a>
                    </li>
                    <li id="t2.9" class="link">
                        <a href="#topic2_9" class='tab' id='Topic 2.9'>Pre-Arrival/Debrief Documentation</a>
                    </li>
                    <li id="t2.10" class="link">
                        <a href="#topic2_10" class='tab' id='Topic 2.10'>Trauma Team Positioning</a>
                    </li>
                    <li id="t2.11" class="link">
                        <a href="#topic2_11" class='tab' id='Topic 2.11'>Trauma Roles</a>
                    </li>
                    <li id="t2.12" class="link">
                        <a href="#topic2_12" class='tab' id='Topic 2.12'>Pediatric Surgery Response</a>
                    </li>
                    <li id="t2.13" class="link">
                        <a href="#topic2_13" class='tab' id='Topic 2.13'>Trauma Alert Response</a>
                    </li>

                </ul>
            </div>
            <div id="#primarySurvey">
                <a href="#primarySurveyAlgo" class="mainList" data-toggle="collapse"><i class="fa fa-book"></i> Primary Survey Algorithms </a>
                <ul class="collapse " id="primarySurveyAlgo">
                    <li id="t3.1" class="link">
                        <a href="#topic3_1" class='tab ' id='Topic3.1'>Rapid Sequence Induction</a>
                    </li>
                    <li id="3.2" class="link">
                        <a href="#topic3_2" class='tab ' id='Topic3.2'>Difficult Airway Management</a>
                    </li>
                    <li id="3.3" class="link">
                        <a href="#topic3_3" class='tab' id='Topic3.3'>Emergency Department Trauma Guideline for IV
                            Access</a>
                    </li>
                    <li id="3.4" class="link">
                        <a href="#topic3_4" class='tab' id='Topic3.4'>Broselow Tape</a>
                    </li>
                    <li id="3.5" class="link">
                        <a href="#topic3_5" class='tab' id='Topic3.5'>Resuscitative/ED Thoracotomy (EDT)</a>
                    </li>
                    <li id="3.6" class="link">
                        <a href="#topic3_6" class='tab' id='Topic3.6'>Hypothermia</a>
                    </li>
                </ul>
            </div>
            <div id="#nueroTrauma">
                <a href="#neuro" class="mainList" data-toggle="collapse"><i class="fa fa-book"></i>Neurological/Spine
                    Trauma </a>
                <ul class="collapse " id="neuro">
                    <li id="t4.1" class="link">
                        <a href="#topic4_1" class='tab ' id='Topic4.1'>Pediatric and Adult Glasgow Coma Score (GCS)</a>
                    </li>
                    <li id="4.2" class="link">
                        <a href="#topic4_3" class='tab ' id='Topic4.2'>Traumatic Brain Injury</a>
                    </li>
                    <li id="4.3" class="link">
                        <a href="#topic4_3" class='tab' id='Topic4.3'>Post Stabilization Algorithm for Pediatric
                            Traumatic Brain
                            Injury</a>
                    </li>
                    <li id="4.4" class="link">
                        <a href="#topic4_4" class='tab' id='Topic4.4'>Isolated Mild Head Injury</a>
                    </li>
                    <li id="4.5" class="link">
                        <a href="#topic4_5" class='tab' id='Topic4.4'>Mild Head Injury with Post-Traumatic Seizures</a>
                    </li>
                    <li id="4.6" class="link">
                        <a href="#topic4_6" class='tab' id='Topic4.4'>Headache/Persistent Vomiting After Mild Closed
                            Head
                            Trauma</a>
                    </li>
                    <li id="4.7" class="link">
                        <a href="#topic4_7" class='tab' id='Topic4.4'>Cervical Spine Injury & Clearance</a>
                    </li>
                    <li id="4.8" class="link">
                        <a href="#topic4_8" class='tab' id='Topic4.4'>Thoracic/Lumbar/Sacral Spine Injury &
                            Clearance</a>
                    </li>
                    <li id="4.9" class="link">
                        <a href="#topic4_9" class='tab' id='Topic4.4'>Guidelines for Inpatient Care of Child with Spinal
                            Cord
                            Injury</a>
                    </li>
                    <li id="4.10" class="link">
                        <a href="#topic4_10" class='tab' id='Topic4.4'>Cervical Collar Sizing Guide</a>
                    </li>
                    <li id="4.11" class="link">
                        <a href="#topic4_11" class='tab' id='Topic4.4'>Standard Neurological Classification of Spinal
                            Cord
                            Injury</a>
                    </li>

                </ul>
            </div>
            <div id="#penetratingTrauma">
                <a href="#penetrating" class="mainList" data-toggle="collapse"><i class="fa fa-book"></i> Penetrating
                    Trauma </a>
                <ul class="collapse " id="penetrating">
                    <li id="t5.1" class="link">
                        <a href="#topic5_1" class='tab ' id='Topic5.1'>Penetrating Cardiac Injury</a>
                    </li>
                    <li id="5.2" class="link">
                        <a href="#topic5_2" class='tab ' id='Topic5.2'>Penetrating Chest Trauma</a>
                    </li>
                    <li id="5.3" class="link">
                        <a href="#topic5_3" class='tab' id='Topic5.3'>Penetrating Neck Trauma</a>
                    </li>
                    <li id="5.4" class="link">
                        <a href="#topic5_4" class='tab' id='Topic5.4'>Transmediastinal Gunshot Wounds</a>
                    </li>
                    <li id="5.5" class="link">
                        <a href="#topic5_5" class='tab' id='Topic5.5'>Truncal Stab Wounds</a>
                    </li>
                    <li id="5.6" class="link">
                        <a href="#topic5_6" class='tab' id='Topic5.6'>Abdominal Stab Wounds</a>
                    </li>
                </ul>
            </div>
            <div id="#bluntTrauma">
                <a href="#blunt" class="mainList" data-toggle="collapse"><i class="fa fa-book"></i>Blunt Trauma </a>
                <ul class="collapse " id="blunt">
                    <li id="t6.1" class="link">
                        <a href="#topic6_1" class='tab ' id='Topic6.1'>Blunt Cerebrovascular Injuries (BCVI)</a>
                    </li>
                    <li id="6.2" class="link">
                        <a href="#topic6_2" class='tab ' id='Topic6.2'>Blunt Aortic Injuries (BAI)</a>
                    </li>
                    <li id="6.3" class="link">
                        <a href="#topic6_3" class='tab' id='Topic6.3'>Blunt Cardiac Injuries (BCI)</a>
                    </li>
                    <li id="6.4" class="link">
                        <a href="#topic6_4" class='tab' id='Topic6.4'>Blunt Chest Trauma</a>
                    </li>
                    <li id="6.5" class="link">
                        <a href="#topic6_5" class='tab' id='Topic6.5'>Blunt Liver & Splenic Injury</a>
                    </li>
                    <li id="6.6" class="link">
                        <a href="#topic6_6" class='tab' id='Topic6.6'>Pancreatic Injury</a>
                    </li>
                    <li id="6.7" class="link">
                        <a href="#topic6_7" class='tab' id='Topic6.6'>Renal Trauma</a>
                    </li>
                    <li id="6.8" class="link">
                        <a href="#topic6_8" class='tab' id='Topic6.6'>Blunt Bowel & Mesenteric Injury</a>
                    </li>
                    <li id="6.9" class="link">
                        <a href="#topic6_9" class='tab' id='Topic6.6'>Blunt Abdominal Injury (Level 1 and 2)</a>
                    </li>
                    <li id="6.10" class="link">
                        <a href="#topic6_10" class='tab' id='Topic6.6'>Rectal Injury</a>
                    </li>
                    <li id="6.11" class="link">
                        <a href="#topic6_11" class='tab' id='Topic6.6'>Unstable Pelvic Fractures</a>
                    </li>
                </ul>
            </div>
            <div id="#otherIssues">
                <a href="#other" class="mainList" data-toggle="collapse"><i class="fa fa-book"></i>Other Issues </a>
                <ul class="collapse " id="other">
                    <li id="t7.1" class="link">
                        <a href="#topic7_1" class='tab' id='Topic7.1'>Pediatric Peripheral Vascular Trauma</a>
                    </li>
                    <li id="7.2" class="link">
                        <a href="#topic7_2" class='tab' id='Topic7.2'>Extremity Compartment Syndrome</a>
                    </li>
                    <li id="7.3" class="link">
                        <a href="#topic7_3" class='tab' id='Topic7.3'>Mangled Extremity</a>
                    </li>
                    <li id="7.4" class="link">
                        <a href="#topic7_4" class='tab' id='Topic7.4'>Pediatric Trauma Score</a>
                    </li>
                    <li id="7.5" class="link">
                        <a href="#topic7_5" class='tab' id='Topic7.5'>Injury Severity Scoring</a>
                    </li>
                    <li id="7.6" class="link">
                        <a href="#topic7_6" class='tab' id='Topic7.6'>Organ Grading Scale</a>
                    </li>
                </ul>
            </div>
            <div id="#burnssection">
                <a href="#burns" class="mainList" data-toggle="collapse"><i class="fa fa-book"></i>Burns </a>
                <ul class="collapse " id="burns">
                    <li id="t8.1" class="link">
                        <a href="#topic8_1" class='tab ' id='Topic8.1'>Burn Evaluation</a>
                    </li>
                    <li id="8.2" class="link">
                        <a href="#topic8_2" class='tab ' id='Topic8.2'>Transfer to Shriners</a>
                    </li>
                    <li id="8.3" class="link">
                        <a href="#topic8_3" class='tab' id='Topic8.3'>Electrical Injury</a>
                    </li>
                    <li id="8.4" class="link">
                        <a href="#topic8_4" class='tab' id='Topic8.4'>Inhalation Injury</a>
                    </li>
                    <li id="8.5" class="link">
                        <a href="#topic8_5" class='tab' id='Topic8.5'>Burn Care Power Plan</a>
                    </li>
                    <li id="8.6" class="link">
                        <a href="#topic8_6" class='tab' id='Topic8.6'>Acute Burn Wound Care</a>
                    </li>
                </ul>
            </div>
            <div id="#specialissues">
                <a href="#splissues" class="mainList" data-toggle="collapse"><i class="fa fa-book"></i>Special Issues
                </a>
                <ul class="collapse " id="splissues">
                    <li id="t10.1" class="link">
                        <a href="#topic10_1" class='tab ' id='Topic10.1'>PICU Care & Collaboration</a>
                    </li>
                    <li id="10.2" class="link">
                        <a href="#topic10_2" class='tab ' id='Topic10.2'>Acute Care Phase</a>
                    </li>
                    <li id="10.3" class="link">
                        <a href="#topic10_3" class='tab' id='Topic10.3'>Child Abuse & Neglect</a>
                    </li>
                    <li id="10.4" class="link">
                        <a href="#topic10_4" class='tab' id='Topic10.4'>I-Stat Use Critical Trauma (IO)</a>
                    </li>
                    <li id="10.5" class="link">
                        <a href="#topic10_5" class='tab' id='Topic10.5'>CT Contrast Infusion via Intraosseous Line</a>
                    </li>
                    <li id="10.6" class="link">
                        <a href="#topic10_6" class='tab' id='Topic10.6'>Protocol for Inpatient Procedures Under
                            Anesthesia</a>
                    </li>
                    <li id="10.7" class="link">
                        <a href="#topic10_7" class='tab' id='Topic10.7'>CT Downtime Trauma Algorithm</a>
                    </li>
                    <li id="10.8" class="link">
                        <a href="#topic10_8" class='tab' id='Topic10.8'>Team Roles During CT Downtime</a>
                    </li>
                    <li id="10.9" class="link">
                        <a href="#topic10_9" class='tab' id='Topic10.9'>Helmet Removal Process</a>
                    </li>
                    <li id="10.10" class="link">
                        <a href="#topic10_10" class='tab' id='Topic10.10'>DVT Prophylaxis</a>
                    </li>
                    <li id="10.11" class="link">
                        <a href="#topic10_11" class='tab' id='Topic10.11'>Massive Transfusion Protocol</a>
                    </li>
                    <li id="10.12" class="link">
                        <a href="#topic10_12" class='tab' id='Topic10.12'>Angioembolization at SNGH</a>
                    </li>
                    <li id="10.13" class="link">
                        <a href="#topic10_13" class='tab' id='Topic10.13'>Pregnant Patients</a>
                    </li>
                    <li id="10.14" class="link">
                        <a href="#topic10_14" class='tab' id='Topic10.14'>Family Presence in the Trauma Bay</a>
                    </li>
                    <li id="10.15" class="link">
                        <a href="#topic10_15" class='tab' id='Topic10.15'>Rehabilitation Services Consultation</a>
                    </li>
                    <li id="10.16" class="link">
                        <a href="#topic10_16" class='tab' id='Topic10.16'>Chain of Evidence Procedure</a>
                    </li>
                    <li id="10.17" class="link">
                        <a href="#topic10_17" class='tab' id='Topic10.17'>Disaster Management Plan</a>
                    </li>
                    <li id="10.18" class="link">
                        <a href="#topic10_18" class='tab' id='Topic10.18'>Facility Lock Down Procedure</a>
                    </li>
                </ul>
            </div>
        </div>

        <div id="mainContent" class="content">
            <div id="overlay" onclick="closeNav()"></div>
            <!-- nav bar -->
            <div class="fixedNav">
                <button class="openbtn" onclick="" style="margin-right: 1500px;"><i class="fa fa-bars" style="margin-right: 20px;"></i><img
                        src="./images/chkdIcon.png" alt="Trauma Org Chart" style="margin-right: 20px;" width="50" height="50"></button>
            </div>
            <div> 
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <!-- </div>
                <button class="add-button"> Add to Desktop</button>
                <form class="searchFormInputField">
                    <div class="input-group" style="margin: 7px 15px 15px 12px;width:250px">
                    <div id="wrapper">
                    </div>
                </form>
            </div> -->
            <div class="container h-100">
        <div class="d-flex h-100 text-center align-items-center">
            <div class="w-100 mg-top-200px">
                <h1 class="animationHeading" id="questionHeader">Thank you ! Your device information
                    has been successfully collected.
                </h1>
            </div>
        </div>
    </div>
                

                
    </div>
    

</body>

</html>
