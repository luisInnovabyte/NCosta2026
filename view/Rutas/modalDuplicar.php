<div id="duplicar-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Duplicar Ruta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">

                        <div class="row">
                            <label class="form-label fw-bold fs-5 d-block">
                                Curso a duplicar: <span id="cursoNombre" class="text-warning"></span>
                            </label>
                            <label class="form-label fw-bold fs-5 d-block">
                                Rutas encontradas: <span id="rutasCantidad" class="text-success"></span>
                            </label>
                            <hr>
                            <label class="form-label fw-bold fs-5 d-block">
                                Destino:
                            </label>
                            <div class="form-group col-md-4">
                                <label for="idioma">Idiomas</label><br>
                                <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR IDIOMA" style="width: 100%; height: 65px !important;" id="selectIdiomaModal">
                                    <?php foreach ($datosIdioma as $row) { ?>
                                        <option value="<?php echo $row["idIdioma"] ?>"><?php echo $row["descrIdioma"] ?> - <?php echo $row["codIdioma"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                           
                            <div class="form-group col-md-4">
                                <label for="curso">Tipo de Curso</label><br>
                                <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR CURSO" style="width: 100%; height: 65px !important;" id="selectCursoModal">
                                    <?php foreach ($datos as $row) { ?>
                                        <option value="<?php echo $row["idTipo"] ?>"><?php echo $row["descrTipo"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">

                                <div id="checkAlert" class="form-check mg-t-20 mg-b-20 form-check-danger d-none">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDanger">
                                    <label class="form-check-label" for="flexCheckCheckedDanger">
                                        Se procederá a <b id='' class="tx-danger">eliminar</b> el contenido de la ruta <b id='rutaDestino' class="tx-danger"></b> y se insertarán los datos de la ruta <b  class="tx-success" id='rutaDuplicar'></b>.
                                    </label> 
                                </div>
                            </div>


                            <button id="duplicarRutBoton" type="button" class="btn btn-danger" title="Duplicar Ruta" onClick="duplicarRuta()">Duplicar Ruta</button>

                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
            </div>
        </div>
    </div>
</div>