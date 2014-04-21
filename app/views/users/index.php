<div class="page-header">
  <h1><span class="glyphicon glyphicon-user"></span> Usuarios<!--  <small>Subtext for header</small> --></h1>
  <button type="button" id="btNewUser" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo</button>
  
</div>

<div id="flagContainer">
	
</div>

<div class="panel panel-default">
		  <div class="panel-body">
		 
		<!-- Form -->
		<div class="col-md-5">		

			<!-- Tab  -->
			<ul class="nav nav-tabs">
			  <li class="active"><a href="#home" data-toggle="tab">General</a></li>
			  <li><a href="#contact" data-toggle="tab">Contacto</a></li>
			</ul>
			
			<!-- form -->
			<form id="userForm" action="/users/save" role="form" method="post">

			<!-- Tab panes -->
			<div class="tab-content">

			
			 	
			 	<div class="tab-pane fade in active" style="position:relative" id="home">				
				  <input id="user_id" name="id" type="hidden" value="0">
				  <div class="form-group">
				    <label for="inputName">Nombre</label>
				    <input type="text" name="user_fullname" class="form-control" id="user_fullname" placeholder="Enter Name" >
				  </div>
				  
				  <div class="form-group">
				    <label for="inputEmail">Correo Electrónico</label>
				    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" >
				  </div>			 
				    <div class="form-group">
				    <label for="inputRole">Nivel de acceso</label>
				    <select name="role_id" id="role_id" class="form-control" >	    	
				    </select>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputPassword1">Password</label>
				    <input type="password" name="password" id="password" class="form-control"  placeholder="Password" disabled >
				  </div>			 
				  <div class="checkbox">
				    <label>
				      <input id="enablePassword" type="checkbox"> Enviar password
				    </label>
				  </div>

				     <div class="form-group">
				    <label for="inputRole">Estatus</label>
				    <select name="user_status" id="user_status" class="form-control" required>			    				    	
				    	<option value="1">Activo</option>
						<option value="0">Inactivo</option>	
				    	<option value="2">Baneado</option>
				    </select>
				  </div>
				</div>  <!-- tab panel -->

				<div class="tab-pane fade"  id="contact">	
					<div class="form-group">
				    	<label for="inputPhone">Telefóno Casa</label>
				    	<input type="text" name="user_phone" class="form-control" id="user_phone" placeholder="Enter Phone" >
				    </div>
				    <div class="form-group">
				    	<label for="inputMobile">Telefóno Celular</label>
				    	<input type="text" name="user_mobile" class="form-control" id="user_mobile" placeholder="Enter Mobile" >
				    </div>
				</div> <!-- tab panel -->

				

			</div> <!-- tab content -->
			<button type="submit" id="btSubmitUser" class="btn  btn-success "><span class="glyphicon glyphicon-check"></span> Guardar Usuario</button>				  
			<button type="button" id="btDeleteUser" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Eliminar</button>
		
			</form>
		</div>

		<!-- Table -->
		<div class="col-md-7">
			<div id="lists" class="thePadding "></div>
		</div>

		  </div>
		</div>

<script type="text/javascript">



//reset userid stage
window.userid = 0;

//hide delete button
$('#btDeleteUser').hide();

//btNewUser action button
$('#btNewUser').click(function(){
	window.location.href = '/users';
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
				window.alertFlag('danger','Existió un problema y el usuario no fué eliminado!');
			}else{
				window.clearStage();
				$('#btDeleteUser').html('<span class="glyphicon glyphicon-remove-sign "></span> Eliminar').prop("disabled",false);
				window.alertFlag('success','Usuario ha sido eliminado!'); 				
			}
		});
	}

});


window.alertFlag = function(type,msg){
	if( $('#alertFlag').length == 0 ){		
		$('#flagContainer').html('<div class="" id="alertFlag"></div>');
	}
	if(type=='success'){		
		$('#alertFlag').addClass('alert alert-success alert-dismissable').html('<span class="glyphicon glyphicon-ok-circle"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> ' + msg);
	}
	if(type=='warn'){
		
		$('#alertFlag').addClass('alert alert-warning alert-dismissable').html('<span class="glyphicon glyphicon-exclamation-sign"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> ' + msg);
	}
	if(type=='danger'){
		$('#alertFlag').addClass('alert alert-danger alert-dismissable').html('<span class="glyphicon glyphicon-exclamation-sign"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + msg )			
	}	
}

//clear all stage to reset
window.clearStage = function(){
	window.userid = 0;
	$('#user_id').val(0);
	$('#password').prop('disabled', true);
	$('#alertFlag').remove();
	$('.has-error').removeClass('has-error');		
	document.getElementById('userForm').reset();	
	window.listTable.theLoad();
}


function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

window.validate = function(){

	var errors   	  = [];
	var user_fullname = $('#user_fullname').val();
	var email         = $('#email').val();
	var password      = $('#password').val(); 
	if( user_fullname.length < 2 || email.length < 2   ){

		if(user_fullname.length < 4){
			$('#user_fullname').parent().addClass('has-error');
			errors.push('user_fullname');
		}
		if(email.length < 4 && !validateEmail(email) ){
			$('#email').parent().addClass('has-error');
			errors.push('email');
		}
		
	}

	if(  $('#password').prop('disabled') == 'false' && 	password.length < 2 ){
		if(password.length < 6){
			$('#password').parent().addClass('has-error');
			errors.push('password');
		}		
	}

	if( errors.length == 0 ){
		return true;
	}else{
		window.alertFlag('warn','Favor de llenar todos los campos marcados!'); 				
		return false;
	}	
}

//controlling submit form 
$('#userForm').submit(function(e){
	$('#btSubmitUser').html('<span class="glyphicon glyphicon-check icon-loader"></span> Guardando Información').prop("disabled",true);	
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

		if( window.validate() ){

			var data = $( this ).serialize();
			var request = $.ajax({
			url: "/users/save",
				type: "POST",
				data: data,
				dataType: "json"
			});
			request.done(function( response ) {
				if( typeof(response.error) != 'undefined' ){
					window.alertFlag('danger','Existió un problema y el usuario no fué guardado! ' + response.data ); 					
				}else{
					window.alertFlag('success', 'Usuario ha sido guardado correctamente!');							
					window.clearStage();				
				}
				$('#btSubmitUser').html('<span class="glyphicon glyphicon-check"></span> Guardar Usuario').prop("disabled",false);
				return false;				
			});

			request.fail(function( jqXHR, textStatus ) {	
				$('#btSubmitUser').html('<span class="glyphicon glyphicon-check"></span> Guardar Usuario').prop("disabled",false);
				window.alertFlag('danger', 'Existió un problema y el usuario no fué guardado!');							
				return false;
			});

		}

	}catch(e){
		return false;
	}
	return false;
});


window.listTable = $('#lists').Table({         
     id : 'lists',
     width : '100%',
     title : 'Lista',
     source:'/users/table',
     rows:8,
     searcher:true,
     // sortable:true,	
     primary:'_id',
     headers : [{db:'user_fullname',name:'Nombre',classname:'left',width:'40%',linkin : function(doc){
     				 window.clearStage();
 					 $.get('/users/get/' + doc.id,function(response){
 					 		//reset userid from window 
 					 		window.userid = null;
 					 		if(response.error){
 					 			alert(response.message);
 					 		}else{

 					 			for(x in response){
 					 				$('#'+x).val(response[x]);
 					 			} 					 			

 					 			$('#btDeleteUser').show();
 					 			window.userid =  response.id;

 					 		}
 					 });
                     return document.location.href = 'javascript:void(null)';                       
                 }}, 
                {db:'user_uuid',name:'Clave',classname:'left',width:'30%'},
     			{db:'role_name',name:'Acceso',classname:'left',width:'20%',valueFunction:function(o){
     					return '<span class="label label-primary">'+o+'</span>'
     			}},     			
     			{db:'user_status',name:'Estatus',classname:'left',width:'10%',valueFunction:function(o){
     					var status = parseInt(o);
     					switch(status){
     						case 2:
     							return '<span class="label label-warning">Baneado</span>';
     						break;
     						case 1:
     							return '<span class="label label-success">Activo</span>';
     						break;
     						default:
     							return '<span class="label  label-danger">Inactivo</span>';
     						break;
     					}
     			}}],
        onCompleteRequest : function(){
        	// var that = this;
        	// $('.chkbox').click(function(){
        	// 	var checks = that.getAllCheckRows();
        	// 	if( checks.length > 0 ){
        	// 		$('#selectListActionBox button').removeAttr("disabled");            			
        	// 	}else{
        	// 		$('#selectListActionBox button').attr("disabled", "disabled");
        	// 	}
        	// });
        	// $('#listContainer').show();
        	// $('#loader').hide();
        }
 });


window.loadRoles = function(){

	 $.ajax({
	   url: '/users/roles',			  
	   type: "post",
	   success: function(response) {			   				  
	   	  for( x in response ){
   	  	 	if( response[x].role_key != 'user'){
   	  			$('#role_id').append('<option value="'+response[x].id+'">'+response[x].role_name+'</option>');
   	  		}
	   	  }	   	
	   }
	});
}


window.loadAreas = function(){
	//  $.ajax({
	//    url: '/areas/table',			  
	//    type: "get",
	//    success: function(response) {			   				  
	//    	  for( x in response.data ){
	//    	  		$('#area_id').append('<option value="'+response.data[x].id+'">'+response.data[x].area_name+'</option>');
	//    	  }	   	
	//    }
	// });
}

window.loadAreas();
window.loadRoles();
window.clearStage();
</script>