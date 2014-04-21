<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/assets/ico/favicon.ico">

    <title>Sistema Básico de Consultas</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

    
     <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>


  <script src="/assets/js/ztable/table.js"></script>
   <link href="/assets/js/ztable/table.css" rel="stylesheet">

    <!-- dialog bootstrap -->
    <link href="/assets/lib/dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
    <script src="/assets/lib/dialog/js/bootstrap-dialog.min.js"></script>

    <!-- Fullcalendar -->

    
    <link href='/assets/lib/fullcalendar/fullcalendar/fullcalendar.css' rel='stylesheet' />
    <link href='/assets/lib/fullcalendar/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    <script src='/assets/lib/fullcalendar/fullcalendar/jquery-ui.custom.min.js'></script>
    <script src='/assets/lib/fullcalendar/fullcalendar/fullcalendar.min.js'></script>
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,200,100,500,600,700,800' rel='stylesheet' type='text/css'>

    
    <script src='/assets/lib/typeahead/typeahead.bundle.js'></script>
    
    <!-- Custom styles for fullcalendar -->
    <link href="/assets/css/fullcalendar.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/assets/css/styles.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Sistema Básico de Consultas</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Sistema Básico de Consultas </a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li ><a href="/dashboard"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>            
            <li><a href="/patients"><span class="glyphicon glyphicon-th-list"></span> Pacientes</a></li>            
            <?php if( Auth::user()->role_id < 2 ): ?>            
            <li ><a href="/users"><span class="glyphicon glyphicon-user"></span> Usuarios</a></li>
            <li><a href="/settings"><span class="glyphicon glyphicon-th-large"></span> Cuenta </a></li>
          <?php endif; ?>
          </ul>

          <ul class="nav navbar-nav navbar-right">      
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-eye-open"></span> <?php echo Auth::user()->user_fullname; ?>
 <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a><span class="label label-success"><?php 

              switch (Auth::user()->role_id ) {
                case 1:
                  echo 'Root';
                break;
                case 2:
                  echo 'Asistente';
                break;
                case 4:
                   echo 'Host'; 
                break;                 
              }

            ?> </span></a></li>
            <li class="divider"></li>
             <li><a href="/login"><span class="glyphicon glyphicon-off"></span> Salir</a></li>
          </ul>
        </li>


        </div><!--/.nav-collapse -->


      </ul>
        

      </div>
    </div>

    <div class="container"> 
        <?php echo $content; ?>
    </div><!-- /.container -->


   

  </body>
  <script type="text/javascript">
     $(function(){
    var url = window.location.pathname;  
    var activePage = url.substring(url.lastIndexOf('/')+1);
    $('.nav li a').each(function(){  
    var currentPage = this.href.substring(this.href.lastIndexOf('/')+1);

        if (activePage == currentPage) {
          $(this).parent().addClass('active'); 
        } 
    });
  });
  </script>
</html>
