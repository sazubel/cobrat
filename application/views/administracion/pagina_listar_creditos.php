
<div id="content">


		
		
		<div id="contentHeader">
			<h1><?php echo $this->session->userdata('usuario'); ?>/creditos/Listar creditos - Fecha: <?php echo date("Y-m-d"); ?></h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
			
			
			<div class="grid-24">
            
            
            <div class="widget widget-table">
					
						<div class="widget-header">
							<span class="icon-list"></span>
							<h3 class="icon chart">Lista de Creditos</h3>
                            	
             <span class="ticket ticket-success">Al día</span>
			<span class="ticket ticket-warning">Cobrar HOY</span>
            <span class="ticket ticket-important">Retrasados</span>
            

						</div>
					
						<div class="widget-content">
							
							<table class="table table-bordered table-striped data-table">
						<thead>
							<tr>

								<th>Cliente</th>
                                <th>Prestamo</th>
								<th>Tipo de Credito</th>
                                <th>Fecha de pago de prox. cuota</th>
                                <th>Acción</th>
							</tr>
						</thead>
                        
						<tbody>
                      
                            
                            

<?php
foreach ($lista->result() as $row) {
?>

<tr class="gradeA">


	<td><?php echo $row->nombre_cliente.' '.$row->apellido_cliente.' - '.$row->dni_cliente ?></td>
    <td>$ <?php echo $row->capital_costo_invertido ?></td>
	<td><?php echo '<strong>'.$row->tipos_de_creditos.'</strong> -> '.$row->cantidad_cuotas.' Cuotas x $ '.$row->monto_cuota ?></td>
    <td>
	<?php 
	

	$dias_restantes = helper_dias_restantes($row->fecha_proximo_pago);
    //////////////////////////////////////////////////////////////////////////////////////////

    $fechatraducida = helper_traducir_fecha($row->fecha_proximo_pago);
	
	
	switch ($dias_restantes){		
		case ($dias_restantes > 0):
		echo "<span class='ticket ticket-success'>  $fechatraducida </span> - <span class='ticket ticket-success'>quedan $dias_restantes días</span>";
		break;
		
		case ($dias_restantes == 0):
		echo "<span class='ticket ticket-success'> $fechatraducida</span> - <span class='ticket ticket-success'>Hoy debe pagar</span>";
		break;
		
		case ($dias_restantes < 0): 
		echo ("<span class='ticket ticket-important'>$fechatraducida</span> - <span class='ticket ticket-important'>Moroso $dias_restantes días </span>"); 
		break;
		}
		    

	
	?></td>
    <td><a href="<?php echo base_url();?>index.php/controladores-admin/controlador_administracion_creditos/mostrar_credito/<?php echo $row->id_credito;?>"><span class="ticket ticket-info">Registrar pago</span></a></td>

    
    
</tr>  

  
<?php
}
?>                              
                            
                            
                            
                            
																					
						</tbody>
					</table>
						</div> <!-- .widget-content -->
					
				</div>
            
            
            

				
				
			</div> <!-- .grid -->			
			
			
			
			
            
		</div> <!-- .container -->
		
	</div> <!-- #content -->