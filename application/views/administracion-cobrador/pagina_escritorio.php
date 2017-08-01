<script language="javascript" src="<?php echo base_url();?>js/Jquery.js"></script>
<script type="text/javascript">

		$( "#borrar" ).dialog({
			  height: 'auto',
			  autoOpen: false,
			  resizable: false,
			  height:140,
			  modal: true,
			  buttons: {
				"Aceptar": function(){
                                  $( this ).dialog( "close" );  
				},
				Cancel: function() {
				  $( this ).dialog( "close" );
				}
			  }
			});			
				$("#boton_borrar" ).click(function(){
                                $("#testing").htm('eee');
	      			$("#confirmar_borrar" ).dialog( "open" );
                                
    			});




</script>
<div id="confirmar_borrar" title="ADVERTENCIA">
	<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 10px 20px 0;"></span>Seguro que deseas borrar el pago?</p>
        <div id="testing"></div>
</div>
                  

<div id="content">		
		
		<div id="contentHeader">
			<h1><?php echo $this->session->userdata('usuario'); ?>/Escritorio</h1>
		</div> <!-- #contentHeader -->	
<?php 
	$saldo_sabado = 0;
        $avance_total = 0;
	$saldo_miercoles = 0;
	$atraso_miercoles = 0;
	$atraso_sabado = 0;
	$abonados_miercoles = 0;
	$abonados_sabado = 0;
	$saldo_atraso_miercoles = 0;
	$saldo_atraso_sabado = 0;
	$cantidad_creditos_miercoles = 0;
	$cantidad_creditos_sabados = 0;
	$termina_miercoles = 0;
	$termina_sabado = 0;
	$ultimo_miercoles = strtotime("wednesday last week");
	$ultimo_miercoles = date("Y-m-d",$ultimo_miercoles);
	$ultimo_sabado = strtotime("saturday last week");
	$ultimo_sabado = date("Y-m-d",$ultimo_sabado);
	$proximo_sabado = strtotime("saturday this week");
	$proximo_sabado = date("Y-m-d",$proximo_sabado);
	$semana_miercoles = 0;
	$semana_sabado = 0;
	$monto_abonado_miercoles = 0;
	$monto_abonado_sabado = 0;
        $termina_miercoles_saldo = 0;
        $termina_sabado_saldo = 0;    
	$este_miercoles = strtotime("wednesday this week");
	$este_miercoles = date("Y-m-d",$este_miercoles);
	$este_sabado = strtotime("saturday this week");
	$este_sabado = date("Y-m-d",$este_sabado);
	//$hoy = date('Y-m-d H:i:s');
	$hoy = date('Y-m-d');
	if($este_miercoles <= $hoy) {
		$ultimo_miercoles = $este_miercoles;
	} 
	if($este_sabado <= $hoy) {
		$ultimo_sabado = $este_sabado;
	}
        
        foreach ($cierre_caja->result() as $row) {
            $ultimo_cierre_caja = $row->fecha_cierre;
        }
        $ultimo_sabado = $ultimo_cierre_caja;
        $ultimo_miercoles = $ultimo_cierre_caja;
        
        foreach ($ultimos_pagos->result() as $row) {	
            //$ultimo_pago_miercoles = date("Y-m-d",strtotime($row->fecha_de_pago_credito));
            $ultimo_pago_miercoles = $row->fecha_de_pago_credito;
            if(($ultimo_pago_miercoles > $ultimo_cierre_caja) && ($row->id_dia_cobranza == 1)){					
                $semana_miercoles = $semana_miercoles +1;
                $monto_abonado_miercoles = $row->monto_de_pago_credito + $monto_abonado_miercoles;												
            }			                        
        }
        
        foreach ($ultimos_pagos->result() as $row) {	
            //$ultimo_pago_sabado = date("Y-m-d",strtotime($row->fecha_de_pago_credito));
            $ultimo_pago_sabado = $row->fecha_de_pago_credito;
            if(($ultimo_pago_sabado > $ultimo_cierre_caja) && ($row->id_dia_cobranza == 2)){					
               $semana_sabado = $semana_sabado +1;
                $monto_abonado_sabado = $row->monto_de_pago_credito + $monto_abonado_sabado;												
            }			                        
        }        
	foreach ($lista->result() as $row) {
		switch ($row->dia_cobranza) {
			case 'Miercoles':
				$ultimo_pago = date("Y-m-d",strtotime($row->ultimo_pago));
				if($row->estado_credito==1){
                                       $cantidad_creditos_miercoles = 1 + $cantidad_creditos_miercoles;
                                       $saldo_miercoles = $row->monto_cuota + $saldo_miercoles;
                                }elseif((date("Y-m-d",strtotime($row->ultimo_pago)) >= (date("Y-m-d",strtotime($ultimo_cierre_caja))))) {
                                       $termina_miercoles = 1 + $termina_miercoles;
                                       $termina_miercoles_saldo = $termina_miercoles_saldo + $row->monto_cuota;
                                }
				if(($row->cantidad_cuotas_real < floor($row->cantidad_cuotas_normal))&&($hoy != $row->fecha_proximo_pago)&&($row->estado_credito==1)){
					$atraso_miercoles = $atraso_miercoles + 1;
					$saldo_atraso_miercoles = ((floor($row->cantidad_cuotas_normal)*$row->monto_cuota)-$row->monto_abonado) + $saldo_atraso_miercoles;
					 
				} elseif(($hoy == $row->fecha_proximo_pago)&&((floor($row->cantidad_cuotas_normal)-$row->cantidad_cuotas_real) >=2)){

						$atraso_miercoles = $atraso_miercoles + 1;
						$saldo_atraso_miercoles = ((floor($row->cantidad_cuotas_normal)*$row->monto_cuota)-$row->monto_abonado) + $saldo_atraso_miercoles;

					
				}
				
				break;
			
			case 'Sabado':
                                $ultimo_pago = date("Y-m-d",strtotime($row->ultimo_pago));            
				if($row->estado_credito==1){
                                      $cantidad_creditos_sabados = 1 + $cantidad_creditos_sabados;
                                      $saldo_sabado = $row->monto_cuota + $saldo_sabado;
                                }elseif((date("Y-m-d",strtotime($row->ultimo_pago)) >= (date("Y-m-d",strtotime($ultimo_cierre_caja))))) {
                                      $termina_sabado = 1 + $termina_sabado;
                                      $termina_sabado_saldo = $termina_sabado_saldo + $row->monto_cuota;
                                }
				if(($row->cantidad_cuotas_real < floor($row->cantidad_cuotas_normal))&&($hoy != $row->fecha_proximo_pago)&&($row->estado_credito==1)){
					$atraso_sabado = $atraso_sabado + 1;
					$saldo_atraso_sabado = ((floor($row->cantidad_cuotas_normal)*$row->monto_cuota)-$row->monto_abonado) + $saldo_atraso_sabado;
				} elseif(($hoy == $row->fecha_proximo_pago)&&((floor($row->cantidad_cuotas_normal)-$row->cantidad_cuotas_real) >=2)){
					$atraso_sabado = $atraso_sabado + 1;
					$saldo_atraso_sabado = ((floor($row->cantidad_cuotas_normal)*$row->monto_cuota)-$row->monto_abonado) + $saldo_atraso_sabado;						
				}
               
				break;
		}


	 
	}
        $cantidad_creditos_totales = $saldo_sabado + $saldo_miercoles +$termina_sabado_saldo +$termina_miercoles_saldo;
	//$semana_total = $monto_abonado_miercoles + $monto_abonado_sabado;
        foreach ($listar_avance->result() as $row) {
          $semana_total = $row->avance_cobranza;
        }
        if($cantidad_creditos_totales >0){
            $avance_total = round(($semana_total/$cantidad_creditos_totales),2)*100;
        }
        ?>
		<div class="container">
			<div class="grid-17">
				<div class="widget widget-plain">
					<div class="widget-content">
						<h2 class="ticket ticket-success">
							Miercoles
						</h2>				
						<div class="dashboard_report first activeState">
							<div class="pad">
								<span class="value"><?php echo $cantidad_creditos_miercoles; ?></span>Créditos Activos
							</div> <!-- .pad -->
						</div>
						<div class="dashboard_report defaultState">
							<div class="pad">
								<span class="value"><?php echo $atraso_miercoles." Atrasos" ?></span><?php echo "EN PESOS SON: $".$saldo_atraso_miercoles ; ?>
								<?php 
									$porcentaje_miercoles = round($saldo_atraso_miercoles/$saldo_miercoles,2);
								if($porcentaje_miercoles < 0.15){ ?>
									<i class='fa fa-smile-o excelente'></i>
								<?php } if($porcentaje_miercoles > 0.15 && $porcentaje_miercoles < 0.50){ ?>
									<i class='fa fa-meh-o regular'></i>
								<?php } if($porcentaje_miercoles > 0.50){ ?>
									<i class='fa fa-frown-o deudor'></i>
								<?php } ?>							
							</div> <!-- .pad -->
						</div>
						<div class="dashboard_report defaultState">
							<div class="pad">
								<span class="value">$<?php echo $saldo_miercoles + $termina_miercoles_saldo ?></span>Recaudacion normal Esperada
							</div> <!-- .pad -->
						</div>
						<div class="dashboard_report defaultState last">
							<div class="pad">
								<span class="value"><?php echo $semana_miercoles ; ?> pagos</span>$<?php echo $monto_abonado_miercoles; ?> recaudados desde cierre de caja del <?php echo helper_traducir_fecha($ultimo_miercoles);?>
							</div> <!-- .pad -->
						</div>
					</div> <!-- .widget-content -->
					<div class="widget-content">
						<h2 class="ticket ticket-warning">
							Sabados
						</h2>				
						<div class="dashboard_report first activeState">
							<div class="pad">
								<span class="value"><?php echo $cantidad_creditos_sabados; ?></span>Créditos Activos
							</div> <!-- .pad -->
						</div>
						<div class="dashboard_report defaultState">
							<div class="pad">
								<span class="value"><?php echo $atraso_sabado." Atrasos"; ?></span><?php echo "EN PESOS SON: $".$saldo_atraso_sabado; ?>
								<?php 
									$porcentaje_sabado = round($saldo_atraso_sabado/$saldo_sabado,2);
								if($porcentaje_sabado < 0.15){ ?>
									<i class='fa fa-smile-o excelente'></i>
								<?php } if($porcentaje_sabado > 0.15 && $porcentaje_sabado < 0.50){ ?>
									<i class='fa fa-meh-o regular'></i>
								<?php } if($porcentaje_sabado > 0.50){ ?>
									<i class='fa fa-frown-o deudor'></i>
								<?php } ?>
							</div> <!-- .pad -->
						</div>
						<div class="dashboard_report defaultState">
							<div class="pad">
								<span class="value">$<?php echo $saldo_sabado + $termina_sabado_saldo; ?></span>Recaudacion normal Esperada
							</div> <!-- .pad -->
						</div>
						<div class="dashboard_report defaultState last">
							<div class="pad">
								<span class="value"><?php echo $semana_sabado; ?> pagos</span>$<?php echo $monto_abonado_sabado; ?> recaudados desde cierre de caja del <?php echo helper_traducir_fecha($ultimo_sabado);?>
							</div> <!-- .pad -->
						</div>
					</div> <!-- .widget-content -->
				</div> <!-- .widget -->
				 <!-- .widget -->
				<div class="widget widget-table">
					<div class="widget-header">
						<span class="icon-list"></span>
						<h3 class="icon aperture">Grafica de ultimas recaudaciones</h3>
					</div> <!-- .widget-header -->
                                        <div class="widget-content">
                                            <table class="stats" data-chart-type="line" data-chart-colors="">
								
								 <thead>
                                                                        <tr>
                                                                            <td>&nbsp;</td>
                                                                            <?php foreach ($listar_recaudacion->result() as $row) { ?>
                                                                            <th><?php echo $row->semana+1;//date("Y-m-d",strtotime($row->fecha_cierre)); ?></th>
                                                                            <?php } ?>
									</tr>
			
									</thead>

									<tbody>
                                                                            <tr>
                                                                            <th>Recaudacion en pesos por semana</th>
                                                                                <?php foreach ($listar_recaudacion->result() as $row) { ?>
                                                                                       <td><?php echo $row->recaudacion; ?></td>
                                                                                <?php } ?>
                                                                            </tr>
									</tbody>
                                                                
							</table>
                                        </div> 
                                        <!-- .widget-content -->
				</div> <!-- .widget -->	
			</div> <!-- .grid -->
			<div class="grid-7">
				<div id="gettingStarted" class="box">
					<h3>Avance de cobranzas semanales</h3>
                                        <?php 
                                        if($avance_total < 70){ 
                                            $ticket="ticket ticket-important";
                                        } 
                                        if($avance_total >= 70 && $avance_total < 90){
                                            $ticket="ticket ticket-warning";
                                          }
                                        if($avance_total > 90){
                                            $ticket = "ticket ticket-success";
                                        }
                                        ?>
                                        <p>Queda cobrar un <span class="<?php echo $ticket; ?>"><?php echo 100 - $avance_total; ?>%</span> de la recaudacion esperada <span class="ticket ticket-success">($<?php echo $cantidad_creditos_totales; ?>)</span></p>
					<div class="progress-bar secondary">
						<div class="bar" style="width: <?php echo $avance_total; ?>%;"><?php echo $avance_total; ?>%</div>
					</div>
				</div>
				<div class="box">
					<h3>Ultimos Pagos registrados</h3>
                                        <?php foreach ($ultimos_pagos->result() as $row) { 
                                            
                                            ?>
					<ul class="bullet secondary">
                                            <ul class="bullet bullet-blue">
							<li><?php echo $row->nombre_cliente; ?> <?php echo $row->apellido_cliente; ?> pago <span class="ticket ticket-success">$<?php echo $row->monto_de_pago_credito; ?></span> el <?php echo date("Y-m-d",strtotime($row->fecha_de_pago_credito)); ?> <?php if($this->session->userdata('usuario') == "sazubel" ){ ?><a id="boton_borrar" class="boton_borrar" value="<?php echo $row->id_pago_creditos; ?>"><?php echo $row->id_pago_creditos; ?></a><?php } ?></li>
                                            </ul>
                                        </ul>
                                            <?php } ?>
				</div> <!-- .box -->
			</div> <!-- .grid -->
		</div> <!-- .container -->		
	</div> <!-- #content -->