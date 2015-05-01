<script language="javascript" src="<?php echo base_url();?>js/Jquery.js"></script>


<script type="text/javascript">
$(document).ready(function(){	
		$( "#confirmacion" ).dialog({
			  height: 'auto',
			  autoOpen: false,
			  resizable: false,
			  height:180,
			  modal: true,
			  buttons: {
				Aceptar: function() { $('#form_pagos').submit(); },
				 Cancelar: function() { $( this ).dialog( "close" ); }
			  },
		});			
		$( "#ingresar-pago" ).click(function(){
	    	$( "#confirmacion" ).dialog( "open" );
    	});
});




</script>
 <div id="confirmacion" title="ADVERTENCIA">
	<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 10px 20px 0;"></span>Seguro que desea ingresar este pago?</p>
</div>

<div id="content">		
		
		<div id="contentHeader">
			<h1><?php echo $this->session->userdata('usuario'); ?>/Crédito otorgado a: </h1>
		</div> <!-- #contentHeader -->	
		
        
        <div class="row">
		<div class="container">
			
			
			<div class="grid-17">
				
             <div class="widget widget-tabs">
			
					<div class="widget-header">
						<h3 class="icon aperture">Tarjeta Crediticia</h3>
							
						<ul class="tabs right">	
							<li class="active"><a href="#tab-1">Detalles del Crédito</a></li>	
							<li class=""><a href="#tab-2">Tarjeta de pagos</a></li>					
							<li class=""><a href="#tab-3">Pagar Crédito</a></li>
						</ul>					
					</div> <!-- .widget-header -->
				
					<div id="tab-1" class="widget-content">
						
<div class="notify notify-notify">
<table>
						<tbody>
							<tr class="odd gradeX">
								<td>Fecha de inicio del credito:</td>
								<td>
									<h3><?php echo "<span class='ticket ticket-info'></span>" ?></h3>
								</td>
							</tr>							
						</tbody>
						</table>
</div>
<hr>
				<table class="table table-striped">
						<tbody>
							<tr class="odd gradeX">
								<td>Titular del crédito:</td>
							</tr>
						</tbody>
				</table>
                        
                        
						
					</div> <!-- .widget-content -->
				
					<div id="tab-2" class="widget-content">
						
						<h4>Pagos efectuados del crédito</h4>
						
						<h2>Cuotas</h2>                        
<hr>
<table class="table table-striped">
						<thead>
							<tr>
								<th>Nro.cierre</th>
								<th>Fecha Cierre</th>
								<th>Monto caja</th>
							</tr>
				</thead>
                            
						<tbody>
                        
                        <?php
						$cont=1;
						foreach ($listar_cierre_caja->result() as $row) {
						?>                        
							<tr class="odd gradeX">
								<td><?php echo $row->id_cierre ?></td>
								<td><?php echo $row->fecha_cierre ?></td>
								<td class="center"><?php echo $row->monto_caja ?></td>
							</tr>
                            
                         <?php } ?>     
                            
				        </tbody>
						</table> 
						
					</div> <!-- .widget-content -->
					
					<div id="tab-3" class="widget-content">
						
						<h4>Pagar Credito </h4>
						
						<?php $attributes = array('class' => 'form uniformForm validateForm', 'id' => 'form_pagos');
						echo form_open('controladores-cobrador/controlador_administracion_pagos/agregar_pago', $attributes);   ?>

						<input type="hidden" name="f_var_id_usuario" id="f_var_id_usuario" value="<?php echo $this->session->userdata('id_usuario'); ?>">

                          
                        <div class="field-group">
						<label for="required">Cuota de: <span class="ticket ticket-success"></span> </label>
						<div class="field">
						<input type="text" name="f_var_monto_de_pago" id="f_var_monto_de_pago" size="15" class="validate[required]" value="" />	
						</div>
						</div> <!-- .field-group -->
                        
                        <div class="field-group">
						<label for="required">Detalles del pago que quiera agregar:</label>
						<div class="field">
						<textarea name="f_var_detalle_pago" id="f_var_detalle_pago" rows="5" cols="50"></textarea>	
						</div>
						</div> <!-- .field-group -->
                        
                        <div class="field-group inlineField">								
						<!--_
                        <div class="field">
						<input type="hidden" name="f_var_fecha_pago" id="f_var_fecha_pago" class="datepicker" />				
						</div> <!-- .field -->								
						</div>


                        <div class="actions">
						<a class="btn btn-large btn-orange" id="ingresar-pago">INGRESAR PAGO</a>
						
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
    
    
    
    
    
    
