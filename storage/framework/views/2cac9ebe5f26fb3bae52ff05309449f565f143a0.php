<html>
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
            text-align: justify;
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
            font-size: 12px;
            background-color: #F5F5F6;
        }

        .table-bordered > tbody > tr > td {
            font-size: 11px;
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

        .generado {
            text-align: justify;
            font-size: 14px;
        }
    </style>
<body>
<header>
    <?php if($logo_empresa): ?>
        <img src="<?php echo e(asset("recursos/imagenes/empresa_logo/$logo_empresa")); ?>" height="100" width="280" class="float-right">
    <?php endif; ?>
    <div class="titulo">Simulación de Prestamo</div>
    <div class="subtitulo">
        Prestamo solicitado por el cliente <strong><?php echo e($encabezado[0]); ?></strong>
        con fecha de inicio de pago el <strong><?php echo e(substr($encabezado[8],8,2)); ?></strong> de <strong><?php echo e($meses[(int)substr($encabezado[8],5,2)]); ?></strong> de <strong><?php echo e(substr($encabezado[8],0,4)); ?></strong>.</div>
    <br>
    <div class="texto">
        <strong>Tipo de Prestamo:</strong> <?php echo e($encabezado[1]); ?>.
        &nbsp;&nbsp;&nbsp;
        <strong>Pago:</strong> <?php echo e($encabezado[2]); ?>.
        &nbsp;&nbsp;&nbsp;
        <strong>Monto:</strong> $<?php echo e(number_format($encabezado[3])); ?>.
        &nbsp;&nbsp;&nbsp;
        <strong>Interes:</strong> <?php echo e($encabezado[5]); ?>%.
        &nbsp;
        <strong>No. Cuotas:</strong> <?php echo e($encabezado[4]); ?>.
    </div>
</header>
<footer>
    <table>
        <tr>
            <td>
                <p class="izq">
                    <?php echo e($nombre_empresa); ?> -
                <span class="generado">Generado por <?php echo e($usuario_generador); ?> <?php echo e(date('Y-m-d H:i:s')); ?></span>.
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

    <table class="table table-bordered table-hover table-striped tablesorter" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th>Periodo</th>
            <th>Fecha pago</th>
            <th>Saldo inicial</th>
            <th>Cuota</th>
            <th>Interes</th>
            <th>Abono a capital</th>
            <th>Saldo final</th>
        </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $tabla; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php ($columna = explode(';',$r)); ?>
                <tr>
                    <td align="center"><?php echo e($columna[0]); ?></td>
                    <td align="center"><?php echo e($columna[1]); ?></td>
                    <td align="center">$<?php echo e(number_format($columna[2])); ?></td>
                    <td align="center">$<?php echo e(number_format($columna[3])); ?></td>
                    <td align="center">$<?php echo e(number_format($columna[4])); ?></td>
                    <td align="center">$<?php echo e(number_format($columna[5])); ?></td>
                    <td align="center">$<?php echo e(number_format($columna[6])); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td colspan="3" class="pie-tabla">Total</td>
            <td align="center">$<?php echo e(number_format($encabezado[7])); ?></td>
            <td align="center">$<?php echo e(number_format($encabezado[6])); ?></td>
            <td align="center">$<?php echo e(number_format($encabezado[3])); ?></td>
            <td class="pie-tabla">&nbsp;</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>