<div id="content-preview" class="ibox-content p-xl ocultar">
    <div class="row">
        <div class="col-sm-6">
            <h5>De:</h5>
            <address>
                <strong id="p-company"></strong>
                <br>
                <span id="p-address"></span>
                <br>
                <span id="p-city"></span>
                <br>
                <abbr title="Phone">Tel:</abbr> <span id="p-phone"></span>
            </address>
        </div>

        <div class="col-sm-6 text-right">
            <h4>Pedido No.</h4>
            <h4 class="text-navy" id="p-code-order"></h4>
            <p>
                <span>
                    <strong>Fecha creación:</strong>
                    <span id="p-date-add"></span>
                </span>
                <br>
                <span>
                    <strong>Usuario creador:</strong>
                    <span id="p-user-add"></span>
                </span>
            </p>
        </div>
    </div>

    <div class="table-responsive m-t">
        <table class="table invoice-table" id="preview-table">
            <thead>
            <tr>
                <th>#</th>
                <th class="centrado">Producto</th>
                <th class="centrado">Valor</th>
                <th class="centrado">Cantidad</th>
                <th class="centrado">Sub Total</th>
                <th class="centrado">Impuesto</th>
                <th>Total General</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td width="1%">
                    <strong>1</strong>
                </td>
                <td class="izquierda">
                    <small>LED 32" HD Smart WebOS.</small>
                </td>
                <td class="centrado">1</td>
                <td class="centrado">$26.00</td>
                <td class="centrado">$5.98</td>
                <td>$31,98</td>
            </tr>

            </tbody>
        </table>
    </div><!-- /table-responsive -->

    <table class="table invoice-total">
        <tbody>
        <tr>
            <td><strong>Sub Total :</strong></td>
            <td id="p-total">$1026.00</td>
        </tr>
        <tr>
            <td><strong>Impuesto :</strong></td>
            <td id="p-total-tax">$235.98</td>
        </tr>
        <tr>
            <td><strong>TOTAL :</strong></td>
            <td id="p-total-general">$1261.98</td>
        </tr>
        </tbody>
    </table>

    <div class="well m-t">
        <strong>Comentarios</strong>
        <span id="p-comments">
        </span>
    </div>
</div>