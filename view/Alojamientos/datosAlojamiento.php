<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title>Costa Valencia</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="author" content="efeuno.es">
	<!-- Favicon icon -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

	<!-- CIFRADO ID -->


	<?php

	
	require_once("../../config/conexion.php");
	require_once("../../config/funciones.php");
	require_once("../../models/Alojamientos.php");
	require_once("../../models/TiposAloja_Edu.php");

	$alojamiento = new Alojamientos();
	$tiposAloja = new TiposAloja();

	session_start();

	$condition = null; // VARIABLE QUE DETERMINARA LA SITUACION DEL FORMULARIO
	/// 0 = ALUMNO (SOLO CONSULTAR) // 1 = ADMIN (INSERTAR Y EDITAR) // 2 = FAMILIA (SOLO EDITAR CON TOKEN) ///
	
	if (!isset($_SESSION['usu_rol'])) { // SI NO TIENE ROL


		if (isset($_GET['idAloja']) && $_GET['idAloja'] != '') { // SI EXISTE LA VARIABLE, Y ES DISTINTO DE '' (VACIO)
			// COMPROBACIÓN DE PERMISOS DE TOKEN //

			$idAloja = $_GET['idAloja'];

			$datosAlojamiento = $alojamiento->comprobarToken($idAloja); // COMPROBAR SI HAY UN ALOJAMIENTO CON ESE TOKEN CREADO

			$datosAlojamiento = !empty($datosAlojamiento); // SI ESTA VACIO = FALSE /// SI TIENE DATOS = TRUE;


			if ($datosAlojamiento == true) { // TIENE TOKEN DISPONIBLE // EDITAR // FAMILIA ARRENDA
			
				$datosAlojamiento =  $alojamiento->getAlojamiento_x_token($idAloja);

				$condition = 'edit';



			} else { // NO TIENE TOCKEN DISPONIBLE
				header("Location: denegado.html");
			}
		} else { // SI NO TIENE VARIABLE 
	
			header("Location: index.php");
			exit;
		}

	} else { // TIENE ROL
		
		if ($_SESSION['usu_rol'] == '1') { // ES ADMIN 
			
			if (isset($_GET['idAloja']) && $_GET['idAloja'] != '') { // EDITANDO

				$idAloja = $_GET['idAloja'];
			

				$datosAlojamiento =  $alojamiento->getAlojamiento_x_token($idAloja);
			
				$datosAlojamiento = !empty($datosAlojamiento); // SI ESTA VACIO = FALSE /// SI TIENE DATOS = TRUE;


				if($datosAlojamiento == true){ // SI LA VARIABLE ID ALOJA ES TRUE, PODRA EDITAR
					$datosAlojamiento =  $alojamiento->getAlojamiento_x_token($idAloja);
				
					$condition = 'editAdmin';
					$datosAlojamiento =  $alojamiento->getAlojamiento_x_token($idAloja);
				

				}else{ // SI LA VARIABLE NO EXISTE, NO HAY ALOJA CON ESA ID, SE VA A INDEX
					header("Location: index.php");
				}
				

			}else{ // INSERTANDO


				$condition = 'insert';


			}
		} else { // ES ALUMNO // CONSULTAR
	
			
			if (isset($_GET['idAloja']) && $_GET['idAloja'] != '') { // CONSULTANDO ALUMNO

				$idAloja = $_GET['idAloja'];
				session_start();
				$idAlumno = $_SESSION['usu_token'];
				
		
 				$datosAlojamiento = $alojamiento->getAlojamiento_x_idAlumno($idAloja, $idAlumno);
				
		
				$datosAlojamiento = !empty($datosAlojamiento); // SI ESTA VACIO = FALSE /// SI TIENE DATOS = TRUE;


				if($datosAlojamiento == true){ // SI LA VARIABLE ID ALOJA ES TRUE, PODRA EDITAR
					
					$condition = 'consult';
					$datosAlojamiento =  $alojamiento->getAlojamiento_x_token($idAloja);



				}else{ // SI LA VARIABLE NO EXISTE, NO HAY ALOJA CON ESA ID, SE VA A INDEX
		
					header("Location: ../../index.php"); 
				}
				

			}else{ 
			
				header("Location:  ../../index.php");

			}

		}
	}


	$dominio_actual = $_SERVER['HTTP_HOST'];
    
          
    $url = 'http://' . $dominio_actual . '/N.CostaSV/view/Alojamientos/datosAlojamiento.php?idAloja=' . $idAloja . '';
	$texto = $url;


	?>

	<!-- Required meta tags -->
	<meta name="robots" content="noindex">
	<meta name="googlebot" content="noindex">

	<link rel="stylesheet" href="../../public/assetsForm/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../public/assetsForm/css/animate.min.css">
	<link rel="stylesheet" href="../../public/assetsForm/css/fontawesome-all.css">
	<link rel="stylesheet" href="../../public/assetsForm/css/style.css">
	<link rel="stylesheet" type="text/css" href="../../public/assetsForm/css/colors/switch.css">

	<?php include_once '../../config/templates/mainHead.php' ?>

	<!-- Color Alternatives -->
	<link href="../../public/assetsForm/css/colors/color-2.css" rel="alternate stylesheet" type="text/css" title="color-2">
	<link href="../../public/assetsForm/css/colors/color-3.css" rel="alternate stylesheet" type="text/css" title="color-3">
	<link href="../../public/assetsForm/css/colors/color-4.css" rel="alternate stylesheet" type="text/css" title="color-4">
	<link href="../../public/assetsForm/css/colors/color-5.css" rel="alternate stylesheet" type="text/css" title="color-5">
	<!-- ********************* FONT AWESOME 6.4.0 *********************************** -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<style>
		textarea.form-control {
			height: auto;
		}
		.position-relative {
			position: relative !important;
		}

		.form-group {
			margin-bottom: 1rem;
		}
	</style>
</head>

<body class="boxed-version">

	<!-- This code is use for color chooser, you can delete -->
	<!-- <div id="switch-color" class="color-switcher">
		<div class="open"><i class="fas fa-cog"></i></div>
		<h4>COLOR OPTION</h4>
		<ul>
			<li><a class="color-2" onclick="setActiveStyleSheet('color-2'); return false;" href="#"><i class="fas fa-cog"></i></a> </li>
			<li><a class="color-3" onclick="setActiveStyleSheet('color-3'); return false;" href="#"><i class="fas fa-cog"></i></a> </li>
			<li><a class="color-4" onclick="setActiveStyleSheet('color-4'); return false;" href="#"><i class="fas fa-cog"></i></a> </li>
			<li><a class="color-5" onclick="setActiveStyleSheet('color-5'); return false;" href="#"><i class="fas fa-cog"></i></a> </li>
		</ul>
	</div> -->
	<div class="clearfix">

	<div class="wrapper clearfix">
		<div class="wizard-part-title">
			<!-- <h3>Formulario de Alojamiento</h3> -->
			<object data="../../public/img/logo.svg" width="300"> </object>
		</div>

		<!-- DETERMINA LA CONDICION. CONSULT SOLO CONSULTA , EDITADMIN MODO ADMINISTRADOR... -->
		<input type="hidden" id="condition" value="<?php echo $condition?>">
	
		<!--multisteps-form-->
		<div class="multisteps-form">
	
			<!--progress bar-->
			<div class="row">

				<div class="col-12 col-lg-12 ml-auto mr-auto">
				<div class="d-flex justify-content-end mb-3 mg-r-90 ">

				<button type="button" class="btn btn-outline-info mg-r-10 d-none" onclick="copiarTexto()" id="botonCopiar" title="Copiar Invitación"><i class="fa-solid fa-share-nodes"></i> Copiar Invitación</button>

				<button type="button" class="btn btn-outline-danger d-none" onclick="enviarCorreoDatos()" id="botonEnviar" title="Enviar correo"><i class="far fa-envelope"></i> Enviar correo</button>
				</div>
            <div class="multisteps-form__progress">
						<button class="seccion-admin multisteps-form__progress-btn js-active">Administración</button>
						<button class="seccion-info multisteps-form__progress-btn">Información</button>

						<button class="multisteps-form__progress-btn">Casa</button>
						<button class="multisteps-form__progress-btn">Familia</button>
						<button class="multisteps-form__progress-btn">Transporte</button>

					</div>
					
				</div>
			
			</div>
			
			<!--form panels-->
			<div class="row">
				<div class="col-12 col-lg-12 m-auto">
					<form class="multisteps-form__form position-relative clearfix" id="wizard">
					
					<input type="hidden" id="idAloja" name="idAloja" value="<?php echo $idAloja ?>"></input> <!-- ID DE EDICION -->
					<input type="hidden" id="idAlojaEncrypt" name="idAlojaEncrypt" value="<?php echo $idAlojaEncrypt ?>"></input> <!-- ID DE EDICION -->

                        						<!--single form panel-->
						<div class="seccion-admin multisteps-form__panel js-active" data-animation="slideVert">
							<div class="inner position-relative pb-100">
								<div class="wizard-topper">
									<!--<div class="wizard-progress">
										<span>1 of 5 Completados</span>
										<div class="progress">
											<div class="progress-bar" ></div>
										</div>
									</div> -->
								</div>
								<div class="wizard-content-item text-center">
									<h2>Administración</h2>
									<!-- <p>Datos para la administración</p> -->
								</div>
								<div class="wizard-content-form">
									<div class="wizard-form-field">
										<div class="row">
											
											<div class="col-12 col-md-12 wizard-form-input position-relative form-group has-float-label">
												<i data-toggle="tooltip" data-placement="bottom" title="Identificador del Alojamiento" class="fa fa-house-chimney-medical"></i>
												<input type="text" id="idAlojamientoTexto" name="idAlojamientoTexto" class="form-control" placeholder="Identificador de Alojamiento" value="<?php echo $datosAlojamiento[0]['idAlojamientoTexto'] ?>">
												<label>Identificador de Alojamiento</label>
											</div>
											
										</div>
										<div class="row">
											
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<div class="wizard-form-input position-relative form-group has-float-label">
													<textarea id="hospitalPublicAloja" name="hospitalPublicAloja" class="form-control" rows="4" maxlength='75' placeholder="Dirección hospital público" value="<?php echo $datosAlojamiento[0]['hospitalPublicAloja'] ?>"><?php echo $datosAlojamiento[0]['hospitalPublicAloja'] ?></textarea>
													<label for="textDatosPublicAloja">Hospital público</label>
												</div>
											</div>
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<div class="wizard-form-input position-relative form-group has-float-label">
													<textarea id="consultAloja" name="consultAloja" class="form-control" rows="4" maxlength='150' placeholder="Dirección centro médico más cercano" value="<?php echo $datosAlojamiento[0]['consultAloja'] ?>"><?php echo $datosAlojamiento[0]['consultAloja'] ?></textarea>
													<label for="textDatosPublicAloja">Consultorio</label>
												</div>
											</div>
											
										</div>
										<div class="row">
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<div class="wizard-form-input position-relative form-group has-float-label">
													<textarea  id="hospitalPrivAloja" name="hospitalPrivAloja"  rows="4" maxlength='150'  class="form-control" placeholder="Dirección hospital privado más cercano" value="<?php echo $datosAlojamiento[0]['hospitalPrivAloja'] ?>"><?php echo $datosAlojamiento[0]['hospitalPrivAloja'] ?></textarea>
													<label for="textDatosPublicAloja">Hospital privado</label>
												</div>
											</div>
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<div class="wizard-form-input position-relative form-group has-float-label">
													<textarea type="text" id="pagoAloja" rows="4" maxlength='150'  name="pagoAloja" class="form-control" placeholder="Cuenta bancaria de la familia"  value="<?php echo $datosAlojamiento[0]['pagoAloja'] ?>"><?php echo $datosAlojamiento[0]['pagoAloja'] ?></textarea>
													<label for="textDatosPublicAloja">Cuenta bancaria de la familia</label>
												</div>
											</div>
											
											
										</div>
										<div class="row">
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<i data-toggle="tooltip" data-placement="bottom" title="Breve descripción del motivo de baja del alojamiento" class="fa fa-info"></i>
												<input type="text" id="motvBajaAloja" name="motvBajaAloja" class="form-control" placeholder="Motivo de baja" value="<?php echo $datosAlojamiento[0]['motvBajaAloja'] ?>">
												<label>Motivo de baja</label>
											</div>
											<div class="col-12 col-md-6">
												<div class="wizard-form-input position-relative form-group has-float-label mt-0 n-select-option">
													<i data-toggle="tooltip" data-placement="bottom" title="Estado del alojamiento. Alta - El alojamiento está dado de alta. Baja - El alojamiento se ha dado de baja. En ese caso complementar motivo de baja." class="fa fa-info"></i>
													<select id="estAloja" name="estAloja" class="form-control">
														<option>Estado del alojamiento</option>
														<option value="0" <?php if ($datosAlojamiento[0]['estAloja'] == 0) echo 'selected'; ?>>Baja</option>
														<option value="1" <?php if ($datosAlojamiento[0]['estAloja'] == 1) echo 'selected'; ?>>Alta</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="wizard-footer">
									<div class="wizard-imgbg float-start">
										<img src="../../public/assetsForm/img/v5.png" alt="">
									</div>
									<div class="actions">

										<ul>
											<li><span class="js-btn-next" title="NEXT">Siguiente <i class="fa fa-arrow-right"></i></span></li>
										</ul>
									</div>

								</div>
								<ul>


							</div>
						</div>

						<!--single form panel-->
						<div class="seccion-info multisteps-form__panel" data-animation="slideVert">
							<div class="inner position-relative pb-100">
								<div class="wizard-topper">
									<div class="wizard-progress">
										<span>1 de 4 Completados</span>
										<div class="progress">
											<div class="progress-bar">
											</div>
										</div>
									</div>
								</div>
								<div class="wizard-content-item text-center">
									<h2>Datos generales</h2>
									<!-- <p class="subtitulo">Completa este formulario para proporcionarnos tus datos personales.</p> -->
								</div>
								
								<div class="wizard-content-form">
									<div class="wizard-form-field">
										<div class="row">
											<div class="col-12 col-md-12">
												<div class="n-activity tooltip-info">
													<label>
														<i data-toggle="tooltip" data-placement="bottom" title="Si pertenece a una empresa marque la casilla" class="fa fa-info"></i>
														<input type="checkbox" class="net-check" id="esEmpresa">
														<span class="n-title">¿Es una empresa?</span>
														<span class="net-check-border"></span>
													</label>
												</div>
											</div>
										</div><br><br>
										<div class="row">
											<div id="divNombre"class="col-12 col-md-4 wizard-form-input position-relative form-group has-float-label">
												<i data-toggle="tooltip" data-placement="bottom" title="En caso de local o negocio dejar el campo vacio." class="fa fa-info"></i>
												<input type="text" id="nombreAloja" maxlength="100" name="nombreAloja" class="form-control" placeholder="Nombre"  value="<?php echo $datosAlojamiento[0]['nombreAloja'] ?>">
												<label>Nombre</label>
											</div>
											<div id="divApe" class="col-12 col-md-8 wizard-form-input position-relative form-group has-float-label">
												<i data-toggle="tooltip" data-placement="bottom" title="En caso de local o negocio poner el nombre a facturar." class="fa fa-info"></i>
												<input type="text" name="apeAloja" class="form-control" maxlength="90" placeholder="Apellidos"  value="<?php echo $datosAlojamiento[0]['apeAloja'] ?>">
												<label>Apellidos</label>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-4">
												<div class="wizard-form-input position-relative form-group has-float-label mt-0 n-select-option">

													<select id="selectTipoAloja" name="selectTipoAloja" class="form-control">
														<option value="0">Tipo de Alojamiento</option>
														<?php
														// Consulta a la base de datos u obtención de datos
														$options = $tiposAloja->listarTiposAloja(); // Función para obtener los tipos de alojamiento
														$valorSeleccionado = $datosAlojamiento[0]['idTipoAloja_TipoAloja']; // Función hipotética para obtener el valor seleccionado

														foreach ($options as $option) {
															// Generar una opción por cada elemento en $opciones
															$selected = ($option['idTiposAloja'] == $valorSeleccionado) ? 'selected' : '';
															echo '<option value="' . $option['idTiposAloja'] . '" ' . $selected . '>' . $option['descrTiposAloja'] . '</option>';
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-12 col-md-4 wizard-form-input position-relative form-group has-float-label">
												<input type="email" autocomplete="off" maxlength="60" id="emailAloja" class="form-control" name="emailAloja" placeholder="Correo" value="<?php echo $datosAlojamiento[0]['emailAloja'] ?>">
												<label>Correo</label>
											</div>
											<div class="col-12 col-md-4 wizard-form-input position-relative form-group has-float-label">
												<input type="text" id="nifAloja" maxlength="9" class="form-control" name="nifAloja" placeholder="NIF/DNI" value="<?php echo $datosAlojamiento[0]['nifAloja'] ?>">
												<label>NIF/DNI</label>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6">
												<div class="wizard-form-input position-relative form-group has-float-label">
													<input type="tel" maxlength="14" class="form-control" name="telAloja" id="telAloja" placeholder="Teléfono Fijo"  value="<?php echo $datosAlojamiento[0]['telAloja'] ?>">
													<label>Teléfono Fijo</label>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="wizard-form-input position-relative form-group has-float-label">
													<input type="tel" maxlength="15" class="form-control" name="movilAloja" id="movilAloja" placeholder="Teléfono Móvil" value="<?php echo $datosAlojamiento[0]['movilAloja'] ?>">
													<label>Teléfono Móvil</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="cold-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="text" class="form-control" maxlength="60" name="dirAloja" id="dirAloja" placeholder="Dirección"  value="<?php echo $datosAlojamiento[0]['dirAloja'] ?>">
												<label>Dirección</label>
											</div>
											<div class="cold-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="text" class="form-control" maxlength="40" name="poblaAloja" id="poblaAloja" placeholder="Población" value="<?php echo $datosAlojamiento[0]['poblaAloja'] ?>">
												<label>Población</label>
											</div>
										</div>
										<div class="row">
											<div class="cold-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="text" class="form-control" maxlength="40" name="proviAloja" id="proviAloja" placeholder="Provincia" value="<?php echo $datosAlojamiento[0]['proviAloja'] ?>">
												<label>Provincia</label>
											</div>
											<div class="cold-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="text" class="form-control" maxlength="5" name="cpAloja" id="cpAloja" placeholder="Código Postal"  value="<?php echo $datosAlojamiento[0]['cpAloja'] ?>">
												<label>Código Postal</label>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6 wizard-form-field">
												<div class="wizard-form-input position-relative form-group has-float-label">
													<textarea name="textDatosPublicAloja" maxlength="200" id="textDatosPublicAloja" class="form-control tx-medium tx-20" placeholder="     Observaciones públicas" value="<?php echo $datosAlojamiento[0]['textDatosPublicAloja'] ?>"><?php echo $datosAlojamiento[0]['textDatosPublicAloja'] ?></textarea>
													<label for="textDatosPublicAloja">Observaciones públicas</label>
												</div>
											</div>
											<div class="col-12 col-md-6 wizard-form-field">
												<div class="wizard-form-input position-relative form-group has-float-label">

													<textarea name="textDatosPrivateAloja" maxlength="200" id="textDatosPrivateAloja" class="form-control tx-medium tx-20" placeholder="     Observaciones privadas"  value="<?php echo $datosAlojamiento[0]['textDatosPrivateAloja'];?>"><?php echo $datosAlojamiento[0]['textDatosPrivateAloja'];?></textarea >
													<label for="textDatosPrivateAloja">Observaciones privadas</label>
												</div>
											</div>
										</div>

									</div>
								</div>

								<div class="wizard-footer">
									<div class="wizard-imgbg">
										<img src="../../public/assetsForm/img/v3.png" alt="">
									</div>
									<div class="actions">
										<ul>
											<!-- <li><button type="button" class="tx-boton-form d-none" onclick="enviarCorreoDatos();" id="botonEnviar" title="Enviar correo">Enviar Correo</button></li> -->
											<!-- <li><span class="js-btn-prev tx-danger" title="Volver atras"><i class="fa fa-arrow-left"></i> Anterior</span></li> -->
											<li><span class="js-btn-prev" id="back-button" title="BACK"><i class="fa fa-arrow-left"></i> Anterior</span></li>
											<li><span class="js-btn-next" title="NEXT">Siguiente <i class="fa fa-arrow-right"></i></span></li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<!--single form panel-->
						<div class="multisteps-form__panel" data-animation="slideVert">
							<div class="inner position-relative pb-100">
								<div class="wizard-topper">
									<div class="wizard-progress">
										<span>2 de 4 Completados</span>
										<div class="progress">
											<div class="progress-bar" style="width: 45%;"></div>
										</div>
									</div>
								</div>
								<div class="wizard-content-item text-center">
									<h2>Casa</h2>
									<!-- <p class="subtitulo">Completa este formulario para proporcionarnos información sobre tu casa. Incluye detalles en las observaciones.</p> -->
								</div>
								<div class="wizard-content-form">
									<div class="wizard-form-field">
										<div class="row">
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="text" name="metrosAloja" oninput="validarNumero(this)" maxlength="4" id="metrosAloja" class="form-control" placeholder="Metros Cuadrados" value="<?php echo $datosAlojamiento[0]['metrosAloja'] ?>">
												<label>Metros Cuadrados</label>
											</div>
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="text" name="wcAloja"  oninput="validarNumero(this)" maxlength="2" id="wcAloja" class="form-control" placeholder="Cuartos de baño"  value="<?php echo $datosAlojamiento[0]['wcAloja'] ?>">
												<label>Cuartos de baño</label>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6">
												<div class="n-summary">
													<span>Acceso a Internet</span>
													<?php
														// Si existe y no está vacío, usamos el valor real
														// Si no existe (es crear), asignamos por defecto 1 (Sí)
														$interAloja = isset($datosAlojamiento[0]['interAloja']) 
															? $datosAlojamiento[0]['interAloja'] 
															: 1;
														?>
													<label>
														<input type="radio" value="1" name="interAloja" <?php if ($interAloja == 1) echo 'checked'; ?>>
														<span class="checkmark">Si</span>
													</label>

													<label>
														<input type="radio" value="0" name="interAloja" <?php if ($interAloja == 0) echo 'checked'; ?>>
														<span class="checkmark">No</span>
													</label>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="n-summary">
													<span>Se permite fumar</span>
													
													<label>
														<input type="radio" name="fumaAloja" value="1" <?php if ($datosAlojamiento[0]['fumaAloja'] == 1) echo 'checked'; ?> >
														<span class="checkmark">Si</span>
													</label>
													<label>
														<input type="radio" name="fumaAloja" value="0" <?php if ($datosAlojamiento[0]['fumaAloja'] == 0) echo 'checked'; ?> >
														<span class="checkmark">No</span>
													</label>
												</div>
											</div>
										</div>
										<br>
										<div class="row">
											<div id="dondeFumar" class="col-md-12 wizard-form-input position-relative form-group has-float-label <?php if ($datosAlojamiento[0]['fumaAloja'] == 0) echo "d-none" ?>">
												<i data-toggle="tooltip" data-placement="bottom" title="Espacios de la casa o alojamiento donde está permitido fumar." class="fa fa-info"></i>
												<input type="text" maxlength="120" class="form-control" name="descrFumaAloja" id="descrFumaAloja" placeholder="Donde se permite fumar"  value="<?php echo $datosAlojamiento[0]['descrFumaAloja'] ?>">
												<label>Donde se permite fumar</label>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-4 wizard-form-input position-relative form-group has-float-label">
												<input  type="text" oninput="validarNumero(this)" maxlength="2"   id="HabIndiAloja" class="form-control" name="HabIndiAloja" placeholder="Habitaciones Individuales" value="<?php echo $datosAlojamiento[0]['HabIndiAloja'] ?>">
												<label>Habitaciones Individuales</label>
											</div>
											<div class="col-12 col-md-4 wizard-form-input position-relative form-group has-float-label">
												<input  type="text" oninput="validarNumero(this)" maxlength="2" id="HabDobleAloja" class="form-control" name="HabDobleAloja" placeholder="Habitaciones Dobles"  value="<?php echo $datosAlojamiento[0]['HabDobleAloja'] ?>">
												<label>Habitaciones Dobles</label>
											</div>
											<div class="col-12 col-md-4 wizard-form-input position-relative form-group has-float-label">
												<input  type="text" oninput="validarNumero(this)" maxlength="2" id="HabTripleAloja" class="form-control" name="HabTripleAloja" placeholder="Habitaciones Triples"  value="<?php echo $datosAlojamiento[0]['HabTripleAloja'] ?>">
												<label>Habitaciones Triples</label>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6">
												<div class="wizard-form-input position-relative form-group has-float-label">
													<i data-toggle="tooltip" data-placement="bottom" title="Breve descripción del horario de las comidas." class="fa fa-info"></i>
													<input type="text" maxlength="200"  class="form-control" name="comidasAloja" id="comidasAloja" placeholder="Horario de Comidas"  value="<?php echo $datosAlojamiento[0]['comidasAloja'] ?>">
													<label>Horario de Comidas</label>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="wizard-form-input position-relative form-group has-float-label">
													<i data-toggle="tooltip" data-placement="bottom" title="Breve descripción de las mascotas en la casa, enumerar todas ellas y su especie." class="fa fa-info"></i>
													<input type="text" maxlength="130"  class="form-control" name="descrAnimalesAloja" id="descrAnimalesAloja" placeholder="Mascotas"  value="<?php echo $datosAlojamiento[0]['descrAnimalesAloja'] ?>">
													<label>Mascotas</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 wizard-form-field">
												<div class="wizard-form-input position-relative form-group has-float-label">
													<textarea name="textCasaAloja" maxlength="300"  id="textCasaAloja" class="form-control tx-medium tx-20" placeholder="Observaciones de la casa" value="<?php echo $datosAlojamiento[0]['textCasaAloja'] ?>"><?php echo $datosAlojamiento[0]['textCasaAloja'] ?></textarea>
													<label for="textCasaAloja">Observaciones de la casa</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="wizard-footer">
									<div class="wizard-imgbg">
										<img src="../../public/assetsForm/img/v2.png" alt="">
									</div>
									<div class="actions">
										<ul>
											<li><span class="js-btn-prev" title="BACK"><i class="fa fa-arrow-left"></i> Anterior</span></li>
											<li><span class="js-btn-next" title="NEXT">Siguiente <i class="fa fa-arrow-right"></i></span></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!--single form panel-->
						<div class="multisteps-form__panel" data-animation="slideVert">
							<div class="inner position-relative pb-100">
								<div class="wizard-topper">
									<div class="wizard-progress">
										<span>3 de 4 Completados</span>
										<div class="progress">
											<div class="progress-bar" style="width: 85%;"></div>
										</div>
									</div>
								</div>
								<div class="wizard-content-item text-center">
									<h2>Familia</h2>
								</div>

								<div class="wizard-content-form">
									<div class="wizard-form-field">
										<div class="row">
											<p class="tx-20"><b class="tx-danger">(*)</b> Complete estos campos solo si fuese necesario.</p> 

										</div>
										<div class="row">
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="text" maxlength="130"  name="nomPadreAloja" id="nomPadreAloja"  class="form-control" placeholder="Nombre del Padre"  value="<?php echo $datosAlojamiento[0]['nomPadreAloja'] ?>">
												<label>Nombre del Padre</label>
											</div>
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="text" maxlength="130"  name="nomMadreAloja" id="nomMadreAloja" class="form-control" placeholder="Nombre de la Madre"  value="<?php echo $datosAlojamiento[0]['nomMadreAloja'] ?>">
												<label>Nombre de la Madre</label>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="date" id="nacPadreAloja" name="nacPadreAloja" class="form-control" placeholder="Fecha de nacimiento del Padre" value="<?php echo $datosAlojamiento[0]['nacPadreAloja'] ?>">
												<label>Fecha de nacimiento del Padre</label>
											</div>
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="date" name="nacMadreAloja" id="nacMadreAloja" class="form-control" placeholder="Fecha de nacimiento de la Madre" value="<?php echo $datosAlojamiento[0]['nacMadreAloja'] ?>">
												<label>Fecha de nacimiento de la Madre</label>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="text" maxlength="120"  id="profPadreAloja" name="profPadreAloja" class="form-control" placeholder="Profesión del Padre" value="<?php echo $datosAlojamiento[0]['profPadreAloja'] ?>">
												<label>Profesión del Padre</label>
											</div>
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="text" maxlength="120"  name="profMadreAloja" id="profMadreAloja" class="form-control" placeholder="Profesión de la Madre"  value="<?php echo $datosAlojamiento[0]['profMadreAloja'] ?>">
												<label>Profesión de la Madre</label>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6 wizard-form-field">
												<div class="wizard-form-input position-relative form-group has-float-label">
													<textarea name="descrHijosVivenAloja" maxlength="200"  id="descrHijosVivenAloja" class="form-control tx-medium tx-20" placeholder="Otros miembros de la familia" value="<?php echo $datosAlojamiento[0]['descrHijosVivenAloja'] ?>"><?php echo $datosAlojamiento[0]['descrHijosVivenAloja'] ?></textarea>
													<label for="descrHijosVivenAloja">Otros miembros de la familia</label>
												</div>
											</div>
											<div class="col-12 col-md-6 wizard-form-field">
												<div class="wizard-form-input position-relative form-group has-float-label">
													<textarea name="aficAloja" maxlength="300"  id="aficAloja" class="form-control tx-medium tx-20" placeholder="Aficiones en casa" value="<?php echo $datosAlojamiento[0]['aficAloja'] ?>"><?php echo $datosAlojamiento[0]['aficAloja'] ?></textarea>
													<label for="aficAloja">Aficiones en casa</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<br>
								<div class="wizard-footer">
									<div class="wizard-imgbg">
										<img src="../../public/assetsForm/img/vi1.png" width="500" alt="">
									</div>
									<div class="actions">
										<ul>
											<li><span class="js-btn-prev" title="BACK"><i class="fa fa-arrow-left"></i> Anterior</span></li>
											<li><span class="js-btn-next" title="NEXT">Siguiente <i class="fa fa-arrow-right"></i></span></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!--single form panel-->
						<div class="multisteps-form__panel" data-animation="slideVert">
							<div class="inner position-relative pb-100">
								<div class="wizard-topper">
									<div class="wizard-progress">
										<span>4 de 4 Completados</span>
										<div class="progress">
											<div class="progress-bar" style="width: 100%;"></div>
										</div>
									</div>
								</div>
								<div class="wizard-content-item text-center">
									<h2>Transporte</h2>
									<!-- <p class="subtitulo">Proporciona los detalles de transporte de tu alojamiento, intenta ser lo más preciso posible.</p> -->
								</div>
								<div class="wizard-content-form">
									<div class="wizard-form-field">
										<div class="row">
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<i data-toggle="tooltip" data-placement="bottom" title="Ubicacion del alojamiento, link de google maps " class="fa fa-info"></i>
												<input type="text" id="linkSituacionAloja" maxlength="240"  name="linkSituacionAloja" class="form-control" placeholder="Ubicación de Google Maps" value="<?php echo $datosAlojamiento[0]['linkSituacionAloja'] ?>">
												<label>Ubicación de Google Maps</label>
											</div>
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input  type="text" oninput="validarNumero(this)" maxlength="3"  id="apieAloja"  name="apieAloja" class="form-control" placeholder="Minutos a pie de la escuela"  value="<?php echo $datosAlojamiento[0]['apieAloja'] ?>" min="0">
												<label>Minutos a pie de la escuela</label>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="text" name="lineaAutobusAloja"  maxlength="15"  id="lineaAutobusAloja" class="form-control" placeholder="Linea de Autobus"  value="<?php echo $datosAlojamiento[0]['lineaAutobusAloja'] ?>">
												<label>Linea de Autobus</label>
											</div>
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input  type="text" oninput="validarNumero(this)" maxlength="3"  id="minAutobusAloja" name="minAutobusAloja" class="form-control" placeholder="Minutos en autobus de la escuela"  value="<?php echo $datosAlojamiento[0]['minAutobusAloja'] ?>" min="0">
												<label>Minutos en autobus de la escuela</label>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input type="text"  maxlength="15"  id="lineaMetroAloja" name="lineaMetroAloja" class="form-control" placeholder="Linea de Metro"  value="<?php echo $datosAlojamiento[0]['lineaMetroAloja'] ?>">
												<label>Linea de Metro</label>
											</div>
											<div class="col-12 col-md-6 wizard-form-input position-relative form-group has-float-label">
												<input  type="text" oninput="validarNumero(this)" maxlength="3"  id="minMetroAloja"  name="minMetroAloja" class="form-control" placeholder="Minutos en metro de la escuela"  value="<?php echo $datosAlojamiento[0]['minMetroAloja'] ?>" min="0">
												<label>Minutos en metro de la escuela</label>
											</div>
										</div>
									</div>
								</div>
								<div class="wizard-footer">
									<div class="wizard-imgbg">
										<img src="../../public/assetsForm/img/v4.png" alt="">
									</div>
									<div class="actions">
										<ul>
											<li><span class="js-btn-prev" title="BACK"><i class="fa fa-arrow-left"></i> Anterior</span></li>
											<li><button type="submit" formnovalidate id="submit-form" title="Guardar">Guardar <i class="fa fa-arrow-right"></i></button></li>
										</ul>
									</div>
								</div>

							</div>
						</div>


					</form>
				</div>
			</div>
		</div>

	</div>
    </div>

	<script src="../../public/assetsForm/js/jquery-3.3.1.min.js"></script>
 <script src="../../public/js/libs/select2/dist/js/select2.full.min.js"></script>
 <script src="../../public/js/libs/select2/dist/js/select2.min.js"></script>
	<script src="../../public/assetsForm/js/popper.min.js"></script>
	<script src="../../public/assetsForm/js/bootstrap.min.js"></script>
	<script src="../../public/assetsForm/js/switch.js"></script>
	<script src="../../public/assetsForm/js/main.js"></script>

	<!-- Summernote // EVITA BUG SUMMERNOTE (NO SE USA AQUI) -->
	<script src="../../public/js/libs/summernote/dist/summernote-bs4.min.js"></script>

	<!-- **************************** NUEVOS DATATABLES ***************************************************-->
	<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

	<!-- TOAST -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	<!-- SWEET ALERT -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- JS PERSONALIZADO -->
	<script src="alojaIndex.js"></script>
	<script>bloquearDatos();</script>
	<script>

		$("#esEmpresa").on("change",function(){
			if (this.checked) {
				// Código a ejecutar cuando se marca la opciónnombreAloja
				$("#nombreAloja").attr("placeholder","Nombre empresa");
				$("#divNombre").removeClass("col-md-4");
				$("#divNombre").addClass("col-md-12");
				$("#divApe").addClass("d-none");
				// Aquí puedes agregar el código que deseas ejecutar cuando se marque la opción
			} else {
				// Código a ejecutar cuando se desmarca la opción
				$("#nombreAloja").attr("placeholder","Nombre");
				$("#divApe").removeClass("d-none");
				$("#divNombre").addClass("col-md-4");
				$("#divNombre").removeClass("col-md-12");
				// Aquí puedes agregar el código que deseas ejecutar cuando se desmarque la opción
			}
		});

		function copiarTexto() {
			let texto = "<?php echo $texto; ?>";

			if (navigator.clipboard && navigator.clipboard.writeText) {
				// Método moderno
				navigator.clipboard.writeText(texto).then(() => {
				});
			} else {
				// Método antiguo (fallback)
				let inputTemp = document.createElement("input");
				inputTemp.value = texto;
				document.body.appendChild(inputTemp);
				inputTemp.select();
				document.execCommand("copy");
				document.body.removeChild(inputTemp);
			}
				toastr.success('¡Enlace copiado!')
			}

	</script>


</body>

</html>