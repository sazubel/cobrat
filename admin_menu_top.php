<script language="javascript" src="<?php echo base_url();?>js/Jquery.js"></script>


<script type="text/javascript">
$(document).ready(function(){	
		$( "#confirmacion" ).dialog({
			  autoOpen: false,
			  resizable: false,
			  height:140,
			  modal: true,
			  buttons: {
				"Aceptar": function() {
				  $( this ).dialog( "close" );
				},
				Cancel: function() {
				  $( this ).dialog( "close" );
				}
			  }
			});			
				$( "#salir" ).click(function({
	      			$( "#confirmacion" ).dialog( "open" );
    			});
});



</script>

	<div id="topNav">
		 <ul>
		 	<li>
		 		<a href="#menuProfile" class="menu">Bienvenida <strong><?php echo $this->session->userdata('usuario'); ?></strong></a>
		 		
		 		<div id="menuProfile" class="menu-container menu-dropdown">
					<div class="menu-content">
						<ul class="">
							<li><a href="javascript:;">Proximamente</a></li>
						</ul>
					</div>
				</div>
	 		</li>
		 	<li><a class="salir" id="salir" >Salir</a></li>
		 </ul>
	</div> <!-- #topNav -->
	
	<div id="quickNav">
		<ul>
			<li class="quickNavMail">
				<a href="#menuAmpersand" class="menu"><span class="icon-book"></span></a>		
				
				<span class="alert"></span>		

				<div id="menuAmpersand" class="menu-container quickNavConfirm">
					<div class="menu-content cf">							
						
						<div class="qnc qnc_confirm">
							
							<h3>Confirm</h3>
					
							<div class="qnc_item">
								<div class="qnc_content">
									<span class="qnc_title">prox.</span>
									<span class="qnc_preview">prox.</span>
									<span class="qnc_time">prox.</span>
								</div> <!-- .qnc_content -->
								
								<div class="qnc_actions">						
									<button class="btn btn-primary btn-small">Aceptar</button>
									<button class="btn btn-quaternary btn-small">Cancelar</button>
								</div>
							</div>
							
							<a href="javascript:;" class="qnc_more">Mas</a>
															
						</div> <!-- .qnc -->	
					</div>
				</div>
			</li>
			<li class="quickNavNotification">
				<a href="#menuPie" class="menu"><span class="icon-chat"></span></a>
				
				<div id="menuPie" class="menu-container">
					<div class="menu-content cf">					
						
						<div class="qnc">
							
							<h3>Notificaciones</h3>
					
							<a href="javascript:;" class="qnc_item">
								<div class="qnc_content">
									<span class="qnc_title">Notificacion 1</span>
									<span class="qnc_preview">Prox.</span>
									<span class="qnc_time">Prox.</span>
								</div> <!-- .qnc_content -->
							</a>
							
						</div> <!-- .qnc -->
					</div>
				</div>				
			</li>
		</ul>		
	</div> <!-- .quickNav -->