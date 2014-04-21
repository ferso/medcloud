
<div class="page-header">
  <h1>Divisiónes<!--  <small>Subtext for header</small> --></h1>
  <button type="button" id="btNewArea" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo</button>
  <div class="" id="alertFlag"></div>
</div>

<div class="row">
<div class="panel panel-default">
		  <div class="panel-body">
		 
		<!-- Form -->
		<div class="col-md-4">			
			<form id="areaForm" action="/areas/save" role="form" method="post">
			  <input id="area_id" name="id" type="hidden" value="0">
			  <div class="form-group">
			    <label for="inputName">Nombre</label>
			    <input type="text" name="area_name" class="form-control" id="area_name" placeholder="Enter Name" required>
			  </div>
			  <div class="form-group">
			    <label for="inputName">Número Telefónico de Area</label>
			    <input type="text" name="area_number" class="form-control" id="area_number" placeholder="Enter Name" >
			  </div>

			   <div class="form-group">
			    <label for="inputName">Email de Area</label>
			    <input type="email" name="area_email" class="form-control" id="area_email" placeholder="Enter Name" >
			  </div>

			  <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-check"></span> Guardar Area</button>			  
			  <button type="button" id="btDeleteArea" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Eliminar</button>

			</form>


		</div>

		<!-- Table -->
		<div class="col-md-8 ">
			<div id="lists" class="thePadding "></div>
		</div>

		  </div>
		</div>

</div>
<script type="text/javascript">

//reset userid stage
window.areaid = 0;

//hide delete button
$('#btDeleteArea').hide();

//btNewUser action button
$('#btNewArea').click(function(){
	window.location.href = '/users';
});


//btDeleteUser action button
$('#btDeleteArea').click(function(){
	if(confirm('Realmente desea eliminar el área seleccionada?')){
		$.post('/areas/delete/'+window.areaid,function(o){
			if(typeof( o.error ) != 'undefined' ) {
				$('#alertFlag').addClass('alert alert-danger alert-dismissable').html('<span class="glyphicon glyphicon-exclamation-sign"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 	Existió un problema y el área no fué eliminada!' )			
			}else{
				window.clearStage();
				window.listTable.theLoad();
				$('#alertFlag').addClass('alert alert-success alert-dismissable').html('<span class="glyphicon glyphicon-ok-circle"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Area ha sido eliminada!');
			}
		});
	}

});


//clear all stage to reset
window.clearStage = function(){
	window.areaid = 0;	
	$('#area_id').val(0);	
	$('#area_name').val('');
	document.getElementById('areaForm').reset();		
}

//controlling submit form 
$('#areaForm').submit(function(e){

	$('#alertFlag').removeClass();
	var theForm = document.getElementById('areaForm');
	if( window.areaid === null ){	
		$('#area_id').val(0);
	}else{
		$('#area_id').val(window.areaid);
	}	
	try{

		var area_name = $('#area_name').val();
		if( area_name.length  < 4 ){

			if(area_name.length < 4){
				$('#area_name').parent().addClass('has-error');
			}			
			return false;
		}

		var data = $( this ).serialize();
		var request = $.ajax({
		url: "/areas/save",
			type: "POST",
			data: data,
			dataType: "json"
		});
		request.done(function( response ) {
			if( typeof(response.error) != 'undefined' ){
				$('#alertFlag').addClass('alert alert-danger alert-dismissable').html('<span class="glyphicon glyphicon-exclamation-sign"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 	Existió un problema y el Area no fué guardada! ' + response.data )			
			}else{
				$('#alertFlag').addClass('alert alert-success alert-dismissable').html('<span class="glyphicon glyphicon-ok-circle"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Usuario ha sido guardado correctamente!');			
				window.clearStage();
				window.listTable.theLoad();				
			}
			return false;				
		});

		request.fail(function( jqXHR, textStatus ) {		
			$('#alertFlag').addClass('alert alert-danger alert-dismissable').html('<span class="glyphicon glyphicon-exclamation-sign"></span> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 	Existió un problema y el Area no fué guardada correctamente!' )			
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
     source:'/areas/table',
     rows:8,
     searcher:true,
     // sortable:true,	
     primary:'_id',
     headers : [ {db:'area_name',name:'Nombre de División',classname:'left',width:'60%',linkin : function(doc){
 					 $.get('/areas/' + doc.id,function(response){
 					 		//reset areaid from window 
 					 		window.areaid = null;
 					 		if(response.error){
 					 			alert(response.message);
 					 		}else{
 					 			$('#area_name').val( response.area_name); 					 		
 					 			$('#area_number').val( response.area_number);
 					 			$('#area_email').val( response.area_email);
 					 			$('#btDeleteArea').show();
 					 			window.areaid =  response.id;

 					 		}
 					 });
                     return document.location.href = 'javascript:void(null)';                       
                 }},
                 {db:'area_number',name:'Número',classname:'left',width:'20%',valueFunction:function(o){

                 	return '<span class="label label-success">'+o+'</span>'
                 }},
                 {db:'area_email',name:'Email',classname:'left',width:'20%'}],
        onCompleteRequest : function(){
        
        }
 });


window.clearStage();

</script>