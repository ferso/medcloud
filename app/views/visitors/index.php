<?php
	//print_r($users);  
?>


<div class="page-header">
  <h1>Visitantes<!--  <small>Subtext for header</small> --></h1>
  <!-- <button type="button" id="btNewUser" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo</button> -->
  <div class="" id="alertFlag"></div>
</div>

<div class="row">
<div class="panel panel-default">
		  <div class="panel-body">
		   
		<!-- Form -->
		<div class="col-md-4 hide">			
			<form id="userForm" action="/users/save" role="form" method="post">
			  <input id="user_id" name="id" type="hidden" value="0">
			  <div class="form-group">
			    <label for="inputName">Nombre</label>
			    <input type="text" name="user_fullname" class="form-control" id="user_fullname" placeholder="Enter Name" required>
			  </div>
			  <div class="form-group">
			    <label for="inputEmail">Correo Electrónico</label>
			    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
			  </div>
			  <div class="form-group">
			    <label for="inputArea">Área</label>
			    <select name="area_id" id="area_id" class="form-control" required>
			    	<option value="#">Selecciona una División</option>
			    	<option value="1">Investigación</option>
			    	<option value="2">Ingenieria</option>
			    </select>
			  </div>

			    <div class="form-group">
			    <label for="inputRole">Rol</label>
			    <select name="role_id" id="role_id" class="form-control" required>			    				    	
			    	<option value="3">Usuario</option>
					<option value="2">Administrador</option>	
			    	<option value="1">Root</option>
			    </select>
			  </div>

			  <div class="form-group">
			    <label for="exampleInputPassword1">Password</label>
			    <input type="password" name="password" id="password" class="form-control" id="inputPassword" placeholder="Password" disabled required>
			  </div>			 
			  <div class="checkbox">
			    <label>
			      <input type="checkbox"> Enviar password
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


			  <button type="submit" class="btn  btn-success "><span class="glyphicon glyphicon-save"></span> Guardar Usuario</button>
			  
			  <button type="button" id="btDeleteUser" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Eliminar</button>

			</form>


		</div>

		<!-- Table -->
		<div class="col-md-12 ">
			<div id="lists" class="thePadding "></div>
		</div>

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

//btDeleteUser action button
$('#btDeleteUser').click(function(){
	if(confirm('Realmente desea eliminar el usuario seleccionado?')){
		$.post('/users/delete/'+window.userid,function(o){
			if(typeof( o.error ) != 'undefined' ) {
				$('#alertFlag').addClass('alert alert-danger alert-dismissable').html('<span class="glyphicon glyphicon-exclamation-sign"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 	Existió un problema y el usuario no fué eliminado!' )			
			}else{
				window.clearStage();
				$('#alertFlag').addClass('alert alert-success alert-dismissable').html('<span class="glyphicon glyphicon-ok-circle"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Usuario ha sido eliminado!');
			}
		});
	}

});


//clear all stage to reset
window.clearStage = function(){
	window.userid = 0;
	$('#user_id').val(0);
	document.getElementById('userForm').reset();	
	window.listTable.theLoad();
}

//controlling submit form 
$('#userForm').submit(function(e){

	$('#alertFlag').removeClass();
	var theForm = document.getElementById('userForm');
	if( window.userid === null ){	
		$('#user_id').val(0);
	}else{
		$('#user_id').val(window.userid);
	}
	
	try{
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
			return false;				
		});

		request.fail(function( jqXHR, textStatus ) {		
			$('#alertFlag').addClass('alert alert-danger alert-dismissable').html('<span class="glyphicon glyphicon-exclamation-sign"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 	Existió un problema y el usuario no fué guardado!' )			
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
     source:'/visitors/table',
     rows:8,
     searcher:true,     
     primary:'_id',
     headers : [{db:null,name:'',classname:'center',width:'10%',valueFunction:function(){

     				return '<span class="glyphicon glyphicon-user"></span>';
     			}},
     			{db:'user_fullname',name:'Nombre',classname:'left',width:'40%',linkin : function(doc){
 					 $.get('/users/' + doc.id,function(response){
 					 		//reset userid from window 
 					 		window.userid = null;
 					 		if(response.error){
 					 			alert(response.message);
 					 		}else{
 					 			$('#user_fullname').val( response.user_fullname);
 					 			$('#area_id').val( response.area_id);
 					 			$('#role_id').val( response.role_id); 					 			
 					 			$('#user_status').val( response.user_status); 
 					 			$('#email').val( response.email);
 					 			$('#btDeleteUser').show();
 					 			window.userid =  response.id;

 					 		}
 					 });
                     return document.location.href = 'javascript:void(null)';                       
                 }},
                {db:'apt_start',name:'Fecha de visita',classname:'left',width:'20%'},                 
     			{db:'area_name',name:'Área visitada',classname:'left',width:'20%',valueFunction:function(o){
     					return o = o == null ? '' : o;
     					//return '<span class="label label-primary">'+o+'</span>'
     			}}],
        onCompleteRequest : function(){
        	var that = this;
        	$('.chkbox').click(function(){
        		var checks = that.getAllCheckRows();
        		if( checks.length > 0 ){
        			$('#selectListActionBox button').removeAttr("disabled");            			
        		}else{
        			$('#selectListActionBox button').attr("disabled", "disabled");
        		}
        	});
        	$('#listContainer').show();
        	$('#loader').hide();
        }
 });

</script>