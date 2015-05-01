<script language="javascript" src="<?php echo base_url();?>js/Jquery.js"></script>
		<!--
		<link type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" />	
-->

<script type="text/javascript">
$(document).ready(function() {
	
	$('#f_var_nombre_cliente').autocomplete({
		source:'<?php echo site_url('controladores-cobrador/controlador_administracion_creditos/autocompletar_contacto'); ?>',
		select: function(event, ui) {
			$('#f_var_id_cliente').val(ui.item.id_cliente);
			}
	});		
      $( "#boton_aceptar" )
      .button()
      .click(function() {

        $( "#confirmar-aceptar" ).dialog( "open" );

      });
	$( "#f_var_cant_cuotas" ).click(function() {
			
			if($("#f_var_tipo_credito").val() == ''){
				$("#error-completar-tipo-credito").dialog("open");
			}
	});
	$( "#f_var_monto_prestamo" ).change(function() {
			var monto_cuota;
			if($("#f_var_cant_cuotas").val() != ''){
				if($("#f_var_cant_cuotas").val() > 13){
					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.92)/$("#f_var_cant_cuotas").val());
					monto_cuota	= Math.ceil((monto_cuota)/10)*10;
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);
					//$("#f_monto_cuota").html('');
					$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');


				} else if($("#f_var_cant_cuotas").val() > 6){
					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.69)/$("#f_var_cant_cuotas").val());
					monto_cuota	= Math.ceil((monto_cuota)/10)*10;
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);
					//$("#f_monto_cuota").html('');
					$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');
				} else {
					if($("#f_var_monto_prestamo").val() <= 1000){

					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.5)/$("#f_var_cant_cuotas").val());
					monto_cuota	= Math.ceil((monto_cuota)/10)*10;
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);
					//$("#f_monto_cuota").html('');
					$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');
					} else {

					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.32)/$("#f_var_cant_cuotas").val());
					monto_cuota	= Math.ceil((monto_cuota)/10)*10;
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);	
					//$("#f_monto_cuota").html('');
					$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');
					}

				}
			}
	});
	/*
	$( "#f_var_monto_prestamo" ).blur(function() {
			var monto_cuota;
			if($("#f_var_cant_cuotas").val() != ''){
				if($("#f_var_cant_cuotas").val() > 13){
					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.92)/$("#f_var_cant_cuotas").val());
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);
					$("#f_var_cant_cuotas").val('');
					$("#f_monto_cuota").html('');
					

				} else if($("#f_var_cant_cuotas").val() >= 6){
					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.69)/$("#f_var_cant_cuotas").val());
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);
					$("#f_monto_cuota").html('');
					
				} else {
					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.32)/$("#f_var_cant_cuotas").val());
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);	
					$("#f_monto_cuota").html('');
				}
			}
			
	});*/
			var $tipo = $('#f_var_tipo_credito'), $cuota_semanal = $('#f_var_cant_cuotas_sem'), $cuota_quincenal = $('#f_var_cant_cuotas_qui') ;

			$tipo.change(function () {
				if ($tipo.val() == '') {
					$("#combo_cuotas_sem").hide();
					$("#combo_cuotas_qui").hide();
					$("#text_cuotas_manual").hide();
					$("#boton_cuotas_manual").hide();
					$("#boton_cuotas_auto").hide();
					$("#f_var_monto_prestamo").hide();
					$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');
					$('#f_var_cant_cuotas_qui').find('option:first').attr('selected', 'selected').parent('select');
				}					

				if ($tipo.val() == '1') {
					$("#combo_cuotas_sem").show();
					$("#combo_cuotas_qui").hide();
					$("#f_var_monto_prestamo").show();
					$("#boton_cuotas_manual").show();
					$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');
					$('#f_var_cant_cuotas_qui').find('option:first').attr('selected', 'selected').parent('select');

				}
				if ($tipo.val() == '2') {
					$("#combo_cuotas_sem").hide();
					$("#combo_cuotas_qui").show();
					$("#boton_cuotas_manual").hide();
					$("#text_cuotas_manual").hide();
					$("#boton_cuotas_auto").hide();
					$("#f_var_monto_prestamo").show();
					$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');
					$('#f_var_cant_cuotas_qui').find('option:first').attr('selected', 'selected').parent('select');
				}

			}).trigger('change');

	$( "#f_var_monto_prestamo" ).focus(function() {
			if($("#f_var_tipo_credito").val() == ''){
				$("#error-completar-tipo-credito").dialog("open");
			}
	});


	$( "#f_var_cant_cuotas" ).focus(function() {
			$("#combo_cuotas_sem").hide();			
			$("#boton_cuotas_auto").show();

	});

	$( "#boton_cuotas_auto" ).click(function() {
			$("#combo_cuotas_sem").show();			
			$("#text_cuotas_manual").hide();
			$("#boton_cuotas_manual").show();
			$("#boton_cuotas_auto").hide();
			$("#f_monto_cuota").html('');
	});

	$( "#boton_cuotas_manual" ).click(function() {
			$("#combo_cuotas_sem").hide();			
			$("#text_cuotas_manual").show();
			$("#boton_cuotas_manual").hide();
			$("#boton_cuotas_auto").show();
			$("#f_var_cant_cuotas").val('');
			$("#f_monto_cuota").html('');
	});


	$( "#f_var_cant_cuotas" ).change(function() {
			var monto_cuota;
			if($("#f_var_monto_prestamo").val() != ''){
				if($("#f_var_cant_cuotas").val() > 13){
					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.92)/$("#f_var_cant_cuotas").val());
					monto_cuota	= Math.ceil((monto_cuota)/10)*10;
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);
					$("#combo_cuotas_sem").hide();


				} else if($("#f_var_cant_cuotas").val() > 6){
					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.69)/$("#f_var_cant_cuotas").val());
					monto_cuota	= Math.ceil((monto_cuota)/10)*10;
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);
					$("#combo_cuotas_sem").hide();


				} else {
					if($("#f_var_monto_prestamo").val() <= 1000){

					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.5)/$("#f_var_cant_cuotas").val());
					monto_cuota	= Math.ceil((monto_cuota)/10)*10;
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);
					//$("#f_monto_cuota").html('');
					$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');
					} else {

					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.32)/$("#f_var_cant_cuotas").val());
					monto_cuota	= Math.ceil((monto_cuota)/10)*10;
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);	
					//$("#f_monto_cuota").html('');
					$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');
					}

				}
			} else {
				$("#error-completar-monto-credito").dialog("open");				
				$('#f_var_cant_cuotas').find('option:first').attr('selected', 'selected').parent('select');
				$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');
				$('#f_var_cant_cuotas_qui').find('option:first').attr('selected', 'selected').parent('select');

			}
	});



	$( "#f_var_cant_cuotas_sem" ).change(function() {
			var monto_cuota;
		if($("#f_var_cant_cuotas_sem").val() != ''){	
			if($("#f_var_monto_prestamo").val() != ''){
				if($("#f_var_cant_cuotas_sem").val() > 13){
					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.92)/$("#f_var_cant_cuotas_sem").val());
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);
					$("#boton_cuotas_manual").show();
					$("#f_var_cant_cuotas").val($("#f_var_cant_cuotas_sem").val());

				} else if($("#f_var_cant_cuotas_sem").val() > 9){
					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.69)/$("#f_var_cant_cuotas_sem").val());
					monto_cuota	= Math.ceil((monto_cuota)/10)*10;
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);
					$("#f_var_cant_cuotas").val($("#f_var_cant_cuotas_sem").val());

				} else {
					if($("#f_var_cant_cuotas_sem").val() > 6){
					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.45)/$("#f_var_cant_cuotas_sem").val());
					monto_cuota	= Math.ceil((monto_cuota)/10)*10;
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);
					$("#f_var_cant_cuotas").val($("#f_var_cant_cuotas_sem").val());
					} else {
						if(($("#f_var_monto_prestamo").val() <= 1000)&&($("#f_var_cant_cuotas_sem").val() > 4)){

							monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.5)/$("#f_var_cant_cuotas_sem").val());
							monto_cuota	= Math.ceil((monto_cuota)/10)*10;
							$("#f_monto_cuota").html("$"+monto_cuota);
							$("#f_var_monto_cuota").val(monto_cuota);
							$("#f_var_cant_cuotas").val($("#f_var_cant_cuotas_sem").val());
						///$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');

						} else {
							monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.26)/$("#f_var_cant_cuotas_sem").val());
							monto_cuota	= Math.ceil((monto_cuota)/10)*10;
							$("#f_monto_cuota").html("$"+monto_cuota);
							$("#f_var_monto_cuota").val(monto_cuota);
							$("#f_var_cant_cuotas").val($("#f_var_cant_cuotas_sem").val());
						}					
					}	
					//$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');

				}

			} else {
				$("#error-completar-monto-credito").dialog("open");				
				$('#f_var_cant_cuotas').find('option:first').attr('selected', 'selected').parent('select');
				$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');
				$('#f_var_cant_cuotas_qui').find('option:first').attr('selected', 'selected').parent('select');

			}
		} else {
			$("#f_monto_cuota").html("");
		}
	});
	  
 	$( "#f_var_cant_cuotas_qui" ).change(function() {
			var monto_cuota;
			$("#text_cuotas_manual").hide();
			$("#boton_cuotas_manual").hide();
			$("#boton_cuotas_auto").hide();
			if($("#f_var_monto_prestamo").val() != ''){
				if($("#f_var_cant_cuotas_qui").val() > 6){
					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.92)/$("#f_var_cant_cuotas_qui").val());
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);
					$("#f_var_cant_cuotas").val($("#f_var_cant_cuotas_qui").val());

				} else {
					if($("#f_var_monto_prestamo").val() == 1000){

					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.5)/$("#f_var_cant_cuotas").val());
					monto_cuota	= Math.ceil((monto_cuota)/10)*10;
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);
					//$("#f_monto_cuota").html('');
					$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');
					} else {

					monto_cuota = Math.ceil(($("#f_var_monto_prestamo").val()*1.32)/$("#f_var_cant_cuotas").val());
					monto_cuota	= Math.ceil((monto_cuota)/10)*10;
					$("#f_monto_cuota").html("$"+monto_cuota);
					$("#f_var_monto_cuota").val(monto_cuota);	
					//$("#f_monto_cuota").html('');
					$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');
					}

				}
			} else {
				$("#error-completar-monto-credito").dialog("open");	
				$('#f_var_cant_cuotas').find('option:first').attr('selected', 'selected').parent('select');
				$('#f_var_cant_cuotas_sem').find('option:first').attr('selected', 'selected').parent('select');
				$('#f_var_cant_cuotas_qui').find('option:first').attr('selected', 'selected').parent('select');
			}
	});

 
    $("#error-completar").dialog({
      autoOpen: false,
      modal: true,
      buttons: {
        Aceptar: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $("#error-completar-tipo-credito").dialog({
      autoOpen: false,
      modal: true,
      buttons: {
        Aceptar: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $("#error-completar-monto-credito").dialog({
      autoOpen: false,
      modal: true,
      buttons: {
        Aceptar: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $( "#confirmar-aceptar" ).dialog({
      autoOpen: false,
      height: 300,
      width: 400,
      modal: true,
	  resizable: false,
	  draggable: false,
      buttons: {
        "Aceptar": function() {
			//var id_articulo = $("#var_id_articulo").val();
			$('#formulario_credito').submit();
			//window.location.href = "http://www.c-on.com.ar/sistemamyf/index.php/controlador_admin_compras/realizar_rechazo_de_lotes/"+id_articulo;
		//alert(id_articulo);
        },
        Cancelar: function() {
          $( this ).dialog( "close" );
        }
      }
    });
    });
	
    function validar_campos(n) {
	  if(($("#f_var_cant_cuotas").val() == '') || ($("#f_var_tipo_credito").val() == '')) {
		return false;
      } else {
        return true;
      }
    } 
   	  function funtion_aceptar_solicitud()
	  {
			var Valido = true;
			
			Valido = Valido && validar_campos();
			if ( Valido ) {
				$('#var_nombre_cliente').html($('#f_var_nombre_cliente').val());
				$('#var_monto_credito').html($('#f_var_monto_prestamo').val());
				$('#var_cant_cuotas').html($('#f_var_cant_cuotas').val());
				$('#var_monto_cuota').html($('#f_var_monto_cuota').val());
				
				switch($('#f_var_tipo_credito').val()) {
					case "1":
						$('#var_tipo_credito').html("SEMANAL");
						break;
					case "2":
						$('#var_tipo_credito').html("QUINCENAL");
						break;
					case "3":
						$('#var_tipo_credito').html("MENSUAL");
						break;
					case "4":
						$('#var_tipo_credito').html("UN PAGO");
						break;
					default:
						alert("ingrese tipo de credito");
				}
				$("#confirmar-aceptar").dialog("open");
				
			} else {
				$("#error-completar").dialog("open");
				$('#formulario_credito').submit();
			}	
		}  
</script>
 <div id="error-completar-tipo-credito" title="ERROR">
	<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>POR FAVOR INDICAR TIPO DE CREDITO</p>
</div>

 <div id="error-completar-monto-credito" title="ERROR">
	<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>POR FAVOR INDICAR MONTO DE CREDITO</p>
</div>


 <div id="error-completar" title="ERROR">
	<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>POR FAVOR COMPLETE TODO EL FORMULARIO:</p>
</div>
 <div id="confirmar-aceptar" title="Desea ingresar la siguiente Soliciutd?">
	<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>Datos de la solicitud:</p>
    <label >CLIENTE: </label>
	<label id="var_nombre_cliente" for="var_nombre_cliente"></label></br>
    <label >MONTO DEL CREDITO: $ </label>
	<label id="var_monto_credito" for="var_monto_credito"></label></br>
    <label >TIPO DE CREDITO: </label>
	<label id="var_tipo_credito" for="var_tipo_credito"></label></br>
    <label >PAGADERO EN </label>
	<label id="var_cant_cuotas" for="var_cant_cuotas"></label>
    <label >CUOTAS DE $ </label>
   	<label id="var_monto_cuota" for="var_monto_cuota"></label>

</div>
<div id="content">		
		
		<div id="contentHeader">
			<h1><?php echo $this->session->userdata('usuario'); ?>/créditos/Agregar un crédito nuevo</h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
			
			
			<div class="grid-17">
            
            
            
           
<?php if (isset($mensajes)) { echo $mensajes; } else {?>                     
            
				
				
<div class="widget">
						
						<div class="widget-header">
							<span class="icon-article"></span>
							<h3>Formulario Nuevo Crédito</h3>
							<?php 
							echo form_error('f_var_id_cliente');
							echo form_error('f_var_tipo_credito');
							echo form_error('f_var_cant_cuotas');
							echo form_error('f_var_monto_cuota');
							echo form_error('f_var_monto_prestamo');

							?>
						</div> <!-- .widget-header -->
					
						<div class="widget-content">
                        
<?php $attributes = array('id' => 'formulario_credito','class' => 'form uniformForm validateForm');

echo form_open('controladores-cobrador/controlador_administracion_creditos/agregar_credito', $attributes);   ?>                     
                        




<div class="box plain">




<div class="field-group">
		                             <?php if($this->session->userdata('usuario') == "sazubel" ){ ?>
									
									<label>Escriba nombre del Cliente al que se asignará el crédito</label>
									<div class="field"> 
			<input type="text" name="f_var_nombre_cliente" id="f_var_nombre_cliente" size="35" class="validate[required,minSize[3]]" value="<?php echo set_value('f_var_nombre_cliente');?>">										
			<input type="hidden" name="f_var_id_cliente" id="f_var_id_cliente" size="35" class="validate[required,minSize[3]]" value="<?php echo set_value('f_var_id_cliente');?>">										

									</div>
                                    <?php } ?>
								</div> <!-- .field-group -->
                                


<div class="field-group">
									<label>Elija la zona y el cobrado</label>
									<div class="field">
										<?php
										/*COMBO DE ZONAS DINAMICO*/
										//$combo = $this->db->get('tabla_zona_de_cobros');
		                                

											$combo = $this->db->get_where('tabla_zona_de_cobros', array('id_zona_de_cobros' => 2));
										echo ("<select class='validate[required]' name='f_var_id_zona_cobros' id='f_var_id_zona_cobros'>");
										//echo ("<option value='0'>No especificar</option>");
										foreach ($combo->result() as $row) 
											{ echo ("<option class='validate[required]' value=$row->id_zona_de_cobros> $row->zona_de_cobros</option>");}
										echo ("</select>");
										

										?>  
									</div>
								</div> <!-- .field-group -->
                                
                                
<div class="field-group">
									<label>Elija el tipo de Crédito</label>
									<div class="field">
										<?php
										/*COMBO DE ZONAS DINAMICO*/
										if($this->session->userdata('usuario') == "sazubel" ){
										echo ("<select class='validate[required]' name='f_var_tipo_credito' id='f_var_tipo_credito'>");
										echo ("<option value=''>Elija un tipo</option>");
										//echo ("<option value='0'>No especificar</option>");
										foreach ($tipos_de_creditos->result() as $row) 
											{ echo ("<option class='validate[required]' value=$row->id_creditos_tipos> $row->tipos_de_creditos</option>");}
										echo ("</select>");
										} else {
											echo ("<select class='validate[required]' name='f_var_tipo_credito' id='f_var_tipo_credito'>");
											echo ("<option value=''>Elija un tipo</option>");
											echo ("<option class='validate[required]' value=1> Semanal</option>");
											echo ("</select>");
										}
										?> 
									</div>
								</div> <!-- .field-group -->
		                            <?php if($this->session->userdata('usuario') == "sazubel" ){ ?>
									<label>Elija el dia de cobranza</label>
									<div class="field">
										<?php
										/*COMBO DE ZONAS DINAMICO*/
										$combo = $this->db->get('tabla_dia_cobranza');
										echo ("<select class='validate[required]' name='f_var_id_dia_cobranza' id='f_var_id_dia_cobranza'>");
										echo ("<option value=''>Elija un dia</option>");
										//echo ("<option value='0'>No especificar</option>");
										foreach ($combo->result() as $row) 
											{ echo ("<option value=$row->id_dia_cobranza> $row->dia </option>");}
										echo ("</select>");
										?>  
									</div>
									<?php } ?>
								</div> <!-- .field-group --> 
                                
<div class="field-group">
									<label for="email">Monto del prestamo:</label>
									<div class="field">
										<input type="text" name="f_var_monto_prestamo" id="f_var_monto_prestamo" size="10" class="validate[required]"  />	
									</div>
								</div> <!-- .field-group -->                                 
                                
<div class="field-group">
									<label for="required">Cantidad de Cuotas del Crédito:</label>
									<div id="combo_cuotas_sem" class="field">
                                      <select style="width:auto" name="f_var_cant_cuotas_sem" id="f_var_cant_cuotas_sem" class="validate[required]">
                                      	<option value="">Elija cuota</option>
                                      	<option value="24">24</option>
                                      	<option value="13">13</option>
                                      	<option value="9">9</option>
                                      	<option value="6">6</option>
                                      	<option value="4">4</option>
                                      </select>
                                    </div>
									<div id="combo_cuotas_qui" class="field">
                                      <select style="width:auto" name="f_var_cant_cuotas_qui" id="f_var_cant_cuotas_qui" class="validate[required]">
                                      	<option value="">Elija cuota</option>
                                      	<option value="12">12</option>
                                      	<option value="6">6</option>
                                      </select>
									</div>

                                    <div id="text_cuotas_manual" class="field">
                                    <label for="required">Valor cuota manual:</label>
									<input type="text" name="f_var_cant_cuotas" id="f_var_cant_cuotas" size="2" class="validate[required]" />	
									</div>
                                    <div id="boton_cuotas_auto" class="field">
                                    <button type="button" class="ticket ticket-info">SELECCION CUOTA</button>
									</div>
                                    <div id="boton_cuotas_manual" class="field">
                                    <button type="button" class="ticket ticket-info">INGRESO MANUAL</button>
									</div>


								</div> <!-- .field-group -->   
                                
<div class="field-group">
									<label for="email">Pulse aca para calcular monto de la cuota:</label>
									<div class="box department" style="width:100px; height:30px;  ">
                                    	<label style="font-size:20px; align-items:center" id="f_monto_cuota" for="f_monto_cuota"></label></br>

										<input type="hidden" name="f_var_monto_cuota" id="f_var_monto_cuota" size="32" />
									</div>
								</div>   
                                

                                
<div class="field-group">
									<?php if($this->session->userdata('usuario') == "sazubel" ){ ?>	
									<label for="email">Ingrese el numero de ficha:</label>
									<div class="field">
										<input name="f_var_detalle_credito" type="text" id="f_var_detalle_credito" value="" size="32"  />	
									</div>
			</div> <!-- .field-group -->
								<div class="field-group">
									
								<a class="btn btn-large btn-orange" href="javascript:funtion_aceptar_solicitud();">INGRESAR SOLICITUD</a></br></br>
								<?php } ?>
								</div>   

                                
<div class="field-group">
								</div> <!-- .field-group -->
            </div>






                                
                                
								
							</form>
							
							
						</div> <!-- .widget-content -->
						
					</div> <!-- .widget -->		
                    
					
					
<?php } ?>
				
				
			</div> <!-- .grid -->			
			

            
            
		</div> <!-- .container -->
		
	</div> <!-- #content -->
    
    
    
    
    
    
