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

        .table-bordered > thead > tr > th, .th {
            text-align: left;
            font-size: 11px;
            background-color: #F5F5F6;
            font-weight: 600;
        }

        .table-bordered > tbody > tr > td {
            font-size: 12px;
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
        .centrado {
            text-align: center!important;
            font-size: 15px!important;
        }
        .negrita {
            font-weight: 700;
        }
    </style>
<body>
<header>
    <?php if($logo_empresa): ?>
        <img src="<?php echo e(asset("recursos/imagenes/empresa_logo/$logo_empresa")); ?>" height="100" width="280" class="float-right">
    <?php endif; ?>
    <div class="titulo">Información General</div>
    <div class="subtitulo">Información general del cliente y sus codeudores.</div>
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
        <tbody>
            <tr>
                <td colspan="4" class="th centrado">Información General</td>
            </tr>
            <tr>
                <td class="negrita">Tipo de idenfificación.</td>
                <td><?php echo e($informacion->nombre_tipo_identificacion); ?></td>
                <td class="negrita">No. Documento.</td>
                <td><?php echo e($informacion->identificacion); ?></td>
            </tr>
            <tr>
                <td class="negrita">Nombres.</td>
                <td><?php echo e($informacion->nombres); ?></td>
                <td class="negrita">Apellidos.</td>
                <td><?php echo e($informacion->apellidos); ?></td>
            </tr>
            <tr>
                <td class="negrita">Estado civil.</td>
                <td><?php echo e($informacion->nombre_estado_civil); ?></td>
                <td class="negrita">Ciudad.</td>
                <td><?php echo e($informacion->ciudad); ?></td>
            </tr>
            <tr>
                <td class="negrita">Dirección.</td>
                <td><?php echo e($informacion->direccion); ?></td>
                <td class="negrita">Barrio.</td>
                <td><?php echo e($informacion->barrio); ?></td>
            </tr>
            <tr>
                <td class="negrita">Teléfono.</td>
                <td><?php echo e($informacion->telefono); ?></td>
                <td class="negrita">Celular.</td>
                <td><?php echo e($informacion->celular); ?></td>
            </tr>
            <tr>
                <td class="negrita">Email.</td>
                <td><?php echo e($informacion->email_personal); ?></td>
                <td class="negrita">Fecha de nacimiento.</td>
                <td><?php echo e($informacion->fecha_nacimiento); ?></td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered table-hover table-striped tablesorter" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td colspan="4" class="th centrado">Actividad Economica</td>
            </tr>
            <tr>
                <td class="negrita">Ocupación u oficio.</td>
                <td><?php echo e($informacion->nombre_ocupacion); ?></td>
                <td class="negrita">Nombre de la empresa.</td>
                <td><?php echo e($informacion->empresa_nombre); ?></td>
            </tr>
            <tr>
                <td class="negrita">Cargo.</td>
                <td><?php echo e($informacion->empresa_cargo); ?></td>
                <td class="negrita">Area.</td>
                <td><?php echo e($informacion->empresa_area); ?></td>
            </tr>
            <tr>
                <td class="negrita">Barrio.</td>
                <td><?php echo e($informacion->empresa_barrio); ?></td>
                <td class="negrita">Dirección.</td>
                <td><?php echo e($informacion->empresa_direccion); ?></td>
            </tr>
            <tr>
                <td class="negrita">Teléfono.</td>
                <td><?php echo e($informacion->empresa_telefono); ?></td>
                <td class="negrita">Fecha de ingreso.</td>
                <td><?php echo e($informacion->empresa_fecha_ingreso); ?></td>
            </tr>
            <tr>
                <td class="negrita">Antiguedad.</td>
                <td colspan="3">
                    <?php echo e($informacion->empresa_antiguedad_meses); ?>

                    <?php if($informacion->empresa_antiguedad_meses > 1): ?>
                         meses
                    <?php else: ?>
                        mes
                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered table-hover table-striped tablesorter" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td colspan="6" class="th centrado">Información Financiera</td>
            </tr>
            <tr>
                <td class="negrita">Banco.</td>
                <td colspan="2"><?php echo e($informacion->nombre_banco); ?></td>
                <td class="negrita">No. Cuenta.</td>
                <td colspan="2"><?php echo e($informacion->no_cuenta); ?></td>
            </tr>
            <tr>
                <td class="negrita">Sueldo.</td>
                <td>$<?php echo e(number_format($informacion->sueldo)); ?></td>
                <td class="negrita">Ingresos.</td>
                <td>$<?php echo e(number_format($informacion->ingresos)); ?></td>
                <td class="negrita">Egresos.</td>
                <td>$<?php echo e(number_format($informacion->egresos)); ?></td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered table-hover table-striped tablesorter" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <td colspan="2" class="th centrado">Referencia personal</td>
            <td colspan="2" class="th centrado">Referencia familiar</td>
        </tr>
        <tr>
            <td class="negrita">Nombres.</td>
            <td><?php echo e($informacion->ref_personal_nombres); ?></td>
            <td class="negrita">Nombres.</td>
            <td><?php echo e($informacion->ref_familiar_nombres); ?></td>
        </tr>
        <tr>
            <td class="negrita">Apellidos.</td>
            <td><?php echo e($informacion->ref_personal_apellidos); ?></td>
            <td class="negrita">Apellidos.</td>
            <td><?php echo e($informacion->ref_familiar_apellidos); ?></td>
        </tr>
        <tr>
            <td class="negrita">Barrio.</td>
            <td><?php echo e($informacion->ref_personal_barrio); ?></td>
            <td class="negrita">Barrio.</td>
            <td><?php echo e($informacion->ref_familiar_barrio); ?></td>
        </tr>
        <tr>
            <td class="negrita">Teléfono.</td>
            <td><?php echo e($informacion->ref_personal_telefono); ?></td>
            <td class="negrita">Teléfono.</td>
            <td><?php echo e($informacion->ref_familiar_telefono); ?></td>
        </tr>
        <tr>
            <td class="negrita">Celular.</td>
            <td><?php echo e($informacion->ref_personal_celular); ?></td>
            <td class="negrita">Celular.</td>
            <td><?php echo e($informacion->ref_familiar_celular); ?></td>
        </tr>
        </tbody>
    </table>

    <table class="table table-bordered table-hover table-striped tablesorter" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <td class="th centrado">Observaciones</td>
        </tr>
        <tr>
            <td valign="center"><?php echo e($informacion->observaciones); ?></td>
        </tr>
        </tbody>
    </table>

    <?php if($codeudores->count() > 0): ?>
        <?php ($cnt = 1); ?>
        <?php $__currentLoopData = $codeudores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $codeudor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <table class="table table-bordered table-hover table-striped tablesorter" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td colspan="4" class="th centrado">Codeudor No. <?php echo e($cnt); ?></td>
                </tr>
                <tr>
                    <td class="negrita">Cedula.</td>
                    <td><?php echo e($codeudor->cedula); ?></td>
                    <td class="negrita">Fecha expedición.</td>
                    <td><?php echo e($codeudor->fecha_expedicion); ?></td>
                </tr>
                <tr>
                    <td class="negrita">Nombres.</td>
                    <td><?php echo e($codeudor->nombres); ?></td>
                    <td class="negrita">Apellidos.</td>
                    <td><?php echo e($codeudor->apellidos); ?></td>
                </tr>
                <tr>
                    <td class="negrita">Teléfono.</td>
                    <td><?php echo e($codeudor->telefono); ?></td>
                    <td class="negrita">Celular.</td>
                    <td><?php echo e($codeudor->celular); ?></td>
                </tr>
                <tr>
                    <td class="negrita">Direccion.</td>
                    <td colspan="3"><?php echo e($codeudor->direccion); ?></td>
                </tr>
                </tbody>
            </table>
            <?php ($cnt++); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <br>
        <div class="subtitulo">No se encontraron codeudores para este cliente...</div>
    <?php endif; ?>
</div>
</body>
</html>