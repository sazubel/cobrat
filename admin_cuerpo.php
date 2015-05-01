<body>


<div id="wrapper">
	
	<div id="header">
		<h1><a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion/escritorio">Sistema</a></h1>		
		
		<a href="javascript:;" id="reveal-nav">
			<span class="reveal-bar"></span>
			<span class="reveal-bar"></span>
			<span class="reveal-bar"></span>
		</a>
	</div> <!-- #header -->
	<div id="search">
		<form>
			<input type="hidden" name="search" placeholder="Search..." id="searchField" />
		</form>		
	</div> <!-- #search -->
	
	<!-- Sidebar -->
        <?php echo $this->load->view($sidebar_botonera); ?>
    <!-- Sidebar -->
	
    
    
    
    
	<!-- CONTENIDO DE PAGINA -->
        <?php echo $this->load->view($main_content); ?>
         <!-- CONTENIDO DE PAGINA -->
         
         
         
         
	
<!-- TOPNAV -->
        <?php echo $this->load->view($admin_menu_top); ?>
    <!-- TOPNAV -->
	
	
</div> <!-- #wrapper -->

