<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!--FAVICON !-->

    <link rel="icon" type="image/png" sizes="32x32" href="{{URL::to('/').'/images/favicon-32x32.png'}}">

    <!--/FAVICON !-->

    <title>PROAGIL - Apoyando la agilidad de los proyectos de software</title>
	

    {{ HTML::style('bower_components/bootstrap/dist/css/bootstrap.min.css') }}
    {{ HTML::style('css/frontend/sb-admin-2.css') }}
     {{ HTML::style('css/frontend/datepicker3.css') }}
     
    {{ HTML::style('bower_components/font-awesome/css/font-awesome.min.css') }}    
    {{ HTML::style('bower_components/sweet-alert/sweet-alert.css') }}
    {{ HTML::style('css/frontend/owl.carousel.css') }}
    {{ HTML::style('css/frontend/emoticons/emoticons.css') }}
	{{ HTML::style('css/frontend/generic.css') }}
    {{ HTML::style('css/frontend/style_diagram.css') }}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        var projectURL = '<?= URL::to('/') ?>';
    </script>

</head>