$(document).ready(function() {

    //* Handler calendar/modal loading
    $('#schedule_event_modal').on('show.bs.modal', function(e) {

        const modal = document.getElementById('schedule_event_modal');
        const url = './scheduleVisit.php';

        //Promise based function, after modal content is rendered
        injectModalContent(modal, url).then(function(result) {

            // let form = document.getElementById('eventForm');
            // let isEventValid = false;
            let responseObj = null;
            const objectConstructor = ({}).constructor;

            //Pull patients to populate form
            pullPatientData().then(function(response) {

                responseObj = JSON.parse(response);

                if (responseObj.constructor === objectConstructor) {
                    renderPatients(responseObj).then(function(response) {
                        //? Do anything after rendering patients?
                    }, function(error) {
                        //TODO add error handling
                    })
                } else {
                    //TODO Add actual error handling, pull error message from sql statement
                    alert("generic error.")

                }
            }, function(error) {
                //TODO add error handling
            })

            //Hide event form
            $('#createEvent').hide();

            //Hack to check if modal content is visible, as bootstrap shown event doest't work with modal fade class
            if ($(".modal-content").is(":visible")) {
                initCalendar();
            } else {
                var waitLoaded = setInterval(function() {
                    if ($(".modal-content").is(":visible")) {
                        initCalendar();
                        clearInterval(waitLoaded);
                    }
                }, 100);
            }
        }, function(error) {
            // Error if content cannot be injected into modal
            alert("Error, file could not be loaded")
        });
    });

    //Clear modal contents on hide
    $('#schedule_event_modal').on('hidden.bs.modal', function(e) {
        $('#schedule_event_modal').empty()
    })
})

function injectModalContent(element, url) {
    //Return promise
    return new Promise(function(resolve, reject) {
        jqueryObj = $(element).load(url, function(response, textStatus) {
            if (textStatus === "success") {
                resolve("success");
            } else {
                reject(Error(textStatus))
            }
        });
    })
}
//* End of calendar/modal loading




//* JS Full Calendar 
function initCalendar() {
    const calendarEl = document.getElementById('calendar');

    //Only dates in the future are valid
    // let isDateValid = false;
    let selectedDate = null;
    let startTime = null;
    let start = null;
    let end = null;
    let endTime = null;
    let formValid = false;
    let form = document.getElementById('eventForm');
    let prevClickedDate = null;
    let defaultBackgroundColor = "white";
    // let latestId = null;
    let createdEvent = {};

    let myCalendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['dayGrid', 'timeGrid', 'interaction', 'moment'],
        // defaultView: 'timeGridWeek',
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'dayGridMonth, timeGridWeek, timeGridDay'
        },
        nowIndicator: true,
        now: moment.utc().local().format("YYYY-MM-DD HH:mm"),
        timeZone: 'local',
        height: "parent",
        aspectRatio: 1,
        events: [],

        dateClick: function(info) {
            let selectedDate = info.date.toUTCString();
            //    let selectedDate = info.date.toUTCString(); Switch to ISO

            if (prevClickedDate) {
                prevClickedDate.style.backgroundColor = defaultBackgroundColor;
            }

            info.dayEl.style.backgroundColor = "rgba(0, 0, 255, .1)";
            prevClickedDate = info.dayEl;


            $('#selectedDate').val(info.dateStr);
            $('#createEvent').show();


            $('#submitEvent').off().on('click', function() {

                startTime = $('#start_time').val();
                endTime = $('#end_time').val();

                start = addDateTime(selectedDate, startTime);
                end = addDateTime(selectedDate, endTime);


                // console.log(selectedDate);
                //TODO Add validation
                // formValid = validateForm(form)

                //If form is valid
                // requestLatestId = getLatestEventID();startTime = $('#start_time').val();

                createdEvent.allDay = false;
                createdEvent.start = start;
                createdEvent.end = end;
                createdEvent.title = $('#eventTitle').val();
                createdEvent.extendedProps = {};
                createdEvent.extendedProps.participant_name = $('#selectPatient').val();
                createdEvent.extendedProps.npi_required = $('#npi_required').prop('checked');
                createdEvent.extendedProps.cmai_required = $('#cmai_required').prop('checked');
                createdEvent.extendedProps.demqol_required = $('#demqol_required').prop('checked');
                createdEvent.extendedProps.zbi_required = $('#zbi_required').prop('checked');
                createdEvent.extendedProps.comments = $('#comments').val();
                myCalendar.addEvent(createdEvent);

                // requestLatestId.then(function(response){
                //     latestId = response;
                // }, function(xhrObj){
                //     //statusText prop returns error message
                //     // console.log(xhrObj.statusText);
                // });


                submitEvent();
            })
        },
        eventClick: function(info) {
            // alert("done")
            //TODO Handle click on event here
            // change the border color just for fun
            // info.el.style.borderColor = 'red';
        },
        eventRender: function(info) {
            let startDate = info.event.start.toISOString()
            let endDate = info.event.end.toISOString()

            let start = moment(startDate);
            let end = moment(endDate);
            let startTime = start.format("h:mm a");
            let endTime = end.format("h:mm a");
            let requiredForms = "";
            let comments = info.event.extendedProps.comments;

            if (info.event.extendedProps.npi_required == 1) {
                requiredForms += " NPI";
            }
            if (info.event.extendedProps.cmai_required == 1) {
                requiredForms += " CMAI";
            }
            if (info.event.extendedProps.demqol_required == 1) {
                requiredForms += " DEMQOL-Proxy";
            }
            if (info.event.extendedProps.zbi_required == 1) {
                requiredForms += " ZBI";
            }
            if (requiredForms == "") {
                requiredForms += "None";
            }
            if (comments == "") {
                comments = "None";
            }
            console.log(info.event)

            $(info.el).qtip({
                content: {
                    title: { text: info.event.title },
                    text:
                    // '<span> Patient ID: </span> '
                    // + info.event.extendedProps.patient_id
                        '<br><span>Time Period: </span>' +
                        startTime +
                        " - " +
                        endTime +
                        '<br><span>Required Forms: </span>' +
                        requiredForms +
                        '<br><span>Comments Made: </span>' +
                        comments
                },
                position: {
                    target: 'mouse', // Track the mouse as the positioning target
                    adjust: {
                        x: 5,
                        y: 5
                    },
                    style: {
                        classes: 'qTipStyle',
                    }
                }
            });

        },
        events: {
            url: './services/calendar/get_data.php',
            type: 'POST', // Send post data
            error: function() {
                alert('There was an error while fetching events.');
            }
        }


    });

    myCalendar.render();

}

//* End of JS Calander

function addDateTime(selectedDate, time) {
    let ISOString = "";
    let splitTime = time.split(':');
    const hour = splitTime[0];
    const minutes = splitTime[1];

    selectedDate = moment(selectedDate).add(hour, 'hours');
    selectedDate = moment(selectedDate).add(minutes, 'minutes');
    ISOString = moment(selectedDate).toISOString();
    return ISOString;
}

function submitEvent() {
    let form = document.getElementById('eventForm');
    let serializedForm = $(form).serializeArray();

    // get empty checkboxes as well
    fullSerializedForm = serializedForm.concat(
        jQuery('#eventForm input[type=checkbox]:not(:checked)').map(
            function() {
                return {
                    "name": this.name,
                    "value": false
                }
            }).get()
    );

    $.ajax({
        type: 'POST',
        url: './services/calendar/form_submit.php',
        data: {
            postForm: fullSerializedForm
        }
    }).done(function(data, status) {
        if (status === "success") {
            //TODO after form submit verified
            form.reset();
            $('#createEvent').hide();
        } else {
            alert("Error, event could not be submitted");
        }
    })
}




























//Returns true if selected date is greater then current date
// function compareDates(selectedDate) {
//     const currentAsDate = moment();
//     const selectedAsDate = moment(selectedDate);

//     console.log(currentAsDate)

//     return (moment(selectedAsDate).isAfter(currentAsDate))

// }

//* Returns true/false depending on form validity
function validateForm(form) {

    if (form.checkValidity() === false) {
        // TODO add bootstrap form validation
        return false;
    } else {
        return true;
    }
}

// function getLatestEventID(){
//     let jsPromise = Promise.resolve(
//         $.ajax({
//             url: './services/calendar_handler.php',
//             data: {'getLatestId' : ''},
//             type: 'GET'
//         })       
//     )

//     return jsPromise;
// }


function pullPatientData() {
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: 'GET',
            url: './services/calendar/get_data.php',
            data: { 'pullPatientData': "" }
        }).done(function(data, status) {
            if (status === "success") {
                resolve(data);
            } else {
                reject(status);
            }
        })
    })
}

function renderPatients(responseObj) {
    const selectField = document.getElementById('selectPatient');
    const data = responseObj.patientData;

    return new Promise(function(resolve, reject) {
        for (let i = 0; i < data.length; i++) {
            let option = document.createElement('option');

            option.text = data[i].first_name + ' ' + data[i].last_name;
            option.value = data[i].patient_id;
            selectField.appendChild(option);
        }

        if (selectField.length === data.length) {
            resolve()
        } else {
            reject('Participants could not be found');
        }
    })
}