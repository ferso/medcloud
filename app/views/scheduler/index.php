
<div class="page-header">
  <h1><span class="glyphicon glyphicon-dashboard"></span> <?php echo $account_name; ?><!--  <small>Subtext for header</small> --></h1>
</div>


<div class="row">
	<div class="col-md-3">
	
		<div class="panel panel-default panel-dash">
		  <div class="panel-heading">Citas </div>
		  <div class="panel-body" id="appointments">
		    0
		  </div>
		</div>

	</div>
	<div class="col-md-3">
	
		<div class="panel panel-default panel-dash">
		  <div class="panel-heading">Citas Canceladas </div>
		  <div class="panel-body" id="cancelleds">
		    0
		  </div>
		</div>

	</div>

	<div class="col-md-3">
	
		<div class="panel panel-default panel-dash">
		  <div class="panel-heading">Pacientes</div>
		  <div class="panel-body" id="visitors">
		    0
		  </div>
		</div>

	</div>

		<div class="col-md-3">
	
		<div class="panel panel-default panel-dash">
		  <div class="panel-heading">Usuarios</div>
		  <div class="panel-body" id="users">
		    0
		  </div>
		</div>

	</div>


</div>

<div class="row color-guide">
	<div class="col-xs-offset-2 col-xs-2">
		<div class="square active"></div> Activas
	</div>
	<div class="col-xs-2">
		<div class="square passed"></div> Pasadas
	</div>
	<div class="col-xs-2">
		<div class="square ended"></div> Finalizadas
	</div>
	<div class="col-xs-2">
		<div class="square canceled"></div> Canceladas
	</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Crear un Evento</h4>
      </div>
      <div class="modal-body">
       	
      	<form id="formEvent">
      	<input type="hidden" name="user_id" id="user_id" value="0">
      	<input type="hidden" name="fmode" id="fmode" value="create">
      	<div class="form-group"><label for="inputArea">Asunto</label><input class="form-control" name="subject" value="" id="apt_subject"></div>
<div class="form-group"><label for="inputArea">Reunión con: </label>
	<select id="host_id" name="host_id" class="form-control">
	</select>
</div>	
<div class="form-group">
	<label for="inputArea">Nombre del Visitante</label>
	<input class="form-control" name="name" id="apt_guest_name" value="" autocomplete="off" data-provide="typeahead">
</div>	
<div class="form-group">
	<label for="inputArea">Comentarios</label>
	<textarea class="form-control" name="apt_comments" id="apt_comments"></textarea>
</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Close</button>
        <button type="button" id="btSaveApt" class="btn btn-primary"><span class="glyphicon glyphicon-check"></span> Guardar </button>
      </div>
    </div>
  </div>
</div>


		<div class="panel panel-default">
		  <div class="panel-body" >
		  
<div id="calendar"></div>

  </div>
</div>
<script>
	//role type
window.usertype = <?php echo $usertype; ?>;


		
$(document).ready(function() {

	//initial date
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	//calendar instanced
	calendar = $('#calendar').fullCalendar({		
		header: {
			left: 'prev,next, today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},		
		minTime: 9,
		maxTime: 21,
		theme: false,
		height: 650,
		events: "/scheduler/events",		
		timeFormat: '',
		allDaySlot:false,
		// defaultView: 'agendaWeek',
		editable: ( window.usertype == 1 || window.usertype == 3 ) ? false : true,
		selectable: ( window.usertype == 1 || window.usertype == 3 )  ? false : true,
		selectHelper: ( window.usertype == 1 || window.usertype == 3 )  ? false : true,
		  // Convert the allDay from string to boolean
		eventRender: function(event, element, view) {
			var status = parseInt(event.status);	  

		    switch(status){		    	
		    	case 2:
		    		element.addClass("finished");
		    	break;
		    	case 3:		    		
		    		element.addClass("canceled");
		    	break;
		    	default:
		    		
		    		 if (event.start.getTime() < date.getTime()){
				    	element.addClass("old");
				    }else{
				    	element.addClass("normal");
				    }
		    	break;
		    }	 
	    },
		select: function(start,end, allDay) {
			//form mode 
			$('#fmode').val('create');
			//timestamp
			window.startlocal  = start;
			window.endlocal	   = end;
			window.start  	   = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
			window.end         = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
			window.allDay      = false;			
			//finally.
			window.loadWindow(function(subject,id){				
				calendar.fullCalendar('renderEvent',{
					title:subject,
					id:id,
					start: window.endlocal,
					end: window.endlocal,
					allDay:false
					}		
				);				
			});
			calendar.fullCalendar('unselect');
		},		
		eventClick: function(calEvent, jsEvent, view) {	
			//form mode 
			$('#fmode').val('update');			
			window.subject     = calEvent.title;
			window.aptid 	   = calEvent.id;
			window.startlocal  = calEvent.start;
			window.endlocal	   = calEvent.end;
			window.allDay      = calEvent.allDay;
			window.start       = $.fullCalendar.formatDate( calEvent.start, "yyyy-MM-dd HH:mm:ss");
		    window.end         = $.fullCalendar.formatDate( calEvent.end, "yyyy-MM-dd HH:mm:ss");    
		    window.apt    	   = this;

			 //load event
		    $.post('/scheduler/apt',{id:window.aptid},function(data){
		    	if( typeof(data.id) != 'undefined' ){		    	
					window.loadWindow(data,function(subject,id,status){	 	    						
						calEvent.title   = subject;		
						calEvent.status  = status;	
						calendar.fullCalendar('updateEvent',calEvent);
						//console.log(calEvent);
						calendar.fullCalendar('renderEvent',calEvent);						    
						
					});
				}else{
					alert('No se encontró el evento requerido!');
				}
				return true;	        
		    });       
		},
		eventResize: function(calEvent,dayDelta,minuteDelta,revertFunc) {
			window.subject     = calEvent.title;
			window.aptid 	   = calEvent.id;
			window.startlocal  = calEvent.start;
			window.endlocal	   = calEvent.end;
			window.allDay      = calEvent.allDay;
			window.start       = $.fullCalendar.formatDate( calEvent.start, "yyyy-MM-dd HH:mm:ss");
		    window.end         = $.fullCalendar.formatDate( calEvent.end, "yyyy-MM-dd HH:mm:ss");    
				
			window.updateAppoinment(calEvent);

    	},
		eventDrop: function(calEvent,dayDelta,minuteDelta,allDay,revertFunc) {

			window.subject     = calEvent.title;
			window.aptid 	   = calEvent.id;
			window.startlocal  = calEvent.start;
			window.endlocal	   = calEvent.end;
			window.allDay      = calEvent.allDay;
			window.start       = $.fullCalendar.formatDate( calEvent.start, "yyyy-MM-dd HH:mm:ss");
		    window.end         = $.fullCalendar.formatDate( calEvent.end, "yyyy-MM-dd HH:mm:ss");    
			window.updateAppoinment(calEvent);

   		}	
  
	});

	////////////////////////////////////////


  //save the event
  $('#btSaveApt').click(function(){
		var subject  = $('#apt_subject').val();  
        var name     = $('#apt_guest_name').val();  
        var comments = $('#apt_comments').val();  
        var guestid  = $('#user_id').val();
        var mode     = $('#fmode').val();
        var status   = $('#apt_status').length ? parseInt( $('#apt_status').val() ) : null ;
        var id       = mode == 'update' ? window.aptid : null; 
        var host     = $('#host_id').val();

	        if( subject.length < 2 ||  name.length < 2){                    	
	    	  	if( subject.length < 2 ){
	    	  		$('#apt_subject').parent().addClass('has-error');
	    	  	}
	    	    if( name.length < 2){
	    	    	$('#apt_guest_name').parent().addClass('has-error');
	    	    }
	        }else{    
	        	
	        	var data = { 
	        			id:id,
	        			mode:mode,
	        			host_id:host,
	        			apt_status:status,
	        			apt_subject:subject,
	        			apt_guest_name:name,
	        			apt_start:window.start,
	        			apt_end:window.end,
	        			apt_comments:comments,
	        			apt_guest_id:guestid
	        	}
	            //Send to Server	
	             $.ajax({
				   url: '/scheduler/create',
				   data: data,
				   type: "POST",
				   success: function(response) {			   				  
				   	$('#fmode').val('create');
				   	$('#user_id').val(0);
				   	window.callback(subject,response.id,status);					   							
				   	document.getElementById('formEvent').reset();
				   	$('#myModal').modal('hide');			   	
				   }
				});
	        }  
		});
	
	//////////////////////////////////////////////////

});
		

window.updateAppoinment = function(calEvent){
	$.post('/scheduler/apt',{id:window.aptid},function(data){
		data.apt_start = window.start;
		data.apt_end   = window.end;
		data.mode      = 'update';
		 //Send to Server	
	     $.ajax({
		   url: '/scheduler/create',
		   data: data,
		   type: "POST",
		   success: function(response) {			   				  
		   	
		   }
		});
	});	
}


window.loadWindow = function(back){

	var data 		= arguments.length == 2 ? arguments[0] : false;
	window.callback = arguments.length == 2 ? arguments[1] : arguments[0];

	$('#apt_subject').val(data.apt_subject);  
	$('#user_id').val(data.apt_guest_id);  
    $('#apt_guest_name').val(data.apt_guest_name);  
    $('#apt_comments').val(data.apt_comments);
    $('#host_id').val(data.host_id);

    if( window.usertype > 2 && data){
    	if( !$('#status_group').length ){
    		$('#formEvent').append('<div class="form-group" id="status_group"><label for="inputArea">Estatus</label> <select id="apt_status" name="apt_status" class="form-control"><option value="1">Activo</option><option value="2">Finalizado</option><option value="3">Cancelado</option></select>  </div>');
    	}
    }
	$('#myModal').modal({
	  	keyboard: false
	});
}

window.loadTypeahead = function(){

	window.userName = new Bloodhound({
	datumTokenizer: Bloodhound.tokenizers.obj.whitespace('user_fullname'),
	queryTokenizer: Bloodhound.tokenizers.whitespace,
		remote: '/scheduler/user/%QUERY'
	});
	 
	window.userName.initialize();
	 
	$('#apt_guest_name').typeahead(null, {
		name: 'user_fullname',
		minLength: 3,
	  	highlight: true,
		displayKey: 'user_fullname',
		source: window.userName.ttAdapter()
	}).on('typeahead:selected', function($e, data) {
	    $('#user_id').val(data.id);
	});	
}


window.loadHosts = function(){

	 $.ajax({
	   url: '/scheduler/hosts',			  
	   type: "get",
	   success: function(response) {			   				  
	   	  for( x in response ){
	   	  		$('#host_id').append('<option value="'+response[x].id+'">'+response[x].user_fullname+'</option>');
	   	  }	   	
	   }
	});

}

window.loadDashboard = function(){
	$.get('/dashboard/report',function(response){
		$('#appointments').html(response[0].appoitnments);
		$('#cancelleds').html(response[0].cancelleds);
		$('#users').html(response[0].users);
		$('#visitors').html(response[0].visitors);
	});
}

//load dashboard report
window.loadDashboard();
//load hosts users
window.loadHosts();
//set typehead
window.loadTypeahead();

</script>
