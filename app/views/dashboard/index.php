<div class="page-header">
  <h1>Dashboard<!--  <small>Subtext for header</small> --></h1>
</div>


<script type="text/javascript">
		
	$.get('/dashboard/report',function(response){

		$('#appointments').html(response[0].appoitnments);
		$('#cancelleds').html(response[0].cancelleds);
		$('#users').html(response[0].users);
		$('#visitors').html(response[0].visitors);

	})		

</script>

