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
            font-size: 11px;
            background-color: #F5F5F6;
        }

        .table-bordered > tbody > tr > td {
            font-size: 10px;
            color: #2f4050;
        }

        .pie-tabla {
            text-align: center;
            font-size: 11px!important;
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
    </style>
<body>
<header>
    <?php if($logo_empresa): ?>
        <img src="<?php echo e(asset("recursos/imagenes/empresa_logo/$logo_empresa")); ?>" height="100" width="280" class="float-right">
    <?php endif; ?>
    <div class="titulo">Prestamos Finalizados</div>
    <div class="subtitulo">Reporte de prestamos finalizados por rango de fecha.</div>
    <br>
    <div class="texto">
        <strong>Fecha inicial:</strong> <?php echo e($fecha_inicial); ?>.
        &nbsp;&nbsp;&nbsp;
        <strong>Fecha final:</strong> <?php echo e($fecha_final); ?>.
        &nbsp;&nbsp;&nbsp;
        <strong>Reporte generado por:</strong> <?php echo e($usuario_generador); ?>.
    </div>
</header>
<footer>
    <table>
        <tr>
            <td>
                <p class="izq">
                    <?php echo e($nombre_empresa); ?> -
                    <span class="generado"><?php echo e(date('Y-m-d H:i:s')); ?></span>.
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
    <table class="table table-bordered table-hover table-striped tablesorter" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th>#</th>
            <th>Identificación</th>
            <th>Clientes</th>
            <th>Celular</th>
            <th>Fecha prestamo</th>
            <th>Cuotas</th>
            <th>Fecha de vencimiento</th>
            <th>Ingresado por</th>
            <th>Estado</th>
            <th>Valor</th>
            <th>Interes</th>
            <th>Valor total</th>
            <th>Deuda</th>
            <th>Abonado</th>
        </tr>
        </thead>
        <tbody>
            <?php ($totalValor = 0); ?>
            <?php ($totalInteres = 0); ?>
            <?php ($totalGeneral = 0); ?>
            <?php ($totalDeuda = 0); ?>
            <?php ($totalAbonado = 0); ?>
            <?php ($cnt = 1); ?>
            <?php $__currentLoopData = $tabla; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td align="center"><?php echo e($cnt); ?></td>
                    <td align="center"><?php echo e($r->identificacion); ?></td>
                    <td><?php echo e($r->cliente); ?></td>
                    <td align="center"><?php echo e($r->celular); ?></td>
                    <td align="center"><?php echo e($r->fecha_prestamo); ?></td>
                    <td align="center"><?php echo e($r->cuotas); ?></td>
                    <td align="center"><?php echo e($r->fecha_vencimiento); ?></td>
                    <td align="center"><?php echo e($r->creado_por); ?></td>
                    <td align="center"><?php echo e($r->estado); ?></td>
                    <td align="center">$<?php echo e(number_format($r->valor)); ?></td>
                    <td align="center">$<?php echo e(number_format($r->intereses)); ?></td>
                    <td align="center">$<?php echo e(number_format($r->valor_total)); ?></td>
                    <td align="center">$<?php echo e(number_format($r->deuda)); ?></td>
                    <td align="center">$<?php echo e(number_format($r->abonado)); ?></td>
                </tr>
                <?php ($totalValor += $r->valor); ?>
                <?php ($totalInteres += $r->intereses); ?>
                <?php ($totalGeneral += $r->valor_total); ?>
                <?php ($totalDeuda += $r->deuda); ?>
                <?php ($totalAbonado += $r->abonado); ?>
                <?php ($cnt++); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td colspan="9" class="pie-tabla">Total</td>
            <td align="center">$<?php echo e(number_format($totalValor)); ?></td>
            <td align="center">$<?php echo e(number_format($totalInteres)); ?></td>
            <td align="center">$<?php echo e(number_format($totalGeneral)); ?></td>
            <td align="center">$<?php echo e(number_format($totalDeuda)); ?></td>
            <td align="center">$<?php echo e(number_format($totalAbonado)); ?></td>
        </tr>
        </tbody>
    </table>
    <?php else: ?>

        <div class="subtitulo">No se encontraron resultados para esta busqueda.</div>
    <?php endif; ?>
</div>
</body>
</html>