<div id="buscar-Llegadas-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Servicios de llegadas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <h5 class="mb-4 ">Servicios asignados previamente en Llegadas</h5>
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
                        <br>
                        
                            <?php if( $codigotariotallegadaTransfer_llegadas != ''){?>
                                <div class="row col-12">
                                <div class="col-6" >
                                                <h5 style="margin-bottom: 8px;">Transfer Llegada</h5>

                                        <table style="border-collapse: collapse; width: auto; font-family: Arial; font-size: 14px;">
                                        <tr>
                                            <th style="border: 2px solid black; background: #007BFF; padding: 4px;">CÓDIGO</th>
                                            <th style="border: 2px solid black; background: #007BFF; padding: 4px;">CONCEPTO</th>
                                            <th style="border: 2px solid black; background: #007BFF; padding: 4px;">IVA</th>
                                            <th style="border: 2px solid black; background: #007BFF; padding: 4px;">TOTAL</th>
                                        </tr>

                                       <tr onclick="cargarTransferLlegada()">
                                            <td id="t_codigo_llegada" style="border: 2px solid black; background: #007BFF; padding: 4px;">
                                                <?= $datosLlegada[0]['codigotariotallegadaTransfer_llegadas'] ?>
                                            </td>
                                            <td id="t_texto_llegada" style="border: 2px solid black; background: #007BFF; padding: 4px;">
                                                <?= $datosLlegada[0]['textotariotallegadaTransfer_llegadas'] ?>
                                            </td>
                                            <td id="t_iva_llegada" style="border: 2px solid black; background: #007BFF; padding: 4px;">
                                                <?= $datosLlegada[0]['ivatariotallegadaTransfer_llegadas'] ?>
                                            </td>
                                            <td id="t_total_llegada" style="border: 2px solid black; background: #007BFF; padding: 4px;">
                                                <?= $datosLlegada[0]['importetariotallegadaTransfer_llegadas'] ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            <?php } ?> 
                            <?php if( $textotariotalregresoTransfer_llegadas != ''){?>

                            <div class="col-6" onclick="cargarTransferRegreso()">
                                                <h5 style="margin-bottom: 8px;">Transfer Regreso</h5>

                                <table style="border-collapse: collapse; width: auto; font-family: Arial; font-size: 14px;">
                                    <tr>
                                        <th style="border: 2px solid black; background: #F98600; padding: 4px;">CÓDIGO</th>
                                        <th style="border: 2px solid black; background: #F98600; padding: 4px;">CONCEPTO</th>
                                        <th style="border: 2px solid black; background: #F98600; padding: 4px;">IVA</th>
                                        <th style="border: 2px solid black; background: #F98600; padding: 4px;">TOTAL</th>
                                    </tr>

                                     <tr onclick="cargarTransferRegreso()">
                                        <td id="t_codigo_regreso" style="border: 2px solid black; background: #ff8f32; padding: 4px;">
                                            <?= $datosLlegada[0]['codigotariotalregresoTransfer_llegadas'] ?>
                                        </td>
                                        <td id="t_texto_regreso" style="border: 2px solid black; background: #ff8f32; padding: 4px;">
                                            <?= $datosLlegada[0]['textotariotalregresoTransfer_llegadas'] ?>
                                        </td>
                                        <td id="t_iva_regreso" style="border: 2px solid black; background: #ff8f32; padding: 4px;">
                                            <?= $datosLlegada[0]['ivatariotalregresoTransfer_llegadas'] ?>
                                        </td>
                                        <td id="t_total_regreso" style="border: 2px solid black; background: #ff8f32; padding: 4px;">
                                            <?= $datosLlegada[0]['importetariotalregresoTransfer_llegadas'] ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                         <?php } ?> 

                        
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