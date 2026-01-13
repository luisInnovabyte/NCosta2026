<style>
    /* Estilos para el modal de llegadas */
    #buscar-Llegadas-modal .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    #buscar-Llegadas-modal .modal-header {
        background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
        color: white;
        padding: 24px 32px;
        border: none;
    }

    #buscar-Llegadas-modal .modal-title {
        font-size: 1.75rem;
        font-weight: 600;
        letter-spacing: -0.5px;
        margin: 0;
    }

    #buscar-Llegadas-modal .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
        transition: opacity 0.2s;
    }

    #buscar-Llegadas-modal .btn-close:hover {
        opacity: 1;
    }

    #buscar-Llegadas-modal .modal-body {
        padding: 32px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    #buscar-Llegadas-modal .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        background: white;
    }

    #buscar-Llegadas-modal .section-title {
        font-size: 1.35rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 3px solid #6c757d;
        display: inline-block;
    }

    /* Tarjetas de Transfer mejoradas */
    .transfer-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .transfer-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        border-color: currentColor;
    }

    .transfer-card.llegada {
        border-top: 4px solid #007BFF;
    }

    .transfer-card.regreso {
        border-top: 4px solid #F98600;
    }

    .transfer-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .transfer-card.llegada .transfer-card-title {
        color: #007BFF;
    }

    .transfer-card.regreso .transfer-card-title {
        color: #F98600;
    }

    .transfer-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .transfer-table th {
        padding: 12px 16px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: white;
        text-align: left;
    }

    .transfer-card.llegada .transfer-table th {
        background: linear-gradient(135deg, #007BFF 0%, #0056b3 100%);
    }

    .transfer-card.regreso .transfer-table th {
        background: linear-gradient(135deg, #F98600 0%, #d67400 100%);
    }

    .transfer-table td {
        padding: 12px 16px;
        background: #f8f9fa;
        color: #495057;
        font-weight: 500;
        border-bottom: 1px solid #e9ecef;
    }

    .transfer-table tr:last-child td {
        border-bottom: none;
    }

    /* Footer del modal */
    #buscar-Llegadas-modal .modal-footer {
        padding: 20px 32px;
        background: white;
        border-top: 1px solid #e9ecef;
        gap: 12px;
    }

    #buscar-Llegadas-modal .modal-footer .btn {
        padding: 12px 32px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    #buscar-Llegadas-modal .modal-footer .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border: none;
    }

    #buscar-Llegadas-modal .modal-footer .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }

    #buscar-Llegadas-modal .modal-footer .btn-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
    }

    #buscar-Llegadas-modal .modal-footer .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
    }

    /* Espaciado para sección de transfers */
    .transfers-section {
        margin-top: 32px;
    }
</style>

<div id="buscar-Llegadas-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">📋 Servicios de Llegadas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <h5 class="section-title">Servicios Asignados Previamente</h5>
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
                        
                        <?php if($codigotariotallegadaTransfer_llegadas != '' || $textotariotalregresoTransfer_llegadas != ''): ?>
                        <div class="transfers-section">
                            <h5 class="section-title">🚐 Servicios de Transfer</h5>
                            
                            <div class="row g-4">
                                <?php if($codigotariotallegadaTransfer_llegadas != ''): ?>
                                <div class="col-md-6">
                                    <div class="transfer-card llegada" onclick="cargarTransferLlegada()">
                                        <div class="transfer-card-title">
                                            <span>✈️</span> Transfer de Llegada
                                        </div>
                                        <table class="transfer-table">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Concepto</th>
                                                    <th>IVA</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="t_codigo_llegada"><?= $datosLlegada[0]['codigotariotallegadaTransfer_llegadas'] ?></td>
                                                    <td id="t_texto_llegada"><?= $datosLlegada[0]['textotariotallegadaTransfer_llegadas'] ?></td>
                                                    <td id="t_iva_llegada"><?= $datosLlegada[0]['ivatariotallegadaTransfer_llegadas'] ?>%</td>
                                                    <td id="t_total_llegada"><strong><?= $datosLlegada[0]['importetariotallegadaTransfer_llegadas'] ?>€</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($textotariotalregresoTransfer_llegadas != ''): ?>
                                <div class="col-md-6">
                                    <div class="transfer-card regreso" onclick="cargarTransferRegreso()">
                                        <div class="transfer-card-title">
                                            <span>🏠</span> Transfer de Regreso
                                        </div>
                                        <table class="transfer-table">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Concepto</th>
                                                    <th>IVA</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="t_codigo_regreso"><?= $datosLlegada[0]['codigotariotalregresoTransfer_llegadas'] ?></td>
                                                    <td id="t_texto_regreso"><?= $datosLlegada[0]['textotariotalregresoTransfer_llegadas'] ?></td>
                                                    <td id="t_iva_regreso"><?= $datosLlegada[0]['ivatariotalregresoTransfer_llegadas'] ?>%</td>
                                                    <td id="t_total_regreso"><strong><?= $datosLlegada[0]['importetariotalregresoTransfer_llegadas'] ?>€</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bx bx-x-circle"></i> Cerrar
                </button>
                <button type="button" class="btn btn-primary" title="Almacena todas las tarifas" onClick="agregarTodosTarifa()">
                    <i class="bx bx-check-double"></i> Insertar Todos
                </button>
            </div>
        </div>
    </div>
</div>