'<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelo_pagos extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
function alta_de_pago($formulario_pago)
	{
		$id_credito = $formulario_pago['id_credito'];
		$this->db->insert('tabla_pago_creditos', $formulario_pago);
		$borrar_pago_vacio = $this->db->query('DELETE FROM tabla_pago_creditos where monto_de_pago_credito = 0 and fecha_ideal_de_pago = "0000-00-00" and id_credito ="'.$id_credito.'"');
		return TRUE;

	}
	
	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
	function obtener_fecha_proximo_pago($id_credito)
	{	

		$this->db->select('fecha_proximo_pago');
        $this->db->from('tabla_creditos');
		$this->db->where('id_credito', $id_credito);
		$this -> db -> limit(1);
		
		$query = $this->db->get();
		
		foreach ($query->result() as $row) 
		{
		return  $row->fecha_proximo_pago;
		}
	}
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
	function actualizar_fecha_proximo_pago($id_credito)
	{	
		//$buscar_proximo_pago = $this->db->query('select fecha_proximo_pago from tabla_creditos where id_credito = '.$id_credito.'');
		
		$buscar_proximo_pago = $this->db->query('
		SELECT tdc.dia as dia_cobranza, ADDDATE(tc.fecha_entrega_del_bien, INTERVAL (tct.cantidad_dias*tc.cantidad_cuotas) DAY) as fecha_fin_credito,ROUND(DATEDIFF(fecha_fin_credito,Now())/tct.cantidad_dias) as semanas_restantes, ROUND(DATEDIFF(Now(),tc.fecha_entrega_del_bien)/tct.cantidad_dias) as cantidad_cuotas_normal, ROUND(sum(tpc.monto_de_pago_credito)/tc.monto_cuota) as cantidad_cuotas_real,sum(tpc.monto_de_pago_credito) as monto_abonado,tc.fecha_entrega_del_bien, tc.id_credito,tc.capital_costo_invertido,tc.cantidad_cuotas, tc.monto_cuota,tc.fecha_proximo_pago,tcl.nombre_cliente,tcl.apellido_cliente,tcl.dni_cliente,tcl.telefono_fijo_cliente,tcl.celular_cliente,tct.tipos_de_creditos,tct.cantidad_dias FROM tabla_creditos tc, tabla_clientes tcl, tabla_creditos_tipos tct, tabla_pago_creditos tpc, tabla_dia_cobranza tdc WHERE tc.id_cliente = tcl.id_cliente and tct.id_creditos_tipos = tc.id_tipo_credito and tpc.id_credito = tc.id_credito and tdc.id_dia_cobranza = tc.id_dia_cobranza and tc.id_credito = "'.$id_credito.'" group by tc.id_credito');
		$fechahoy = date("Y-m-d");

		foreach ($buscar_proximo_pago->result() as $row) {
			if(($row->cantidad_cuotas_real >= $row->cantidad_cuotas_real) && ($row->fecha_proximo_pago < $fechahoy)){
				$this->db->query('UPDATE tabla_creditos set fecha_proximo_pago = "'.$fechadeproximopago.'" where id_credito = '.$id_credito.'');
			}

		}
/*
		$data = array('fecha_proximo_pago' => $fechadeproximopago);
		$this->db->where('id_credito', $id_credito);
        $this->db->update('tabla_creditos', $data); 	
*/
		return TRUE;
		
	}

/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
	function listar_pagos_de_un_credito($id_credito)
	{	

		$this->db->select('*');
        $this->db->from('tabla_pago_creditos');
		$this->db->where('id_credito', $id_credito);
		return $this->db->get();
	}

	function mostrar_credito($id_credito)
	{	
/*
	$query = $this->db->query('
	SELECT * FROM tabla_creditos tc, tabla_clientes tcl, tabla_creditos_tipos tct 
	WHERE tc.id_credito = "'.$id_credito.'" AND tcl.id_cliente = tc.id_cliente AND tct.id_creditos_tipos = tc.id_tipo_credito');
	*/
		$query = $this->db->query('
		SELECT tc.comision, tdc.dia as dia_cobranza, ADDDATE(tc.fecha_entrega_del_bien, INTERVAL (tct.cantidad_dias*tc.cantidad_cuotas) DAY) as fecha_fin_credito,ROUND(DATEDIFF(fecha_fin_credito,Now())/tct.cantidad_dias) as semanas_restantes, ROUND(DATEDIFF(Now(),tc.fecha_entrega_del_bien)/tct.cantidad_dias) as cantidad_cuotas_normal, ROUND(sum(tpc.monto_de_pago_credito)/tc.monto_cuota) as cantidad_cuotas_real,sum(tpc.monto_de_pago_credito) as monto_abonado,tc.fecha_entrega_del_bien, tc.id_credito,tc.capital_costo_invertido,tc.cantidad_cuotas, tc.monto_cuota,tc.fecha_proximo_pago,tcl.nombre_cliente,tcl.apellido_cliente,tcl.dni_cliente,tcl.telefono_fijo_cliente,tcl.celular_cliente,tct.tipos_de_creditos,tct.cantidad_dias FROM tabla_creditos tc, tabla_clientes tcl, tabla_creditos_tipos tct, tabla_pago_creditos tpc, tabla_dia_cobranza tdc WHERE tc.id_cliente = tcl.id_cliente and tct.id_creditos_tipos = tc.id_tipo_credito and tpc.id_credito = tc.id_credito and tdc.id_dia_cobranza = tc.id_dia_cobranza and tc.id_credito = "'.$id_credito.'" group by tc.id_credito');

		/*cargo el arreglo $DATA que sera enviado a la vistas*/
		foreach ($query->result() as $row) {
		$data["credito"]["id_credito"] = $row->id_credito;
		$data["credito"]["nombre"] = $row->nombre_cliente;
		$data["credito"]["apellido"] = $row->apellido_cliente;
		$data["credito"]["dni"] = $row->dni_cliente;
		$data["credito"]["fijo"] = $row->telefono_fijo_cliente;
		$data["credito"]["celular"] = $row->celular_cliente;		
		$data["credito"]["tipocredito"] = $row->tipos_de_creditos;
		$data["credito"]["cantidadcuotas"] = $row->cantidad_cuotas;
		$data["credito"]["montocuota"] = $row->monto_cuota;
		$data["credito"]["proximopago"] = $row->fecha_proximo_pago;
		$data["credito"]["cantidad_cuotas_normal"] = $row->cantidad_cuotas_normal;
		$data["credito"]["cantidad_cuotas_real"] = $row->cantidad_cuotas_real;
		$data["credito"]["dia_cobranza"] = $row->dia_cobranza;
		$data["credito"]["fecha_entrega_del_bien"] = $row->fecha_entrega_del_bien;
		$data["credito"]["fecha_fin_credito"] = $row->fecha_fin_credito;
		$data["credito"]["semanas_restantes"] = $row->semanas_restantes;
		$data["credito"]["comision"] = $row->comision;


		}

		return $data;
	}

	function listar_creditos_semanales()
	{	
		$fechahoy = date("Y-m-d");
		$query = $this->db->query("
		SELECT tc.comision,(ROUND(DATEDIFF(Now(),tc.fecha_entrega_del_bien)/tct.cantidad_dias) - ROUND(sum(tpc.monto_de_pago_credito)/tc.monto_cuota)) as mora_de_cuotas, 
		tdc.dia as dia_cobranza, ADDDATE(tc.fecha_entrega_del_bien, INTERVAL (tct.cantidad_dias*tc.cantidad_cuotas) DAY) as fecha_fin_credito,
		ROUND(DATEDIFF(fecha_fin_credito,Now())/tct.cantidad_dias) as semanas_restantes, 
		ROUND(DATEDIFF(Now(),tc.fecha_entrega_del_bien)/tct.cantidad_dias) as cantidad_cuotas_normal, 
		ROUND(sum(tpc.monto_de_pago_credito)/tc.monto_cuota) as cantidad_cuotas_real,sum(tpc.monto_de_pago_credito) as monto_abonado,
		tc.fecha_entrega_del_bien, tc.id_credito,tc.capital_costo_invertido,tc.cantidad_cuotas, tc.monto_cuota,tc.fecha_proximo_pago,
		tcl.nombre_cliente,tcl.apellido_cliente,tcl.dni_cliente,tcl.telefono_fijo_cliente,tcl.celular_cliente,tct.tipos_de_creditos,tct.cantidad_dias 
		FROM tabla_creditos tc, tabla_clientes tcl, tabla_creditos_tipos tct, tabla_pago_creditos tpc, tabla_dia_cobranza tdc 
		WHERE tc.id_cliente = tcl.id_cliente and tct.id_creditos_tipos = tc.id_tipo_credito and tpc.id_credito = tc.id_credito 
		and tdc.id_dia_cobranza = tc.id_dia_cobranza group by tc.id_credito order by mora_de_cuotas desc");
		foreach ($query->result() as $row){
			$fecha_actual = date("Y-m-d");
							switch($row->dia_cobranza){
							case "Domingo":
								$proximo_pago = strtotime("sunday next week");
								$proximo_pago = date("Y-m-d",$proximo_pago);
							break;
							case "Lunes":
								$proximo_pago = strtotime("monday next week");
								$proximo_pago = date("Y-m-d",$proximo_pago);
							break;
							case "Martes":
								$proximo_pago = strtotime("tuesday next week");
								$proximo_pago = date("Y-m-d",$proximo_pago);
							break;
							case "Miercoles":
								switch($row->tipos_de_creditos){
									case "Semanal":	
									$proximo_pago = strtotime("wednesday this week");
									$proximo_pago = date("Y-m-d",$proximo_pago);
										if($fecha_actual < $proximo_pago){
										$proximo_pago = strtotime("wednesday this week");
										$proximo_pago = date("Y-m-d",$proximo_pago);
										}else{
										$proximo_pago = strtotime("wednesday next week");
										$proximo_pago = date("Y-m-d",$proximo_pago);										
										}
									break;
									case "Quincenal":
									if($row->mora_de_cuotas > 0){
									$proximo_pago = strtotime("wednesday this week");
									$proximo_pago = date("Y-m-d",$proximo_pago);
										if($fecha_actual < $proximo_pago){
										$proximo_pago = strtotime("wednesday this week");
										$proximo_pago = date("Y-m-d",$proximo_pago);
										}else{
										$proximo_pago = strtotime("wednesday next week");
										$proximo_pago = date("Y-m-d",$proximo_pago);
										}
									} else {
									$proximo_pago = $row->fecha_proximo_pago;
									$proximo_pago = strtotime ( '+2 week' , strtotime ( $proximo_pago ) ) ;
									$proximo_pago = date("Y-m-d",$proximo_pago);
									}
									break;
								}
							break;
							case "Jueves":
								$proximo_pago = strtotime("thursday this week");
								$proximo_pago = date("Y-m-d",$proximo_pago);
							break;
							case "Viernes":
								$proximo_pago = strtotime("friday next week");
								$proximo_pago = date("Y-m-d",$proximo_pago);
							break;
							case "Sabado":
								switch($row->tipos_de_creditos){
									case "Semanal":
									$proximo_pago = strtotime("saturday this week");
									$proximo_pago = date("Y-m-d",$proximo_pago);
										if($fecha_actual < $proximo_pago){
										$proximo_pago = strtotime("saturday this week");
										$proximo_pago = date("Y-m-d",$proximo_pago);
										}else{
										$proximo_pago = strtotime("saturday next week");
										$proximo_pago = date("Y-m-d",$proximo_pago);										
										}
									break;
									case "Quincenal":
									if($row->mora_de_cuotas > 0){
									$proximo_pago = strtotime("saturday this week");
									$proximo_pago = date("Y-m-d",$proximo_pago);
										if($fecha_actual < $proximo_pago){
										$proximo_pago = strtotime("saturday this week");
										$proximo_pago = date("Y-m-d",$proximo_pago);
										}else{
										$proximo_pago = strtotime("saturday next week");
										$proximo_pago = date("Y-m-d",$proximo_pago);
										}
									} else {
									$proximo_pago = $row->fecha_proximo_pago;
									$proximo_pago = strtotime ( '+2 week' , strtotime ( $proximo_pago ) ) ;
									$proximo_pago = date("Y-m-d",$proximo_pago);
									}
									break;
								}
							break;
							
//echo 'UPDATE tabla_creditos set fecha_proximo_pago = '.$proximo_pago.' where id_credito = '.$row->id_credito.''."<br>";
					//$this->db->query('UPDATE tabla_creditos set fecha_proximo_pago = date_add("'.$row->fecha_proximo_pago.'", INTERVAL '.$proximo_pago.' DAY) where id_credito = '.$row->id_credito.'');
							}	
							if($row->fecha_proximo_pago < $fecha_actual ){
								$this->db->query('UPDATE tabla_creditos set fecha_proximo_pago = "'.$proximo_pago.'" where id_credito = '.$row->id_credito.'');
							}
		}
		return $query;
}























   
   
}
   