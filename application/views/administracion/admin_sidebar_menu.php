<div id="sidebar">		
		
		<ul id="mainNav">			
			<li id="navDashboard" <?php if ($boton_destacado==1){echo ("class='nav active'");}else{echo ("class='nav'");} ?>>
				<span class="icon-home"></span>
				<a href="<?php echo base_url();?>index.php/controladores-admin/controlador_administracion/escritorio">Escritorio</a>				
			</li>
						
			<li id="navPages" <?php if ($boton_destacado==2){echo ("class='nav active'");}else{echo ("class='nav'");} ?>>
				<span class="icon-document-alt-stroke"></span>
				<a href="javascript:;">Clientes</a>				
				
				<ul class="subNav">
					<li><a href="<?php echo base_url();?>index.php/controladores-admin/controlador_administracion_clientes/agregar_cliente">Agregar Nuevo Cliente</a></li>
					<li><a href="<?php echo base_url();?>index.php/controladores-admin/controlador_administracion_clientes/listar_clientes">Listar Clientes</a></li>
                    <li><a href="#">Clientes Activos</a></li>
                    <li><a href="#">Clientes Morosos</a></li>
                    <li><a href="#">Clientes Inactivos</a></li>
                    
				</ul>						
				
			</li>	
			
			<li id="navForms" <?php if ($boton_destacado==3){echo ("class='nav active'");}else{echo ("class='nav'");} ?>>
				<span class="icon-article"></span>
				<a href="javascript:;">Créditos</a>
				
				<ul class="subNav">
					<li><a href="<?php echo base_url();?>index.php/controladores-admin/controlador_administracion_creditos/agregar_credito">Agregar un nuevo crédito</a></li>
					<li><a href="<?php echo base_url();?>index.php/controladores-admin/controlador_administracion_creditos/listar_creditos">Listar créditos</a></li>					
				</ul>	
								
			</li>
			

			<li <?php if ($boton_destacado==4){echo ("class='nav active'");}else{echo ("class='nav'");} ?>>
				<span class="icon-denied"></span>
				<a href="javascript:;">Pagos</a>
				
				<ul class="subNav">
					<li><a href="<?php echo base_url();?>index.php/controladores-admin/controlador_administracion_pagos/listar_creditos_semanales">Registrar Pagos</a></li>
					<li><a href="error-401.html">Ultimos pagos</a></li>
					<li><a href="error-403.html">Proximos pagos</a></li>				
				</ul>	
			</li>
            
            
            <li id="navPages" <?php if ($boton_destacado==5){echo ("class='nav active'");}else{echo ("class='nav'");} ?>>
				<span class="icon-document-alt-stroke"></span>
				<a href="javascript:;">Caja Ingresos/Egresos</a>				
				
				<ul class="subNav">
					<li><a href="#">Registrar Egreso por pagos</a></li>
                    <li><a href="#">Registrar Ingreso</a></li>
                    <li><a href="#">Mostrar movimientos</a></li>
				</ul>						
				
			</li>
            
            
            <li id="navPages" <?php if ($boton_destacado==6){echo ("class='nav active'");}else{echo ("class='nav'");} ?>>
				<span class="icon-document-alt-stroke"></span>
				<a href="javascript:;">Estadísticas</a>				
				
				<ul class="subNav">
					<li><a href="#">Cash flow por períodos</a></li>
                    <li><a href="#">Creditos por mes</a></li>
                    <li><a href="#">Clientes por mes</a></li>
				</ul>						
				
			</li>
            
            
		</ul>
        
        
        
        
				
	</div>
    
    