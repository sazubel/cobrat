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
			<h1><?php echo $this->session->userdata('usuario'); ?>/Crédito otorgado a: <?php echo $credito['nombre'].' '.$credito['apellido']?></h1>
		</div> <!-- #contentHeader -->	
		
        
        <div class="row">
		<div class="container">
			
			
			<div class="grid-17">
            
            <?php //ESTA VARIABLE VIENE DE controlador_administracion_pagos/agregar_pago()
			if (isset($mensajes_pago_listo)) {echo $mensajes_pago_listo;} else   
			?>  
            
            <?php { ?><div class="notify notify-error">
						
						<a href="javascript:;" class="close">&times;</a>
						
						<h3>IMPORTANTE</h3>
						
						<h3>Cobrar la próxima cuota antes o el día: <?php echo $credito['proximopago'] ?></h3>
					</div>
                    <?php } ?>                    
            
            
          
				
				
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
								<td><h3><?php echo "<span class='ticket ticket-info'>".$credito['fecha_entrega_del_bien']."</span>" ?></h3></td>
							</tr>
							<tr>
								<td><a id="north-west" href="#" title="This is an example of north-west gravity">Fecha de fin del credito:</a></td>
								<td><h3><?php echo "<span class='ticket ticket-info'>".$credito['fecha_fin_credito']." Semanas restantes ".floor($credito['semanas_restantes'])."</span>" ?></h3></td>
							</tr>
							<tr class="odd gradeA">
								<td>Tipo de credito:</td>
								<td><h3><?php echo "<span class='ticket ticket-info'>".$credito['tipocredito']." ".$credito['dia_cobranza']."</span>" ?></h3></td>
							</tr>
							<tr class="even gradeA">
								<td>Cuotas pactadas a la fecha: </td>
								<td>
								<h3><?php echo "<span class='ticket ticket-info'>".floor($credito['cantidad_cuotas_normal'])." de $".$credito['montocuota']." Total $".floor($credito['cantidad_cuotas_normal'])*$credito['montocuota']."</span>" ?></h3></td>
							</tr>							<tr class="even gradeA">
								<td>Cuotas cumplidas a la fecha: </td>
								<td><h3><?php 
									if($credito['cantidad_cuotas_real'] < $credito['cantidad_cuotas_normal']){
									echo "<span class='ticket ticket-info'>". $credito['cantidad_cuotas_real']." de $".$credito['montocuota']." Total $".$credito['cantidad_cuotas_real']*$credito['montocuota']."</span>" ;
									}else{
									echo "<span class='ticket ticket-error'>". $credito['cantidad_cuotas_real']." de $".$credito['montocuota']." Total $".$credito['cantidad_cuotas_real']*$credito['montocuota']."</span>"; 
									}?>
									</h3>
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
								<td><?php echo $credito['nombre'].' '.$credito['apellido']?></td>
							</tr>
							<tr class="even gradeC">
								<td>DNI del cliente:</td>
								<td><?php echo $credito['dni'] ?></td>
							</tr>
							<tr class="odd gradeA">
								<td>Telefono:</td>
								<td><?php echo $credito['fijo'] ?></td>
							</tr>
							</tbody>
						</table>
                        
                        
						
					</div> <!-- .widget-content -->
				
					<div id="tab-2" class="widget-content">                      
<hr>
<table class="table table-striped">
						<thead>
							<tr>
								<th>Nro.Cuota</th>
								<th>Fecha ideal de pago</th>
								<th>Fecha Real de pago</th>
								<th>Monto de cuota</th>
								<!--
								<th>Saldo</th>
								-->
							</tr>
				</thead>
                            
						<tbody>
                        
                        <?php
						$total=$credito['cantidadcuotas']*$credito['montocuota'];
						$cont=1;
						foreach ($lista_pagos->result() as $row) {
						?>                        
							<tr class="odd gradeX">
								<td><?php echo $cont; ?></td>
								<td><?php echo $row->fecha_ideal_de_pago ?></td>
								<td><?php echo $row->fecha_de_pago_credito ?></td>
								<td class="center"><?php echo $row->monto_de_pago_credito ?></td>
								<!--
								<td class="center"><?php echo $total; ?></td>
								-->
							</tr>
                            
                         <?php 
						 $cont=$cont+1;
						 $total=$total-$credito['montocuota'];
						 } ?>     
                            
				        </tbody>
						</table> 
						
					</div> <!-- .widget-content -->
					
					<div id="tab-3" class="widget-content">
						
						<h4>Pagar Credito (Id:<?php echo '#'.$credito['id_credito'] ?>)</h4>
						
						<?php $attributes = array('class' => 'form uniformForm validateForm', 'id' => 'form_pagos');
						echo form_open('controladores-cobrador/controlador_administracion_pagos/agregar_pago', $attributes);   ?>

<input type="hidden" name="f_var_id_credito" id="f_var_id_credito" value="<?php echo $credito['id_credito'] ?>">
<input type="hidden" name="f_var_id_usuario" id="f_var_id_usuario" value="<?php echo $this->session->userdata('id_usuario'); ?>">

                          
                        <div class="field-group">
						<label for="required">Cuota de: <span class="ticket ticket-success"><?php echo $credito['nombre'].' '.$credito['apellido']?></span> </label>
						<div class="field">
						<input type="text" name="f_var_monto_de_pago" id="f_var_monto_de_pago" size="15" class="validate[required]" value="<?php echo $credito['montocuota'] ?>" />	
						</div>
						</div> <!-- .field-group -->
                        
                        <div class="field-group">
						<label for="required">Detalles del pago que quiera agregar:</label>
						<div class="field">
						<textarea name="f_var_detalle_pago" id="f_var_detalle_pago" rows="5" cols="50"></textarea>	
						</div>
						</div> <!-- .field-group -->
                        
                        <div class="field-group inlineField">								
						<!--
                        <label for="datepicker">Fecha de pago (Solo si la fecha no coincide con el dìa de hoy)</label>
						-->
                        <div class="field">
						<input type="hidden" name="f_var_fecha_pago" id="f_var_fecha_pago" class="datepicker" />	
						<input type="hidden" name="f_var_comision" id="f_var_comision" value="<?php echo $credito['comision']; ?>"/>
						<input type="hidden" name="f_var_cuota" id="f_var_cuota" value="<?php echo $credito['montocuota']; ?>">			
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
    
    
    
    
    
    
