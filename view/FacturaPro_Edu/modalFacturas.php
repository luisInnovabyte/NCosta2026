<div id="buscar-facturas-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Facturas Proforma</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <h5 class="mb-4">Se muestran las facturas proforma realizadas en esta llegada.</h5>
                        </div>
                        <div class="row g-3">

                            <div class="col-12">
                                <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>


                                <div class="row">

                                    <div class="table-responsive order-mobile-first">
                                        <?php
                                        $nombreTabla = "facturas_table";
                                        $nombreCampos = ["ID", "Nombre", "A Quien Factura", "Número Factura", "Fecha", "Ver Proforma", "Ver Factura", "Abonar", /*"Factura REAV"*/ "Pago Pendiente"];
                                        $nombreCamposFooter = ["ID", "Nombre", "A Quien Factura", "Número Factura", "Fecha", "Ver Proforma", "Ver Factura", "Abonar", /*"Factura REAV"*/ "Pago Pendiente"];

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
                </div>
            </div>
        </div>
    </div>
</div>