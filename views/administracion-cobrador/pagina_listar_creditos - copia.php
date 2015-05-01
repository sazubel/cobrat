<script  type="text/javascript" language="javascript" src="<?php echo base_url();?>js/Jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/jquery.dataTables.js"></script>

		<style type="text/css" title="currentStyle">
			@import "<?php echo base_url();?>css/demo_page.css";
	<!--		@import "<?php echo base_url();?>css/demo_table.css"; -->
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
							
							<!-- <table class="table table-bordered table-striped data-table"> -->
						<table class="display" id="example">
						<thead>
							<tr>
								<th>Cliente</th>
								<th>Dia Cobranza</th>
                                <th>Saldo en cuotas</th>
                                <th>Estado en cuotas</th>
								<th>Tipo de Credito</th>
                                <th>Fecha de pago de prox. cuota</th>
                                <th>Acción</th>
							</tr>
						</thead>
                        
						<tbody>
                      
                            
                            

<?php
foreach ($lista->result() as $row) {
	$saldo_efectivo = ($row->cantidad_cuotas*$row->monto_cuota) - $row->monto_abonado; 
	$saldo_cuotas = ($row->cantidad_cuotas- $row->cantidad_cuotas_real);
	$atraso = ($row->cantidad_cuotas_normal - $row->cantidad_cuotas_real);
?>

<tr class="gradeA">


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
				echo "<span class='ticket ticket-success'>Cuenta al dia $atraso</span>";
			} elseif ($atraso <= 1) {
				echo "<span class='ticket ticket-warning'> Cobrar hoy $atraso</span>";
			} else { 
				echo "<span class='ticket ticket-important'> Moroso $atraso cuotas </span>"; 				
			}
		?></td>
	<td>
	<?php echo $row->cantidad_cuotas.' Cuotas x $ '.$row->monto_cuota.'('.$row->tipos_de_creditos.')' ?>
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
    <td><a href="<?php echo base_url();?>index.php/controladores-admin/controlador_administracion_pagos/mostrar_credito/<?php echo $row->id_credito;?>"><span class="ticket ticket-info">Registrar pago</span></a></td>

    
    
</tr>  

  
<?php
}
?>                              
                            
                            
                            
                            
																					
						</tbody>
	<tfoot>
		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</tfoot>
					</table>
						</div> <!-- .widget-content -->
					
				</div>
            
            
            

				
				
			</div> <!-- .grid -->			
			
			
			
			
            
		</div> <!-- .container -->
		
	</div> <!-- #content -->
        <script type="text/javascript">
        $(function() {
            $("#addAll").click(function() {
                var add = 0;
                $(".cantidad").each(function() {
                    add += Number($(this).html());
                });
                $("#totalstock").text("El Costo total es : " + add);
            });
        });
    </script>
    
<script type="text/javascript" charset="utf-8">
			(function($) {
			/*
			 * Function: fnGetColumnData
			 * Purpose:  Return an array of table values from a particular column.
			 * Returns:  array string: 1d data array 
			 * Inputs:   object:oSettings - dataTable settings object. This is always the last argument past to the function
			 *           int:iColumn - the id of the column to extract the data from
			 *           bool:bUnique - optional - if set to false duplicated values are not filtered out
			 *           bool:bFiltered - optional - if set to false all the table data is used (not only the filtered)
			 *           bool:bIgnoreEmpty - optional - if set to false empty values are not filtered from the result array
			 * Author:   Benedikt Forchhammer <b.forchhammer /AT\ mind2.de>
			 */
			$.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
				// check that we have a column id
				if ( typeof iColumn == "undefined" ) return new Array();
				
				// by default we only want unique data
				if ( typeof bUnique == "undefined" ) bUnique = true;
				
				// by default we do want to only look at filtered data
				if ( typeof bFiltered == "undefined" ) bFiltered = true;
				
				// by default we do not want to include empty values
				if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;
				
				// list of rows which we're going to loop through
				var aiRows;
				
				// use only filtered rows
				if (bFiltered == true) aiRows = oSettings.aiDisplay; 
				// use all rows
				else aiRows = oSettings.aiDisplayMaster; // all row numbers
			
				// set up data array	
				var asResultData = new Array();
				
				for (var i=0,c=aiRows.length; i<c; i++) {
					iRow = aiRows[i];
					var aData = this.fnGetData(iRow);
					var sValue = aData[iColumn];
					
					// ignore empty values?
					if (bIgnoreEmpty == true && sValue.length == 0) continue;
			
					// ignore unique values?
					else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
					
					// else push the value onto the result data array
					else asResultData.push(sValue);
				}
				
				return asResultData;
			}}(jQuery));
			
			
			function fnCreateSelect( aData )
			{
				var r='<select><option value=""></option>', i, iLen=aData.length;
				for ( i=0 ; i<iLen ; i++ )
				{
					r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
				}
				return r+'</select>';
			}
			
			
				/* Initialise the DataTable */
				var oTable = $('#example').dataTable( {
					"oLanguage": {
						"sSearch": "Buscar:"
					}
				} );
				
				/* Add a select menu for each TH element in the table footer if((i<1 || i>=3)&&(i<=3 || i>4)&&(i<=5)) */
				$("tfoot th").each( function ( i ) {
					if((i>=1)&&(i<=1)) 
					this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
					$('select', this).change( function () {
						oTable.fnFilter( $(this).val(), i );
					} );
				} );
		</script>
            		                
               <div>
			  <style type="text/css">
				<!-- @import "http://www.c-on.com.ar/sistemamyf/css/shCore.css"; -->
			  </style>
			</div>