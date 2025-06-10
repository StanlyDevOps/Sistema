<!DOCTYPE html>
<html lang="es-ES">
<head>
    <!-- SEO -->
    <meta name="encoding" charset="utf-8">
    <meta name="application-name" content="Stids Jeal 2.0" />
    <meta name="author" content="Grupo Stids">
    <meta name="generator" content="Laravel 5.4" />
    <meta name="robots" content="index, follow" />

    <?php echo $__env->yieldContent('meta-seo'); ?>
    <!-- Fin SEO -->

	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<title><?php echo e($empresa['nombre_cabecera']); ?></title>
	<link rel="icon" href="<?php echo e(asset('temas')); ?>/<?php echo e($empresa['tema_nombre']); ?>/img/favicon.png" type="image/png">
	<link href="<?php echo e(asset('temas/stids/css/bootstrap.css')); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo e(asset('temas/stids/css/style.css')); ?>" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="<?php echo e(asset('temas/stids/bootstrap/font-awesome/css/font-awesome.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/stids-jeal.css')); ?>" rel="stylesheet">

	<script type="text/javascript" src="<?php echo e(asset('temas/stids/js/jquery.1.8.3.min.js')); ?>"></script>
	
</head>
<body style="background:url('<?php echo e(asset("temas/stids/img/login.jpg")); ?>') no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
		
	<?php echo $__env->yieldContent('content'); ?>
	
</body>
</html>