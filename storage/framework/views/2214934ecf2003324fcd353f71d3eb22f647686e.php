<!DOCTYPE html>

<html lang="es-ES">

<head>

    <!-- SEO -->

    <meta name="encoding" charset="utf-8">

    <meta name="application-name" content="Stids 2.0" />

    <meta name="author" content="Grupo Stids">

    <meta name="generator" content="Laravel 5.4" />

    <meta name="robots" content="index, follow" />

    <?php echo $__env->yieldContent('meta-seo'); ?>  

    <!-- Fin SEO -->

    <title>Stids S.A.S</title>

    <link href="<?php echo e(asset('temas/stids/css/bootstrap.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('temas/stids/css/font-awesome.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('temas/stids/css/prettyPhoto.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('temas/stids/css/animate.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('temas/stids/css/main.css')); ?>" rel="stylesheet">

    <link rel="shortcut icon" href="<?php echo e(asset('temas/stids/img/ico/favicon.png')); ?>">

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo e(asset('temas/stids/img/ico/apple-touch-icon-144-precomposed.png')); ?>">

    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo e(asset('temas/stids/img/ico/apple-touch-icon-114-precomposed.png')); ?>">

    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo e(asset('temas/stids/img/ico/apple-touch-icon-72-precomposed.png')); ?>">

    <link rel="apple-touch-icon-precomposed" href="<?php echo e(asset('temas/stids/img/ico/apple-touch-icon-57-precomposed.png')); ?>">

    <?php echo $__env->yieldContent('style-superior'); ?>

    <?php echo $__env->yieldContent('script-superior'); ?>

<!-- analitic google -->

    <script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');



  ga('create', 'UA-62288505-2', 'auto');

  ga('send', 'pageview');

    </script>   

<!-- end google analityc -->





</head><!--/head-->

<body>

    <header class="navbar navbar-inverse navbar-fixed-top wet-asphalt" role="banner">

        <div class="container">

            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">

                    <span class="sr-only">Toggle navigation</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                </button>

                <a class="navbar-brand" href="index.html"><img src="<?php echo e(asset('temas/stids/img/logo.png')); ?>" width="150" alt="logo"></a>

            </div>

            <div class="collapse navbar-collapse">

            	<?php ($ruta = explode('/', $_SERVER['REQUEST_URI'])); ?>

			   	<?php ($nombre = $ruta[count($ruta)-1]); ?>

			    

			    <ul class="nav navbar-nav navbar-right">

                  

                    <li <?php if($nombre == 'noticias' || $nombre == 'ingresar'): ?> class="active" <?php endif; ?> class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Stids Jeal<i class="icon-angle-down" style="padding-left: 5px;"></i></a>

                        <ul class="dropdown-menu">

                            <li><a href="ingresar">Ingresar a Stids Jeal</a>&nbsp;&nbsp;</li>

                        </ul>

                    </li>

        

                </ul>

            </div>

        </div>

    </header><!--/header-->

   

   	<?php echo $__env->yieldContent('content'); ?>




    <!-- Mainly scripts -->

    <script src="<?php echo e(asset('temas/stids/js/jquery.js')); ?>"></script>

    <script src="<?php echo e(asset('temas/stids/js/bootstrap.min.js')); ?>"></script>

    <script src="<?php echo e(asset('temas/stids/js/jquery.prettyPhoto.js')); ?>"></script>



    <?php echo $__env->yieldContent('script-inferior'); ?>

</body>

</html>