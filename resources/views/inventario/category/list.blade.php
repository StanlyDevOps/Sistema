<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-dismissable alert-info justificado">
            <label>
                Categorias.
            </label>
            <p>
                Aquí podrá organizar todas sus categorias para los productos que
                posee en inventario. Tendrá un maximo de 5 niveles de organización
                para sus categorias, recuerde que al momento de realizar un movimiento
                se guardará el orden automaticamente.
            </p>
        </div>
        <div class="dd" id="lista-categoria">
            <ol class='dd-list dd3-list listado'>
            </ol>
        </div>
        <menu id="nestable-menu" class="centrado">
            <button type="button" class="btn btn-blanco" data-action="collapse-all">
                <i class="fa fa-compress" aria-hidden="true"></i>
                Contraer todo
            </button>
            <button type="button" class="btn btn-blanco" data-action="expand-all">
                <i class="fa fa-expand" aria-hidden="true"></i>
                Expandir todo
            </button>
        </menu>
        <textarea id="nestable-output" class="ocultar"></textarea>
    </div>
</div>