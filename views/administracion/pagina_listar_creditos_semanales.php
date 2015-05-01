<script  type="text/javascript" language="javascript" src="<?php echo base_url();?>js/Jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/jquery-ui-tabs.js"></script>
		<style type="text/css" title="currentStyle">
			@import "<?php echo base_url();?>css/demo_page.css";
			@import "<?php echo base_url();?>css/demo_table.css";
		</style>
		<style type="text/css" title="currentStyle">
			@import "<?php echo base_url();?>/css/header.ccss";
			@import "<?php echo base_url();?>css/demo_table_jui.css";
			@import "<?php echo base_url();?>jquery-ui-1.8.10.custom.css";
			.ui-tabs .ui-tabs-panel { padding: 10px }
		</style>
<?php
//FUNCION PARA CALCULAR CANTIDAD DE DIAS PARA UN VENCIMIENTO
    function dias_restantes($fecha_final) {  
        $fecha_actual = date("Y-m-d");  
        $s = strtotime($fecha_final)-strtotime($fecha_actual);  
        $d = intval($s/86400);  
        $diferencia = $d;  
        return $diferencia;  
    }  

?>


<div id="content">


		
		
		<div id="contentHeader">
			<h1><?php echo $this->session->userdata('usuario'); ?>Lista de creditos - Fecha: <?php echo date("Y-m-d"); ?></h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
			
			
			<div class="grid-24">
            
            
            <div class="widget widget-table">
					
						<div class="widget-header">
							<span class="icon-list"></span>
							<h3 class="icon chart">Lista de Creditos</h3>
						</div>
						<div class="widget-content">
							
			<div id="demo">
				<div id="tabs">
					<ul>
						<li><a href="#tabs-1">MIERCOLES</a></li>
						<li><a href="#tabs-2">SABADOS</a></li>
					</ul>
					
					<div id="tabs-1">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example1">
	<thead>
		<tr>
			<th>Cliente</th>
			<th>Dia Cobranza</th>
			<th>Saldo en cuotas</th>
			<th>Estado en cuotas</th>
			<th>Tipo de Credito</th>
			<th>Prox. cuota</th>
			<th>Acción</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Cliente</th>
			<th>Dia Cobranza</th>
			<th>Saldo en cuotas</th>
			<th>Estado en cuotas</th>
			<th>Tipo de Credito</th>
			<th>Prox. cuota</th>
			<th>Acción</th>
		</tr>
	</tfoot>
	<tbody>
    <?php
foreach ($lista->result() as $row) {
	if($row->dia_cobranza == "Miercoles"){
	$saldo_efectivo = ($row->cantidad_cuotas*$row->monto_cuota) - $row->monto_abonado; 
	$saldo_cuotas = ($row->cantidad_cuotas- $row->cantidad_cuotas_real);
	$atraso = ($row->cantidad_cuotas_normal - $row->cantidad_cuotas_real);

?>
		<tr class="odd gradeB">
	<td>
	<?php   
				echo $row->nombre_cliente.' '.$row->apellido_cliente;
	?>
    </td>
	<td>
	<?php echo $row->dia_cobranza; ?></td>
    <td>
		<?php
			 echo $saldo_cuotas.' ($'.$saldo_efectivo.')';
		?>
    </td>
    <td>
	<?php  
			if ($atraso <= 0){
				echo "<span class='ticket ticket-success'>Cuenta al dia </span>";
			} elseif ($atraso <= 1) {
				echo "<span class='ticket ticket-warning'>Listo para Cobrar $atraso</span>";
			} else { 
				echo "<span class='ticket ticket-important'> Moroso $atraso cuotas </span>"; 				
			}
		?>
    </td>
	<td>
	<?php echo $row->tipos_de_creditos.' de $'.$row->monto_cuota ?>
    </td>
    <td>
	<?php 
			if ($atraso <= 0){
				echo "<span class='ticket ticket-success'>$row->fecha_proximo_pago</span>";
			} elseif ($atraso <= 1) {
				echo "<span class='ticket ticket-warning'>$row->fecha_proximo_pago</span>";
			} else { 
				echo "<span class='ticket ticket-important'>$row->fecha_proximo_pago</span>"; 				
			}
	?></td>
    <td><a href="<?php echo base_url();?>index.php/controladores-admin/controlador_administracion_pagos/mostrar_credito/<?php echo $row->id_credito;?>"><span class="ticket ticket-info">VER FICHA</span></a></td>
		</tr>
       <?php
	}
}
?> 
	<tbody>
</table>
					</div>


					<div id="tabs-2">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example2">
	<thead>
		<tr>
			<th>Cliente</th>
			<th>Dia Cobranza</th>
			<th>Saldo en cuotas</th>
			<th>Estado en cuotas</th>
			<th>Tipo de Credito</th>
			<th>Fecha prox. cuota</th>
			<th>Acción</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Cliente</th>
			<th>Dia Cobranza</th>
			<th>Saldo en cuotas</th>
			<th>Estado en cuotas</th>
			<th>Tipo de Credito</th>
			<th>Fecha prox. cuota</th>
			<th>Acción</th>
		</tr>
	</tfoot>
	<tbody>
    <?php
foreach ($lista->result() as $row) {
	if($row->dia_cobranza == "Sabado"){
	$saldo_efectivo = ($row->cantidad_cuotas*$row->monto_cuota) - $row->monto_abonado; 
	$saldo_cuotas = ($row->cantidad_cuotas- $row->cantidad_cuotas_real);
	$atraso = ($row->cantidad_cuotas_normal - $row->cantidad_cuotas_real);

?>
	<tr class="odd gradeB">
	<td>
	<?php   
				echo $row->nombre_cliente.' '.$row->apellido_cliente;
	?>
    </td>
	<td>
	<?php echo $row->dia_cobranza; ?></td>
    <td>
		<?php
			 echo $saldo_cuotas.' ($'.$saldo_efectivo.')';
		?>
    </td>
    <td><?php  
			if ($atraso <= 0){
				echo "<span class='ticket ticket-success'>Cuenta al dia </span>";
			} elseif ($atraso <= 1) {
				echo "<span class='ticket ticket-warning'>Cobrar en la semana $atraso</span>";
			} else { 
				echo "<span class='ticket ticket-important'>Moroso $atraso cuotas </span>"; 				
			}
		?></td>
	<td>
	<?php echo $row->tipos_de_creditos.' de $'.$row->monto_cuota ?>
    </td>
    <td>
	<?php 
			if ($atraso <= 0){
				echo "<span class='ticket ticket-success'>$row->fecha_proximo_pago</span>";
			} elseif ($atraso <= 1) {
				echo "<span class='ticket ticket-warning'>$row->fecha_proximo_pago</span>";
			} else { 
				echo "<span class='ticket ticket-important'>$row->fecha_proximo_pago</span>"; 				
			}
	?></td>
    <td><a href="<?php echo base_url();?>index.php/controladores-admin/controlador_administracion_pagos/mostrar_credito/<?php echo $row->id_credito;?>"><span class="ticket ticket-info">VER FICHA</span></a></td>
		</tr>
       <?php
	}
}
?> 
	</tbody>
</table>
					</div>
				</div>
			</div>						</div> <!-- .widget-content -->
				</div>
			</div> <!-- .grid -->			
		</div> <!-- .container -->
		
	</div> <!-- #content -->
    
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    $("#tabs").tabs( {
        "show": function(event, ui) {
            var table = $.fn.dataTable.fnTables(true);
            if ( table.length > 0 ) {
                $(table).dataTable().fnAdjustColumnSizing();
            }
        }
    } );
     
    $('table.display').dataTable( {
		"bSort": false,
        "sScrollY": "205px",
        "bScrollCollapse": true,
        "bPaginate": false,
        "bJQueryUI": true,
        "aoColumnDefs": [
            { "sWidth": "10%", "aTargets": [ -1 ] }
        ]
    } );
} );
</script>
        
            		                
			  <style type="text/css">
				<!-- @import "http://www.c-on.com.ar/sistemamyf/css/shCore.css"; -->
			  </style>