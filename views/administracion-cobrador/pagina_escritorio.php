<div id="content">		
		
		<div id="contentHeader">
			<h1><?php echo $this->session->userdata('usuario'); ?>/Escritorio</h1>
		</div> <!-- #contentHeader -->	
<?php 
	$saldo_sabado = 0;
	$saldo_miercoles = 0;
	$atraso_miercoles = 0;
	$atraso_sabado = 0;
	$abonados_miercoles = 0;
	$abonados_sabado = 0;
	$saldo_atraso_miercoles = 0;
	$saldo_atraso_sabado = 0;
	$cantidad_creditos_miercoles = 0;
	$cantidad_creditos_sabados = 0;
	$ultimo_miercoles = strtotime("wednesday last week");
	$ultimo_miercoles = date("Y-m-d",$ultimo_miercoles);
	$ultimo_sabado = strtotime("saturday last week");
	$ultimo_sabado = date("Y-m-d",$ultimo_sabado);
	$proximo_sabado = strtotime("saturday this week");
	$proximo_sabado = date("Y-m-d",$proximo_sabado);
	$semana_miercoles = 0;
	$semana_sabado = 0;
	//$hoy = date('Y-m-d H:i:s');
	$hoy = date('Y-m-d');
	foreach ($lista->result() as $row) {
		switch ($row->dia_cobranza) {
			case 'Miercoles':
				
				if($row->estado_credito==1) { 
						$cantidad_creditos_miercoles = 1 + $cantidad_creditos_miercoles;
						$saldo_miercoles = $row->monto_cuota + $saldo_miercoles;
				}
				if(($row->cantidad_cuotas_real < floor($row->cantidad_cuotas_normal))&&($hoy != $row->fecha_proximo_pago)&&($row->estado_credito==1)){
					$atraso_miercoles = $atraso_miercoles + 1;
					$saldo_atraso_miercoles = ((floor($row->cantidad_cuotas_normal)*$row->monto_cuota)-$row->monto_abonado) + $saldo_atraso_miercoles;

				}
				
				$ultimo_pago = date("Y-m-d",strtotime($row->ultimo_pago));				
				if(($ultimo_pago > $ultimo_miercoles)){
					if(($row->cantidad_cuotas_real) >= (floor($row->cantidad_cuotas_normal))){
							$semana_miercoles = $semana_miercoles +1;

					}	
				}
				
				break;
			
			case 'Sabado':
				if($row->estado_credito==1) {
					$saldo_sabado = $row->monto_cuota + $saldo_sabado;
					$cantidad_creditos_sabados = 1 + $cantidad_creditos_sabados;
				}
				if(($row->cantidad_cuotas_real < floor($row->cantidad_cuotas_normal))&&($hoy != $row->fecha_proximo_pago)&&($row->estado_credito==1)){
					$atraso_sabado = $atraso_sabado + 1;
					//echo $row->nombre_cliente." ".$row->apellido_cliente."<br>";
					$saldo_atraso_sabado = ((floor($row->cantidad_cuotas_normal)*$row->monto_cuota)-$row->monto_abonado) + $saldo_atraso_sabado;
				}
				$ultimo_pago_sabado = date("Y-m-d",strtotime($row->ultimo_pago));				
				if(($ultimo_pago_sabado > $ultimo_sabado)){
					if(($row->cantidad_cuotas_real) >= (floor($row->cantidad_cuotas_normal))){
							$semana_sabado = $semana_sabado +1;
							
					}	
				}				
				break;
		}
		$cantidad_creditos_totales = $cantidad_creditos_miercoles + $cantidad_creditos_sabados;
		$semana_total = $semana_miercoles + $semana_sabado;
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
								<span class="value"><?php echo $saldo_miercoles; ?></span>Recaudacion normal Esperada
							</div> <!-- .pad -->
						</div>
						<div class="dashboard_report defaultState last">
							<div class="pad">
								<span class="value"><?php echo $semana_miercoles; ?></span>Activos abonados de esta Semana
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
								<span class="value"><?php echo $saldo_sabado; ?></span>Recaudacion normal Esperada
							</div> <!-- .pad -->
						</div>
						<div class="dashboard_report defaultState last">
							<div class="pad">
								<span class="value"><?php echo $semana_sabado; ?></span>Activos abonados de esta Semana.
							</div> <!-- .pad -->
						</div>
					</div> <!-- .widget-content -->
				</div> <!-- .widget -->
				 <!-- .widget -->
				<div class="widget widget-table">
					<div class="widget-header">
						<span class="icon-list"></span>
						<h3 class="icon aperture">Tables</h3>
					</div> <!-- .widget-header -->
					<div class="widget-content"></div> <!-- .widget-content -->
				</div> <!-- .widget -->	
			</div> <!-- .grid -->			
			<div class="grid-7">
				<div id="gettingStarted" class="box">
					<h3>Avance de cobranzas semanales</h3>
					<p>Queda un <?php echo 100 - $avance_total; ?>% del total de créditos para cobrar</p>
					<div class="progress-bar secondary">
						<div class="bar" style="width: <?php echo $avance_total; ?>%;"><?php echo $avance_total; ?>%</div>
					</div>
				</div>
				<div class="box plain">
					<a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion_creditos/listar_creditos" class="btn btn-primary btn-large dashboard_add">Registrar Pago</a>
					<a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion_creditos/agregar_credito" class="btn btn-tertiary btn-large dashboard_add">Agregar nuevo Crédito</a>
					<a href="<?php echo base_url();?>index.php/controladores-cobrador/controlador_administracion_clientes/agregar_cliente" class="btn btn-quaternary btn-large dashboard_add">Agregar nuevo Cliente</a>					
				</div>
				<div class="box">
					<h3>Ultimas Actividades<br> registradasen el sistema</h3>
					<ul class="bullet secondary">
						<li>Proximamente</li>
					</ul>
					<ul class="bullet primary">
						<li>Proximamente</li>
					</ul>
				</div> <!-- .box -->
			</div> <!-- .grid -->
		</div> <!-- .container -->		
	</div> <!-- #content -->