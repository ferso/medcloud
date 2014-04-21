 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqOIrqHYpTG3TckCusn0EMzTiRqoWQ7qQ&sensor=false"></script>

<div class="page-header">
  <h1><span class="glyphicon glyphicon-th-list"></span> Pacientes<!--  <small>Subtext for header</small> --></h1>
  <button type="button" id="btNewUser" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo</button>
  <div class="" id="alertFlag"></div>
</div>


<div class="panel panel-default">

		<div class="panel-body">		 
		<!-- Form -->
		<div class="col-md-5">		

			<!-- Tab  -->
			<ul class="nav nav-tabs">
			  <li class="active"><a href="#home" data-toggle="tab">General</a></li>
			  <li><a href="#location" data-toggle="tab">Localización</a></li>
			  <li><a href="#profile" data-toggle="tab">Pérfil</a></li>
			  <li><a href="#history" data-toggle="tab" id="tab_history">Historial</a></li>
			</ul>


			<form id="userForm" action="/users/save" role="form" method="post">

			<input id="user_id" name="id" type="hidden" value="0" readonly="true">
			<input id="role_id" name="role_id" type="hidden" value="4">
			<input id="user_status" name="user_status" type="hidden" value="1">
			 
			<!-- Tab panes -->
			<div class="tab-content">

			  <div class="tab-pane fade in active" style="position:relative" id="home">
			  		 <div class="form-group" id="inputUUID">
					    <label for="inputUUID">ID</label>
					    <input id="user_uuid" name="user_uuid"  class="form-control" type="text" value="0" readonly="true">
					  </div>

					  <div class="form-group">
					    <label for="inputEmail">Correo Electrónico</label>
					    <input type="email" name="email" class="form-control" id="email" placeholder="Agregar email" >
					  </div>

					  <div class="form-group">
					    <label for="inputName">Nombre</label>
					    <input tabindex="1" type="text" name="user_fullname" class="form-control" id="user_fullname" placeholder="Agregar Nombre" required>
					  </div>

					  <div class="form-group">
					    <label for="inputName">Código Interno</label>
					    <input type="text" name="user_code" class="form-control" id="user_code" placeholder="Código Interno" >
					  </div>
					  
					  

					   <div class="form-group">
					    <label for="inputPhone">Telefóno Casa</label>
					    <input type="text" name="user_phone" class="form-control" id="user_phone" placeholder="Agregar número fijo" >
					  </div>

					  <div class="form-group">
					    <label for="inputMobile">Telefóno Celular</label>
					    <input type="text" name="user_mobile" class="form-control" id="user_mobile" placeholder="Agregar número móvil" >
					  </div>

					
			  </div>	

			
			  <div class="tab-pane fade" id="location">
			  	  <div class="form-group">
				    <label for="inputZip">Código Postal</label>
				    <input type="text" name="user_zip" class="form-control" id="user_zip" placeholder="Código Postal" >
				   </div>

				  <div class="form-group">
				    <label for="inputAddress1">Calle y Número</label>
				    <input type="text" name="user_street" class="form-control" id="user_street" placeholder="Dirección" >
				  </div>

				  <div class="form-group">
				    <label for="inputAddress2">Colonia</label>
				    <input type="text" name="user_neighbor" class="form-control" id="user_neighbor" placeholder="Colonia" readonly="true">
				  </div>


				   <div class="form-group">
				    <label for="inputAddress4">Delegación</label>
				    <input type="text" name="user_sublocality" class="form-control" id="user_sublocality" placeholder="Delegación" readonly="true">
				   </div>

				    <div class="form-group">
				    <label for="inputAddress5">Ciudad</label>
				    <input type="text" name="user_locality" class="form-control" id="user_locality" placeholder="Ciudad" readonly="true">
				   </div>

				    <div class="form-group">
				    <label for="inputAddress1">Estado</label>
				   <input type="text" name="user_state" class="form-control" id="user_state" placeholder="Estado" readonly="true" >		    
				   </div>

				   <div class="form-group">
				    <label for="inputAddress1">País</label>
				    <input type="text" name="user_country" class="form-control" id="user_country" placeholder="País" readonly="true" >		    	    
				   </div>
			  </div>

			    <div  class="tab-pane fade" id="profile">
			  	  <!--  <div class="form-group">
				    <label for="inputArea">Relacionado con padecimiento:</label>
				    <select name="disease_id" id="disease_id" class="form-control" >
				    	<option value="0">Selecciona</option>		    	
				    </select> 
				  </div>	 -->	

				
			  </div>


			   <div class="tab-pane fade" id="history">
			   </div>

			</div>
	
			  <button type="submit" id="btSubmitUser" class="btn  btn-success "><span class="glyphicon glyphicon-check "></span> Guardar Usuario</button>			  
			  <button type="button" id="btDeleteUser" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Eliminar</button>
			</form>

		</div>

		<!-- Table -->
		<div class="col-md-7 ">
			<div id="lists" class="thePadding "></div>
		</div>

		  </div>
		</div>

<script type="text/javascript">
	

//geoencoder init	
var geocoder, map;	
geocoder = new google.maps.Geocoder();


//reset userid stage
window.userid = 0;

$('#user_zip').blur(function(){
	window.getAddress( $(this).val() );
});

//hide delete button
$('#inputUUID').hide();
$('#btDeleteUser').hide();
$('#tab_history').hide();

//btNewUser action button
$('#btNewUser').click(function(){
	window.location.href = '/patients';
});

$('#enablePassword').click(function(){

	if(this.checked){
		$('#password').prop('disabled', false);
	}else{
		 $('#password').prop('disabled', true);
	}

});

//btDeleteUser action button
$('#btDeleteUser').click(function(){
	if(confirm('Realmente desea eliminar el usuario seleccionado?')){
		$('#btDeleteUser').html('<span class="glyphicon glyphicon-remove-sign icon-loader"></span> Eliminando...').prop("disabled",true);

		$.post('/users/delete/'+window.userid,function(o){
			if(typeof( o.error ) != 'undefined' ) {
				$('#alertFlag').addClass('alert alert-danger alert-dismissable').html('<span class="glyphicon glyphicon-exclamation-sign"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 	Existió un problema y el usuario no fué eliminado!' )			
			}else{
				window.clearStage();
				$('#alertFlag').addClass('alert alert-success alert-dismissable').html('<span class="glyphicon glyphicon-ok-circle"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Usuario ha sido eliminado!');
			}			
			window.clearStage();			
			$('#btDeleteUser').html('<span class="glyphicon glyphicon-remove-sign "></span> Eliminar').prop("disabled",false);
		});
	}

});


//clear all stage to reset
window.clearStage = function(){
	window.userid = 0;
	$('#user_id').val(0);
	$('#password').prop('disabled', true);
	$('#tab_history').hide();
	document.getElementById('userForm').reset();	
	window.listTable.theLoad();
}

//controlling submit form 
$('#userForm').submit(function(e){	

	$('#btSubmitUser').html('<span class="glyphicon glyphicon-check icon-loader"></span> Guardando Información').prop("disabled",true);

	$('#alertFlag').removeClass();
	var theForm = document.getElementById('userForm');
	if( window.userid === null ){	
		$('#user_id').val(0);
	}else{
		$('#user_id').val(window.userid);
	}
	
	try{
		var user_fullname = $('#user_fullname').val();
		var email         = $('#email').val();
		var password      = $('#password').val(); 

		if( user_fullname.length < 2 || email.length < 2   ){

			if(user_fullname.length < 4){
				$('#user_fullname').parent().addClass('has-error');
			}
			if(email.length < 4){
				$('#email').parent().addClass('has-error');
			}
			
			return false;
		}

		if(  $('#password').prop('disabled') == 'false' && 	password.length < 2 ){
			if(password.length < 6){
				$('#password').parent().addClass('has-error');
			}
			return false;
		}

		var data = $( this ).serialize();
		var request = $.ajax({
		url: "/users/save",
			type: "POST",
			data: data,
			dataType: "json"
		});
		request.done(function( response ) {
			if( typeof(response.error) != 'undefined' ){
				$('#alertFlag').addClass('alert alert-danger alert-dismissable').html('<span class="glyphicon glyphicon-exclamation-sign"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 	Existió un problema y el usuario no fué guardado! ' + response.data )			
			}else{
				$('#alertFlag').addClass('alert alert-success alert-dismissable').html('<span class="glyphicon glyphicon-ok-circle"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Usuario ha sido guardado correctamente!');			
				window.clearStage();			
			}
			$('#btSubmitUser').html('<span class="glyphicon glyphicon-check"></span> Guardar Usuario').prop("disabled",false);
			return false;				
		});

		request.fail(function( jqXHR, textStatus ) {		
			$('#alertFlag').addClass('alert alert-danger alert-dismissable').html('<span class="glyphicon glyphicon-exclamation-sign"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 	Existió un problema y el usuario no fué guardado!' )			
			$('#btSubmitUser').html('<span class="glyphicon glyphicon-check"></span> Guardar Usuario').prop("disabled",false);
			return false;
		});

	}catch(e){
		return false;
	}
	return false;
});


window.listTable = $('#lists').Table({         
     id : 'lists',
     width : '100%',
     title : 'Lista',
     source:'/patients/table',
     rows:8,
     searcher:true,
     // sortable:true,	
     primary:'_id',
     headers : [{db:'user_fullname',name:'Nombre',classname:'left',width:'40%',linkin : function(doc){
 					 $.get('/users/get/' + doc.id,function(response){
 					 		//reset userid from window 
 					 		window.userid = null;
 					 		if(response.error){
 					 			alert(response.message);
 					 		}else{ 					 			
				 				for( x in response ){
				 					$('#'+x).val(response[x]);
				 				}
				 				$('#inputUUID').show();
				 				$('#tab_history').show();
 					 			$('#btDeleteUser').show();
 					 			window.userid =  response.id;
 					 		}
 					 });
                     return document.location.href = 'javascript:void(null)';                       
                 }}, 
                {db:'disease_id',name:'Padecimiento',classname:'left',width:'40%'},  
                {db:'date',name:'Última visita',classname:'left',width:'40%'},     		     				
     			],
        onCompleteRequest : function(){
        
        }
 });


window.getAddress = function(zip) {	

	  var locality    = false;
	  var sublocality = false;

	  $('#user_country').val('');
	  $('#user_sublocality').val('');
	  $('#user_locality').val('');
	  $('#user_neighbor').val('');
	  $('#user_state').val('');

	  geocoder.geocode( { 'address': zip+'+MX'}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {
	    	var geo = results[0].address_components;
	    		for( x in geo ){	    			
	    			var type = geo[x].types[0];
	    			switch( type ){
	    				case 'country':
	    					$('#user_country').val( geo[x].long_name);  
	    				break;	    				
	    				case 'sublocality':
	    					$('#user_sublocality').val( geo[x].long_name );	    					
	    				break;
	    				case 'locality':
	    					$('#user_locality').val( geo[x].long_name );
	    				break;
	    				case 'neighborhood':
	    					$('#user_neighbor').val( geo[x].long_name);  
	    				break;
	    				case 'administrative_area_level_1':
	    					$('#user_state').val( geo[x].long_name);  
	    				break;
	    			}
	    		}	    
	    } else {
	      alert('Geocode was not successful for the following reason: ' + status);
	    }
	  });
}

window.clearStage();

</script>