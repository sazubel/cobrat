	<script language="javascript" src="<?php echo base_url();?>js/Jquery.js"></script>
        <link type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<script type="text/javascript">
$(function() {
    $( "#f_var_nacimiento" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd',
	  yearRange: '1920:2015'
	  }
	  //,$.datepicker.regional['es']
	  );
});
$(document).ready(function(){
 $("#f_var_dni").blur(function(){
  if($("#f_var_dni").val().length == 8)
  {
  $.ajax({
   type: "POST",
   url: "<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion_clientes/validar_dni2",
   data: "name="+$("#f_var_dni").val(),
   success: function(msg){
    if(msg == 0)
    {
		$("#usr_verify").css({ "background-image": "url('<?php echo base_url();?>images/yes.png')" });
    }
    else
    {
	 	$("#f_var_dni").val('');
	 	$("#f_var_dni").focus();	 
     	$("#usr_verify").css({ "background-image": "url('<?php echo base_url();?>images/no.png')" });
    }
   }
  });
  }
  else 
  {
	 $("#f_var_dni").val('');
   $("#usr_verify").css({ "background-image": "none" });
  }
 });
});
</script>

<div id="content">		
		
		<div id="contentHeader">
			<h1><?php echo $this->session->userdata('usuario'); ?>/clientes/Agregar un cliente nuevo</h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
			
			
			<div class="grid-17">
            
            
            
            
<?php if (isset($mensajes)) { echo $mensajes; } else {?>                     
            
				
				
<div class="widget">
						
						<div class="widget-header">
							<span class="icon-article"></span>
							<h3>Formulario de Registración de nuevos clientes</h3>
						</div> <!-- .widget-header -->
					
						<div class="widget-content">
                        
<?php $attributes = array('class' => 'form uniformForm validateForm');

echo form_open('controladores-cobrador/controlador_administracion_clientes/agregar_cliente', $attributes);   ?>                     
                        
<!--<form class="form uniformForm validateForm" action="<?php //echo base_url();?>index.php/controladores-cobrador/controlador_administracion_clientes/agregar_cliente">-->
							
							<div class="field-group">
								<label>Nombre Completo:</label>
								<div class="field">
									<input type="text" name="f_var_nombres" id="f_var_nombres" size="10" class="validate[required,minSize[3],custom[onlyNames]]" />			
									<label for="pnombre">Primer Nombre</label>
                                     <?php echo form_error('var_nombre', '<div class="icons-holder"><span class="icon-x-alt"> </span>', '</div>'); ?>
								</div>
								<div class="field">
									<input type="text" name="f_var_apellido" id="f_var_apellido" size="12" class="validate[required,minSize[3],custom[onlyNames]]" />			
									<label for="apellido">Apellido</label>
								</div>
							</div> <!-- .field-group -->	                                
                                                                
                            <div>
								<div class="field-group">
                                    <div>
									<label for="dni">DNI:</label>
                                    </div>
                                    <div>
                                    <!--
                    			<input type="text" name="f_var_dni" id="f_var_dni" class="validate[required,custom[onlyNumberSp],minSize[8],maxSize[8],ajax[ajaxDNICallPhp]] text-input" size="8" value="<?php //echo set_value('f_var_dni');?>" /><span id="usr_verify" class="verify"></span>
                                -->
                    <input type="text" name="f_var_dni" id="f_var_dni" class="validate[required]" size="6" value="<?php echo set_value('f_var_dni');?>" /><span id="usr_verify" class="verify"></span>
                                
                                </div>
                                <div class="field">
                                <label for="phone1">Ejemplo 13623443</label>
                                </div>
                                     <?php echo form_error('f_var_dni', '<div class="icons-holder"><span class="icon-x-alt"> </span>', '</div>'); ?>
								</div>
                            </div>

                                <div class="field-group">
									<label for="required">Telefono fijo:</label>
									<div class="field">
										<input type="text" name="f_var_telefono" id="f_var_telefono" size="10" value="" class="validate[minSize[10],maxSize[10],custom[soloTelefono]]" />
										<label for="phone1">Anteponer codigo de area sin el "0"</label>
										<input type="hidden" name="f_var_celular" value="381" id="f_var_celular" size="20" class="validate[required]" />	
                                        </div>
								</div> <!-- .field-group -->
								<div class="field-group">
									<label for="date">Fecha de Nacimiento:</label>
									<div class="field">
										<input type="text" name="f_var_nacimiento" id="f_var_nacimiento" size="15" class="validate[required]" />
										<label for="date">1980-12-01</label>	
									</div>
								</div> <!-- .field-group -->
                                
                                
                                
                                
                                <div class="field-group">
									<label for="required">Dirección:</label>
									<div class="field">
										<textarea name="f_var_direccion" id="f_var_direccion" rows="5" cols="50" class="validate[required]"></textarea>	
									</div>
								</div> <!-- .field-group -->
                                
                                
                                <div class="field-group">
									<!--  <label for="required">Dirección en GMAP:</label> -->
									<div class="field">
										<textarea hidden="yes" name="f_var_direccion_gmap" id="f_var_direccion_gmap" rows="5" cols="50"></textarea>
									</div>
								</div> <!-- .field-group -->
                                
                                
                                <div class="field-group">
									<!--<label for="required">Detalles adicionales del cliente:</label> -->
									<div class="field">
										<textarea hidden="yes" name="f_var_adicional" id="f_var_adicional" rows="5" cols="50"></textarea>	
									</div>
								</div> <!-- .field-group -->
								
								
                                
                                
                                
							
								<div class="actions">						
									<button type="submit" class="btn btn-error">Agregar nuevo cliente</button>
								</div> <!-- .actions -->
								
							</form>
							
							
						</div> <!-- .widget-content -->
						
					</div> <!-- .widget -->		
                    
					
					
<?php } ?>
				
				
			</div> <!-- .grid -->			
			
			
			
			<div class="grid-7">

				<div class="box">
					<h3>Notas Importantes</h3>
					<ul class="bullet secondary">
					</ul>
				</div> <!-- .box -->
				
			</div>
            
            
		</div> <!-- .container -->
		
	</div> <!-- #content -->