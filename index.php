<!DOCTYPE html>
<?php include('./inc/main.php'); ?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Calendar</title>
	<link rel="stylesheet" href="style.css"><!-- 1. Подключить CSS-файл Bootstrap 3 -->  
		<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

	<link rel="stylesheet" href="http://www.bootstrap-year-calendar.com/download/v1.1.0/bootstrap-year-calendar.css">
	
</head>
<body>
<div class="modal modal-fade" id="event-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
					Event
				</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="event-index">
				<form class="form-horizontal" id="form">
					<div class="form-group">
						<label for="min-date" class="col-sm-4 control-label">Любой текст</label>
						<div class="col-sm-7">
							<input name="event-name" type="text" class="validate form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label for="min-date" class="col-sm-4 control-label">Куда</label>
						<div class="col-sm-7">
							<input name="event-location" type="text" class="validate form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label for="min-date" class="col-sm-4 control-label">Телефон</label>
						<div class="col-sm-7">
							<input name="event-phone" type="text" class="validate form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label for="min-date" class="col-sm-4 control-label">Когда</label>
						<div class="col-sm-7">
							<div class="input-group input-daterange" data-provide="datepicker">
								<span class="input-group-addon">с</span>
								<input name="event-start-date" type="text" class="validate form-control" value="2012-04-05" required>
								<span class="input-group-addon">по</span>
								<input name="event-end-date" type="text" class="validate form-control" value="2012-04-19" required>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
				<button type="button" type="submit" class="btn btn-primary" id="save-event">
					Забронировать
				</button>
			</div>
		</div>
	</div>
</div>
		<br>
		<center><h1><code>Calendar</code></h1></center>
            <!-- Page Content -->
        <div class="container">
        	<h1>Бронирование даты</h1>
			<p>Тестовое задание на должность fullstack-разработчика</p>
        	<br>
             <div id="calendar"></div>
        </div>
</body>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
	<script src="http://www.bootstrap-year-calendar.com/js/respond.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
	<script src="http://www.bootstrap-year-calendar.com/js/bootstrap-datepicker.min.js"></script>
	<script src="http://www.bootstrap-year-calendar.com/download/v1.1.0/bootstrap-year-calendar.min.js"></script>
	<script src="http://www.bootstrap-year-calendar.com/js/bootstrap-popover.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

	<script type="text/javascript">
		$(function() {
		
		$('#save-event').attr('disabled', 'disabled');


		$('#form input').on('keyup blur', function () { // fires on every keyup & blur
	        if ($('#form').valid()) {                   // checks form for validity
	            $('#save-event').attr('disabled', false);        // enables button
	        } else {
	            $('#save-event').attr('disabled', 'disabled');   // disables button
	        }
	    });


		$('input[name="event-phone"]').mask('+7 (999) 999-99-99');


		function editEventAjax(eventIndex) {

			var name = $('#event-modal input[name="event-name"]').val();
			var location = $('#event-modal input[name="event-location"]').val();
			var data_start = $('#event-modal input[name="event-start-date"]').val();
			var data_end = $('#event-modal input[name="event-end-date"]').val();
			var phone = $('input[name="event-phone"]').val();

			$.ajax({
				url: './inc/main.php',
				type: 'POST',
				dataType: 'text',
				data: {idEdit: eventIndex,nameEventUpdate: name, locationUpdate: location,dataStartUpdate: data_start, dataEndUpdate: data_end, phoneUpdate: phone},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		}

		function sendAjax() {
			//var firebaseRef = firebase.database().ref();

			//firebaseRef.child("calendar").set("Some val");

		    
			var name = $('#event-modal input[name="event-name"]').val();
			var location = $('#event-modal input[name="event-location"]').val();
			var data_start = $('#event-modal input[name="event-start-date"]').val();
			var data_end = $('#event-modal input[name="event-end-date"]').val();
			var phone = $('input[name="event-phone"]').val();

			$.ajax({
				url: './inc/main.php',
				type: 'POST',
				dataType: 'text',
				data: {name: name, location: location,dataStart: data_start, dataEnd: data_end, phone: phone},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			

		}
/*
		$('.day-content').click(function(event) {
		    	var day = $(this).text();

		    	var month = $(this).parents(':eq(2)').find('.month-title').attr('colspan');
		    	
		 });
*/		

		function editEvent(event) {
		    $('#event-modal input[name="event-index"]').val(event ? event.id : '');
		    $('#event-modal input[name="event-name"]').val(event ? event.name : '');
		    $('#event-modal input[name="event-location"]').val(event ? event.location : '');
		    $('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
		    $('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');
		    $('#event-modal input[name="event-phone"]').val(event ? event.phone : '');
		    $('#event-modal').modal();


		}

		function deleteEvent(event) {
		    var dataSource = $('#calendar').data('calendar').getDataSource();
		    
		    idDelit = event.id;

		    $.ajax({
		    	url: './inc/main.php',
		    	type: 'POST',
		    	dataType: 'text',
		    	data: {idDelit: idDelit},
		    })
		    .done(function() {
		    	console.log("success");
		    })
		    .fail(function() {
		    	console.log("error");
		    })
		    .always(function() {
		    	console.log("complete");
		    });
		    

		    for(var i in dataSource) {
		        if(dataSource[i].id == event.id) {
		            dataSource.splice(i, 1);
		            break;
		        }
		    }
		    
		    $('#calendar').data('calendar').setDataSource(dataSource);
		}

		function saveEvent() {
		    var event = {
		        id: $('#event-modal input[name="event-index"]').val(),
		        name: $('#event-modal input[name="event-name"]').val(),
		        location: $('#event-modal input[name="event-location"]').val(),
		        startDate: $('#event-modal input[name="event-start-date"]').datepicker('getDate'),
		        endDate: $('#event-modal input[name="event-end-date"]').datepicker('getDate'),
		        phone: $('#event-modal input[name="event-phone"]').val()
		    }
		    
		    var dataSource = $('#calendar').data('calendar').getDataSource();

		    if(event.id) {
		        for(var i in dataSource) {
		            if(dataSource[i].id == event.id) {
		                dataSource[i].name = event.name;
		                dataSource[i].location = event.location;
		                dataSource[i].startDate = event.startDate;
		                dataSource[i].endDate = event.endDate;
		                dataSource[i].phone = event.phone;
		            }
		        }
		    }
		    else
		    {
		        var newId = 0;
		        for(var i in dataSource) {
		            if(dataSource[i].id > newId) {
		                newId = dataSource[i].id;
		            }
		        }
		        
		        newId++;
		        event.id = newId;
		    
		        dataSource.push(event);
		    }
		    
		    $('#calendar').data('calendar').setDataSource(dataSource);
		    $('#event-modal').modal('hide');
		}


		    var currentYear = new Date().getFullYear();

		    $('#calendar').calendar({ 
		        enableContextMenu: true,
		        enableRangeSelection: true,
		        contextMenuItems:[
		            {
		                text: 'Редактировать',
		                click: editEvent
		            },
		            {
		                text: 'Удалить',
		                click: deleteEvent
		            }
		        ],
		        selectRange: function(e) {
		            editEvent({ startDate: e.startDate, endDate: e.endDate });
		        },
		        mouseOnDay: function(e) {
		            if(e.events.length > 0) {
		                var content = '';
		                
		                for(var i in e.events) {
		                    content += '<div class="event-tooltip-content">'
		                                    + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
		                                    + '<div class="event-location">Куда: ' + e.events[i].location +' <br> Телефон: '+ e.events[i].phone +'</div>'
		                                + '</div>';
		                }
		            
		                $(e.element).popover({ 
		                    trigger: 'manual',
		                    container: 'body',
		                    html:true,
		                    content: content
		                });
		                
		                $(e.element).popover('show');
		            }
		        },
		        mouseOutDay: function(e) {
		            if(e.events.length > 0) {
		                $(e.element).popover('hide');
		            }
		        },
		        dayContextMenu: function(e) {
		            $(e.element).popover('hide');
		        },
		        dataSource: [
		           <?php
		           		foreach ($data as $keyEvent) {
		           			$dataEventStart = explode("/", $keyEvent['dataStart']);
		           			$month = $dataEventStart[0]-1;
		           			$day = $dataEventStart[1];
		           			$year = $dataEventStart[2];

		           			$dataEventEnd = explode("/", $keyEvent['dataEnd']);
		           			$monthEnd = $dataEventEnd[0]-1;
		           			$dayEnd = $dataEventEnd[1];
		           			$yearEnd = $dataEventEnd[2];
		           			
		           			$ipRequest = $_SERVER['REMOTE_ADDR'];
		           			$ip = $keyEvent['ip'];

		           			if($ipRequest === $ip) {
			           			print '
									{
										id: '.$keyEvent['id'].',
						                name: '.$keyEvent['event_name'].',
						                location: '.$keyEvent['location'].',
						                startDate: new Date('.$year.', '.$month.', '.$day.'),
						                endDate: new Date('.$yearEnd.', '.$monthEnd.', '.$dayEnd.'),
						                phone: "'.$keyEvent['phone'].'"
									},
			           			';
			           		}
		           		} 
		           ?>

		          
		        ]
		    });
		    
		    $('#save-event').click(function() {
			    if ($('#form').valid()) {                   // checks form for validity
		            $('#save-event').attr('disabled', false);        // enables button
		            saveEvent();

			        var eventIndex = $('input[name="event-index"]').val();

			        var lenEventIndex = eventIndex.length;

			        if(lenEventIndex > 0) {
			        	editEventAjax(eventIndex);
			        }
			        else {
			        	sendAjax();
			        }
		        } else {
		            $('#save-event').attr('disabled', 'disabled');   // disables button
		        }


		    });

		});

	</script>
</html>