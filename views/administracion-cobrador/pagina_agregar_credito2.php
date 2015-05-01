<script language="javascript" src="<?php echo base_url();?>js/Jquery.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>stylesheets/sample_pages/stream.css" type="text/css" />
<link type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
		<script type="text/javascript">
		$(document).ready(function(){
			$('#f_var_nombre_cliente').autocomplete({
				source:'<?php echo site_url('controladores-cobrador/controlador_administracion_creditos/autocompletar_contacto'); ?>',
				select: function(event, ui) {
					$('#f_var_id_cliente').val(ui.item.id_cliente);
				}
			});		
			
			});
		</script>
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
						</div> <!-- .widget-header -->
					
						<div class="widget-content">
                        
<?php $attributes = array('id' => 'formulario_credito','class' => 'form uniformForm validateForm');

echo form_open('controladores-cobrador/controlador_administracion_creditos/agregar_credito', $attributes);   ?>                     
                        




<div class="box plain">




<div class="field-group">
									<label>Elija el Cliente al que se asignará el crédito</label>
									<div class="field"> 
			<input type="text" name="f_var_nombre_cliente" id="f_var_nombre_cliente" size="35" class="validate[required,minSize[3]]" value="<?php echo set_value('f_var_nombre_cliente');?>">										
			<input type="hidden" name="f_var_id_cliente" id="f_var_id_cliente" size="35" class="validate[required,minSize[3]]" value="<?php echo set_value('f_var_id_cliente');?>">										

									</div>
								</div> <!-- .field-group -->
                                


									</div>
			</div>                  
                                                                                                                                              
                                </div>






                                
                                <!--
								<div class="actions">		
								<a class="ticket" href="javascript:funtion_aceptar_solicitud('<?php echo $nombre_cliente; ?>');">INGRESAR SOLICITUD</a></br></br>
								</div>   -->
								
							</form>
							
							
						</div> <!-- .widget-content -->
						
					</div> <!-- .widget -->		
                    
					
					
<?php } ?>
				
				
			</div> <!-- .grid -->			
			

            
            
		</div> <!-- .container -->
		
	</div> <!-- #content -->
    
    
    
    
    
    
