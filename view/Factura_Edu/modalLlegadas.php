<div id="buscar-Llegadas-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tarifas llegadas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <h5 class="mb-4 ">Tarifas funcionales asignadas previamente en Llegadas</h5>
                        </div>
                        
                        <div class="col-12">
                       
                                                            
                            <div id="matriculacionTableDiv" class="table-responsive order-mobile-first">
                                <?php
                                $nombreTabla = "matriculacionTableNew";
                                $nombreCampos = ["Tipo","Tarifa", "Descripción", "Observaciones", "Importe", "IVA", "Descuento", "Fecha Inicio", "Fecha Fin", "TipoId"];
                                $nombreCamposFooter = [
                                    "Tipo",
                                    "Tarifa",
                                    "Descripción",
                                    "Observaciones",
                                    "Importe",
                                    "IVA",
                                    "Descuento",
                                    "Fecha Inicio",
                                    "Fecha Fin",
                                 "TipoId"
                                ];

                                $cantidadGrupos = 1; //* CANTIDAD DE AGRUPACIONES *// //=Valores 0 ~ 3==//
                                $columGrupos = []; //* COLUMNAS A AGRUPAR *// //=Poner el numero de la columna empezando a contar desde 0==//
                                $agrupacionesPersonalizadas = 0; //* MARCAR SI QUIERES REALIZAR EL DISEÑO DE LA AGRUPACION MANUAL O AUTOMATICA *// //= 0->Auto 1->Manual ==//
                                $colorHEX = "#3AB54A"; //* COLOR POR DEFECTO DE LAS AGRUPACIONES *// //= Color Hexadecimal #000000 ~ #FFFFFF ==//
                                $desplegado = 0; //* SI QUIERES QUE POR DEFECTO LAS AGRUPACIONES ESTEN PLEGADAS *// //= 0->DESPLEGADO 1->PLEGADO ==//
                                $colorPicker = 0; //* SI QUIERES MOSTRAR EL COLOR PICKER O NO *// //= 0->No 1->Si  ==//

                                $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, $cantidadGrupos, $columGrupos, $agrupacionesPersonalizadas, $colorHEX, $desplegado, $colorPicker);
                                echo $tablaHTML;
                                ?>
                            </div>
                                                            
                                                    
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Almacena todas las tarifas" onClick="agregarTodosTarifa()">Insertar Todos</button>
            </div>
        </div>
    </div>
</div>