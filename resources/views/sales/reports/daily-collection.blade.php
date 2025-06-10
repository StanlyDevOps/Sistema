<html>
    <style>
        @page {
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
    </style>
<body>
<header>
    @if($company_logo)
        <img src="{{asset("recursos/imagenes/empresa_logo/$company_logo")}}" height="100" width="280" class="float-right">
    @endif
    <div class="titulo">Recaudo Diario</div>
    <div class="subtitulo">Reporte de Recaudo por día seleccionado. </div>
    <br>
    <div class="texto">
        <strong>Fecha:</strong> {{$date}}.
        &nbsp;&nbsp;&nbsp;
        <strong>Reporte generado por:</strong> {{$user_generator}}.
    </div>
</header>
<footer>
    <table>
        <tr>
            <td>
                <p class="izq">
                    {{$company_name}} -
                    <span class="generado">{{date('Y-m-d H:i:s')}}</span>.
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
    @if($table)
    <table class="table table-bordered table-hover table-striped tablesorter" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th>#</th>
            <th>Experición</th>
            <th>Codigo pedido</th>
            <th>Codigo factura</th>
            <th>Cantidad items</th>
            <th>Total</th>
            <th>Total impuesto</th>
            <th>Total general</th>
            <th>Pago en efectivo</th>
            <th>Pago con tarjeta</th>
        </tr>
        </thead>
        <tbody>
            @php($total = 0.0)
            @php($totalTax = 0.0)
            @php($totalGeneral = 0.0)
            @php($totalCash = 0.0)
            @php($totalCard = 0.0)
            @foreach($table as $k => $r)
                <tr>
                    <td align="center">{{$k + 1}}</td>
                    <td align="center">{{$r->fecha_expedicion}}</td>
                    <td align="center">{{$r->codigo_pedido}}</td>
                    <td align="center">{{$r->codigo_factura}}</td>
                    <td align="center">{{$r->cantidad_items}}</td>
                    <td align="center">${{number_format($r->total)}}</td>
                    <td align="center">${{number_format($r->total_impuesto)}}</td>
                    <td align="center">${{number_format($r->total_general)}}</td>
                    <td align="center">${{number_format($r->pago_efectivo)}}</td>
                    <td align="center">${{number_format($r->pago_tarjeta)}}</td>
                </tr>
                @php($total += $r->total)
                @php($totalTax += $r->total_impuesto)
                @php($totalGeneral += $r->total_general)
                @php($totalCash += $r->pago_efectivo)
                @php($totalCard += $r->pago_tarjeta)
            @endforeach
        <tr>
            <td colspan="5" class="pie-tabla">Total</td>
            <td align="center">${{number_format($total)}}</td>
            <td align="center">${{number_format($totalTax)}}</td>
            <td align="center">${{number_format($totalGeneral)}}</td>
            <td align="center">${{number_format($totalCash)}}</td>
            <td align="center">${{number_format($totalCard)}}</td>
        </tr>
        </tbody>
    </table>
    @else

        <div class="subtitulo">No se encontraron resultados para esta busqueda.</div>
    @endif
</div>
</body>
</html>