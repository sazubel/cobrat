<script language="javascript" src="<?php echo base_url();?>js/Jquery.js"></script>


<script type="text/javascript">
$(document).ready(function(){	
		$( "#confirmacion2" ).dialog({
			  height: 'auto',
			  autoOpen: false,
			  resizable: false,
			  height:180,
			  modal: true,
			  buttons: {
				Aceptar: function() { $('#form_cierre').submit(); },
				 Cancelar: function() { $( this ).dialog( "close" ); }
			  },
		});			
		$( "#ingresar-cierre" ).click(function(){
	    	$( "#confirmacion2" ).dialog( "open" );
    	});
});




</script>
 <div id="confirmacion2" title="ADVERTENCIA">
	<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 10px 20px 0;"></span>Seguro que desea realizar este cierre?</p>
</div>

<div id="content">		
		
		<div id="contentHeader">
			<h1><?php echo $this->session->userdata('usuario'); ?>/CIERRE DE CAJA</h1>
		</div> <!-- #contentHeader -->	
		
        
        <div class="row">
		<div class="container">
			
			
			<div class="grid-17">
				
             <div class="widget widget-tabs">
			
					<div class="widget-header">
						<h3 class="icon aperture"></h3>
							
						<ul class="tabs right">	
							<li class="active"><a href="#tab-1">Listado de cierres</a></li>	
							<li class=""><a href="#tab-2">Revisar Caja</a></li>		
						</ul>					
					</div> <!-- .widget-header -->
				
					 <!-- .widget-content -->
				
					<div id="tab-1" class="widget-content">
						
						<h4>Listado de cierres y retiros efectuados</h4>                    
<hr>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Fecha Cierre</th>
								<th>Monto Caja</th>
								<th>Calculo Comision</th>
							</tr>
						</thead>
                            
						<tbody>
                        
                        <?php
						$cont=1;
						foreach ($listar_cierre_caja->result() as $row) {
						?>                        
							<tr class="odd gradeX">
								<td><?php echo $row->fecha_cierre ?></td>
								<td class="center"><?php echo $row->monto_caja ?></td>
								<td class="center"><?php echo $row->comision_cierre ?></td>
							</tr>
                            
                         <?php } ?>     
                            
				        </tbody>
					</table> 
						
					</div> <!-- .widget-content -->
					
					<div id="tab-2" class="widget-content">
						
						<h4>Ingresar un nuevo retiro y cierre</h4>
						
						<?php $attributes = array('class' => 'form uniformForm validateForm', 'id' => 'form_cierre');
						echo form_open('controladores-cobrador/controlador_administracion_pagos/ingresar_cierre_caja', $attributes);   ?>

						<input type="hidden" name="f_var_id_usuario" id="f_var_id_usuario" value="<?php echo $this->session->userdata('id_usuario'); ?>">

                          
                        <div class="field-group">
                        <?php if(isset($cierre_caja['ultimos_pagos_postcierre'])) {?>
						<label for="required">Recaudacion Total: $<span class="ticket ticket-success"><?php echo $cierre_caja['ultimos_pagos_postcierre']; ?></span><i class="fa fa-line-chart fa-lg	"></i></i></label>
						<?php if(isset($cierre_caja['ultimos_pagos_cierre_sabado'])) { ?>
                                                <label for="required">Ultima recaudacion pendiente sabado pasado: $<span class="ticket ticket-success"><?php echo $cierre_caja['ultimos_pagos_cierre_sabado']; ?></span><i class="fa fa-line-chart fa-lg	"></i></i></label>
                                                <?php } ?>
                                                <?php } else { ?> 
						<label for="required">Recaudacion a la fecha: <span class="ticket ticket-success"><?php echo "SIN COBROS AUN" ?></span> </label>
						<?php } ?>					
						<div class="field">
						<input type="hidden" name="f_ultimos_pagos_cierre_sabado" id="ultimos_pagos_cierre_sabado" size="15" class="validate[required]" value="<?php echo $cierre_caja['ultimos_pagos_cierre_sabado']; ?>" />
						<input type="hidden" name="f_ultimos_comisiones_cierre_sabado" id="ultimos_comisiones_cierre_sabado" size="15" class="validate[required]" value="<?php echo $cierre_caja['ultimos_comisiones_cierre_sabado']; ?>" />	
						<input type="hidden" name="f_var_monto_de_cierre_postcierre" id="f_var_monto_de_cierre_postcierre" size="15" class="validate[required]" value="<?php echo $cierre_caja['ultimos_pagos_postcierre']; ?>" />
						<input type="hidden" name="f_var_monto_comision_postcierre" id="f_var_monto_comision_postcierre" size="15" class="validate[required]" value="<?php echo $cierre_caja['comision_postcierre']; ?>" />	

                                                </div>
						</div>  <!-- .field-group -->
                        
                        <div class="field-group inlineField">									
						</div>


                        <div class="actions">
                        <?php if($this->session->userdata('usuario') == "sazubel" ){ ?>
						<a class="btn btn-large btn-orange" id="ingresar-cierre">REALIZAR RETIRO</a>
						<?php } ?>		
						<!--  <button type="submit" class="btn btn-error">Realizar Pago</button>-->															
						</div> 
                        </form>		
                        
                        				
					</div> <!-- .widget-content -->
				
			</div>   
            
            
            
			</div> <!-- .grid -->	
			<div class="grid-7">
            
            <a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion_pagos/listar_creditos_semanales" class="btn btn-primary btn-xlarge block">VOLVER A LISTAR</a>

				
			</div>
            
            </div> <!-- .row -->
            
            
		</div> <!-- .container -->
		
	</div> <!-- #content -->
    
    
    
    
    
    
