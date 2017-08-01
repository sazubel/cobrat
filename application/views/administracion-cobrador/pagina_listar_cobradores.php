<div id="content">		
		
		<div id="contentHeader">
			<h1><?php echo $this->session->userdata('usuario'); ?>/clientes/Listar clientes</h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
			
			
			<div class="grid-24">
            
            
            <div class="widget widget-table">
					
						<div class="widget-header">
							<span class="icon-list"></span>
							<h3 class="icon chart">Lista de Cobradores</h3>		
						</div>
					
						<div class="widget-content">
							
							<table class="table table-bordered table-striped data-table">
						<thead>
							<tr>
                                                            <th>Cobrador</th>
                                                            <th>ACCCION</th>
							</tr>
						</thead>
                        
						<tbody>
                      
                            
                            

<?php
foreach ($lista->result() as $row) {
?>

<tr class="gradeA">


	<td><?php echo $row->nombre." ".$row->apellido ?></td>
    <td><a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion_pagos/listar_creditos_semanales/<?php echo $row->id_usuario ?>">Registrar Pagos</a> - <a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion_pagos/listar_cierre_caja_usuario/<?php echo $row->id_usuario ?>">Cierre de Caja</a</td>

    
    
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