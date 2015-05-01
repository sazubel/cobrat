<div id="content">		
		
		<div id="contentHeader">
			<h1><?php echo $this->session->userdata('usuario'); ?>/clientes/Listar clientes</h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
			
			
			<div class="grid-24">
            
            
            <div class="widget widget-table">
					
						<div class="widget-header">
							<span class="icon-list"></span>
							<h3 class="icon chart">Lista de Clientes</h3>		
						</div>
					
						<div class="widget-content">
							
							<table class="table table-bordered table-striped data-table">
						<thead>
							<tr>

								<th>Nombre y apellido</th>
                                <th>DNI</th>
								<th>Direccion</th>
                                <th>Telefonos</th>
                                <th>Cred. Activos</th>
                                <th>Cred. Cerrados</th>
                                <th></th>
							</tr>
						</thead>
                        
						<tbody>
                      
                            
                            

<?php
foreach ($lista->result() as $row) {
?>

<tr class="gradeA">


	<td><?php echo $row->nombre_cliente.' '.$row->apellido_cliente ?></td>
    <td><?php echo $row->dni_cliente ?></td>
	<td><?php echo $row->direccion_cliente ?></td>
    <td><?php echo "fijo: ".$row->telefono_fijo_cliente." - celular: ".$row->celular_cliente ?></td>
    <td>x</td>
    <td>x</td>
    <td>Asignar Credito</td>

    
    
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