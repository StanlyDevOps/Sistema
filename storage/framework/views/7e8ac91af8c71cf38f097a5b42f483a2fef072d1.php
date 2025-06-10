<html>
    <link rel="shortcut icon" href="<?php echo e(asset('temas/stids/img/ico/favicon.png')); ?>">
    <style>
        @page  {
            margin: 160px 50px;
        }
        header {
            position: fixed;
            left: 0px;
            top: -160px;
            right: 0px;
            font-family: "open sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        footer {
            font-family: "open sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 13px;
            position: fixed;
            left: 0px;
            bottom: -100px;
            right: 0px;
            height: 0px;
            border-bottom: 2px solid #ddd;
        }
        footer .page:after {
            content: counter(page);
        }
        footer table {
            width: 100%;
        }
        footer p {
            text-align: right;
        }
        footer .izq {
            text-align: left;
        }

        .float-right {
            float: right;
        }
        .titulo {
            text-align: center;
            margin: 20px 0;
            font-size: 24px;
            font-weight: 600;
        }
        .subtitulo{
            text-align: center;
            font-size: 14px;
            margin-top: -10px;
            color: #2f4050;
            font-family: "open sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .texto{
            text-align: justify;
            font-size: 14px;
            color: #2f4050;
        }
        .table-bordered > thead > tr > th,
        .table-bordered > tbody > tr > td{
            border: 1px solid #EBEBEB;
            padding: 3px;
        }

        .table-bordered > thead > tr > th {
            text-align: center;
            font-size: 14px;
            background-color: #F5F5F6;
        }

        .table-bordered > tbody > tr > td {
            font-size: 13px;
            color: #2f4050;
        }

        .pie-tabla {
            text-align: center;
            font-size: 12px!important;
            background-color: #F5F5F6;
            font-weight: 700!important;
        }

        .table{
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
            font-family: "open sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        strong {
            color: #000;
        }

        .si {
            background-color: #d0e9c6;
            text-align: center;
        }

        .no {
            background-color: #f2dede;
            text-align: center;
        }
    </style>
<body>
<header>
    <?php if($logo_empresa): ?>
        <img src="<?php echo e(asset("recursos/imagenes/empresa_logo/$logo_empresa")); ?>" height="100" width="280" class="float-right">
    <?php endif; ?>
    <div class="titulo">Listado de permisos</div>
    <div class="subtitulo">Información de todos los permisos que tiene una empresa. </div>
</header>
<footer>
    <table>
        <tr>
            <td>
                <p class="izq">
                    <?php echo e($nombre_empresa); ?> -
                    <span class="generado">Generador por <?php echo e($usuario_generador); ?> <?php echo e(date('Y-m-d H:i:s')); ?></span>.
                </p>
            </td>
            <td>
                <p class="page">
                    Página
                </p>
            </td>
        </tr>
    </table>
</footer>
<div id="content">

    <?php if($tabla): ?>
        <?php $__currentLoopData = $tabla; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <table class="table table-bordered table-hover table-striped tablesorter" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th colspan="8">Rol: <?php echo e($k); ?></th>
                </tr>
                <tr>
                    <th width="50%">Módulos y sesiones</th>
                    <th>Ver</th>
                    <th>Guardar</th>
                    <th>Actualizar</th>
                    <th>Estados</th>
                    <th>Eliminar</th>
                    <th>Exportar</th>
                    <th>Importar</th>
                </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $i; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kp => $ip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if($ip['padre']): ?>
                                    <strong><?php echo e($ip['padre']); ?></strong>
                                <?php else: ?>
                                    &nbsp;&nbsp;&nbsp;
                                    <?php echo e($ip['hijo']); ?>

                                <?php endif; ?>
                            </td>
                            <td class="<?php echo e($ip['ver'] ? 'si' : 'no'); ?>"><?php echo e($ip['ver'] ? 'Sí' : 'No'); ?></td>
                            <td class="<?php echo e($ip['crear'] ? 'si' : 'no'); ?>"><?php echo e($ip['crear'] ? 'Sí' : 'No'); ?></td>
                            <td class="<?php echo e($ip['actualizar'] ? 'si' : 'no'); ?>"><?php echo e($ip['actualizar'] ? 'Sí' : 'No'); ?></td>
                            <td class="<?php echo e($ip['estado'] ? 'si' : 'no'); ?>"><?php echo e($ip['estado'] ? 'Sí' : 'No'); ?></td>
                            <td class="<?php echo e($ip['eliminar'] ? 'si' : 'no'); ?>"><?php echo e($ip['eliminar'] ? 'Sí' : 'No'); ?></td>
                            <td class="<?php echo e($ip['exportar'] ? 'si' : 'no'); ?>"><?php echo e($ip['exportar'] ? 'Sí' : 'No'); ?></td>
                            <td class="<?php echo e($ip['importar'] ? 'si' : 'no'); ?>"><?php echo e($ip['importar'] ? 'Sí' : 'No'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <br>
            <br>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
</body>
</html>