<div id="sidebar">		
		
		<ul id="mainNav">			
			<li id="navDashboard" <?php if ($boton_destacado==1){echo ("class='nav active'");}else{echo ("class='nav'");} ?>>
				<span class="icon-home"></span>
				<a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion/escritorio">Escritorio</a>				
			</li>
						
			<li id="navPages" <?php if ($boton_destacado==2){echo ("class='nav active'");}else{echo ("class='nav'");} ?>>
				<span class="icon-document-alt-stroke"></span>
				<a href="javascript:;">Clientes</a>				
				
				<ul class="subNav">
					<li><a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion_clientes/agregar_cliente">Agregar Nuevo Cliente</a></li>
					<li><a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion_clientes/listar_clientes">Listar Clientes</a></li>
                    
				</ul>						
				
			</li>	
			
			<li id="navForms" <?php if ($boton_destacado==3){echo ("class='nav active'");}else{echo ("class='nav'");} ?>>
				<span class="icon-article"></span>
				<a href="javascript:;">Créditos</a>
				
				<ul class="subNav">
					<li><a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion_creditos/agregar_credito">Agregar un nuevo crédito</a></li>
					<li><a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion_creditos/listar_creditos">Listar créditos</a></li>					
				</ul>	
								
			</li>
			

			<li <?php if ($boton_destacado==4){echo ("class='nav active'");}else{echo ("class='nav'");} ?>
				<span class="icon-denied"></span>
				<a href="javascript:;">Pagosss</a>

				<ul class="subNav">
					<li><a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion_pagos/listar_creditos_semanales">Registrar Pagos</a></li>
					<li><a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion_pagos/listar_creditos_semanales">Caja</a></li>
				</ul>
			</li>
		</ul>
        
        
        
        
				
	</div>
    
    