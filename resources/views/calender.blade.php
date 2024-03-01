<!DOCTYPE html>
<html>

<head>
    <title>Calendar</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="{{URL::to('css/bootstrap.min.css')}}" />
    <script src="{{URL::to('js/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{URL::to('css/fullcalendar.css')}}" />
    <script src="{{URL::to('js/moment.min.js')}}"></script>
    <script src="{{URL::to('js/fullcalendar.js')}}"></script>
    <script src="{{URL::to('js/popper.min.js')}}"></script>
    <script src="{{URL::to('js/bootstrap.min.js')}}"></script>
    <link rel="stylesheet" href="{{URL::to('css/font-awesome.min.css')}}">

    <style>
        .fc-sun { background-color:#ffa0a0; }
        .fc-sat { background-color:#ffa0a0; }
    </style>
</head>

<body>

    <div class="container">
        <!-- <br />
        <h1 class="text-center text-primary"><u>Calendar <i class="fa fa-cloud"></i></u></h1>
        <br /> -->
        <br/>
        <div id="calendar"></div>

    </div>
   
 <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleAdd">Add Calendar</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBodyAdd">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>User</span>
                                <select id="user" class="form-control">
                                    <option value="0">Please Select User</option>
                                    <option value="Koon">Koon</option>
                                    <option value="Mew">Mew</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>Title</span>
                                <input id="title" class="form-control"></input>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>Description</span>
                                <input id="desc" class="form-control"></input>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>Type</span>
                                <select id="type" class="form-control">
                                    <option value="0">Please Select type</option>
                                    <option value="step1">Step 1</option>
                                    <option value="step2">Step 2</option>
                                    <option value="step3">Step 3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" onclick="actionCalender('add')">Save</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="detailModal">
        <div class="modal-dialog modal-dialog-centered modal-lg" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Details of records</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody">
                    <div class="row">
                        <div class="col-sm-4 text-right">
                            <span style="font-weight: bold;">Title : </span>
                        </div>
                        <div class="col-sm-8">
                            <span id="titleCDetail"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-right">
                            <span style="font-weight: bold;">Description : </span>
                        </div>
                        <div class="col-sm-8">
                            <span id="desCDetail"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-right">
                            <span style="font-weight: bold;">Step : </span>
                        </div>
                        <div class="col-sm-8">
                            <span id="stepDetail"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>





    <script>

    var calendar;
    var startFormat;
    var endFormat;

        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            calendar = $('#calendar').fullCalendar({
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: '{{URL::to("calenders")}}',
                eventRender: function (event, element) {
                    //if (event.icon) {
                        element.find(".fc-time").html("<i class='fa fa-hospital-o'></i>")
                        element.find(".fc-title").html("<b>" + event.user + "</b>" + " (" + event.title +")");
                        element.find(".fc-content").css({ 'background-color': event.color });
                    //}
                },
                weekends: true,
                selectable: true,
                selectHelper: true,
                select: function (start, end, allDay) {
                    //var title = prompt('Event Title:');
                    var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

                    startFormat = start;
                    endFormat = end;

                    const  startStr = start.split(" ");
                    const  startSplit = startStr[0].split("-");
                    var startShow = startSplit[2] + "/" + startSplit[1] + "/" + startSplit[0];

                    $('#modalTitleAdd').html("Add Calendar : " + startShow);
                    $("#addModal").modal();

                    // if (title) {
                         
                    //var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
                    //var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');
                          
                    //     $.ajax({
                    //         url: '{{URL::to("calenders/action")}}',
                    //         type: "POST",
                    //         data: {
                    //             title: title,
                    //             start: start,
                    //             end: end,
                    //             type: 'add'
                    //         },
                    //         success: function (data) {
                    //             calendar.fullCalendar('refetchEvents');
                    //             alert("Event Created Successfully");
                    //         }
                    //     })
                    // }
                },
                editable: true,
                eventResize: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url: '{{URL::to("calenders/action")}}',
                        type: "POST",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            id: id,
                            type: 'update'
                        },
                        success: function (response) {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Updated Successfully");
                        }
                    })
                },
                eventDrop: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url: '{{URL::to("calenders/action")}}',
                        type: "POST",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            id: id,
                            type: 'update'
                        },
                        success: function (response) {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Updated Successfully");
                        }
                    })
                },

                eventClick: function (event) {

                    //var startDate = new Date(event.start).toLocaleDateString("en-US");
                    var startDate = moment(event.start).format("DD/MM/YYYY");
                    
                    $('#modalTitle').html( event.user +" : "+ startDate );
                    $('#titleCDetail').html(event.title);
                    $('#desCDetail').html(event.description);
                    $('#stepDetail').html(event.step);
                    $('#detailModal').modal();

                    // if (confirm("Are you sure you want to remove it?")) {
                    //     var id = event.id;
                    //     $.ajax({
                    //         url: '{{URL::to("calenders/action")}}',
                    //         type: "POST",
                    //         data: {
                    //             id: id,
                    //             type: "delete"
                    //         },
                    //         success: function (response) {
                    //             calendar.fullCalendar('refetchEvents');
                    //             alert("Event Deleted Successfully");
                    //         }
                    //     })
                    // }
                }
            });

        });


function actionCalender(action) {
    var user = $('#user').val();
    var desc = $('#desc').val();
    var title = $('#title').val();
    var step = $('#type').val();
    
    var startDate = startFormat;
    var endDate = endFormat;

    if(user == 0) {
        alert("please select user");
        return;
    }

    if (title == "") {
        alert("please fill in Title");
        return;
    }

    if (desc == "") {
       alert("please fill in description");
        return;
    }

    if (step == "") {
        alert("please select type");
        return;
    }



    $.ajax({
        url: '{{URL::to("calenders/action")}}',
        type: "POST",
        data: {
            title: title,
            start: startDate,
            end: endDate,
            user: user,
            desc: desc,
            step: step,
            type: 'add'
        },
        success: function (data) {
            calendar.fullCalendar('refetchEvents');
            alert("Event Created Successfully");
            $('#user').val("0");
            $('#desc').val("");
            $('#title').val("");
            $("#addModal").modal('hide');
        }
    })
}

    </script>

</body>

</html>