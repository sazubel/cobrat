<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
		$monto_de_pago_credito = $formulario_pago['monto_de_pago_credito'];
		
		$id_usuario_que_cobro = $formulario_pago['id_usuario_que_cobro'];
		$fecha_de_pago_credito = $formulario_pago['fecha_de_pago_credito'];


		$buscar_fecha_ideal = $this->db->query('SELECT tc.fecha_proximo_pago,tct.id_creditos_tipos,tpc.id_pago_creditos,tpc.fecha_ideal_de_pago, tct.cantidad_dias 
			FROM tabla_pago_creditos tpc, tabla_creditos_tipos tct, tabla_creditos tc 
			WHERE tc.id_credito = tpc.id_credito and tc.id_tipo_credito = tct.id_creditos_tipos and tpc.id_credito = "'.$id_credito.'" 
			ORDER by tpc.fecha_ideal_de_pago desc limit 1');
		
		foreach ($buscar_fecha_ideal->result() as $row){
			//if($row->fecha_proximo_pago != $row->fecha_ideal_de_pago){
				$fecha_ideal_de_pago = strtotime ( '+'.$row->cantidad_dias.' day' , strtotime ( $row->fecha_ideal_de_pago ) ) ;
				$fecha_ideal_de_pago = date ( 'Y-m-d' , $fecha_ideal_de_pago );
				$formulario_pago['fecha_ideal_de_pago'] = $fecha_ideal_de_pago;
				

				//$this->db->query('UPDATE tabla_pago_creditos set id_usuario_que_cobro ="'.$id_usuario_que_cobro.'", monto_de_pago_credito = "'.$monto_de_pago_credito.'", fecha_de_pago_credito = "'.$fecha_de_pago_credito.'",
				//fecha_ideal_de_pago = "'.$fecha_ideal_de_pago.'" where id_pago_creditos ="'.$row->id_pago_creditos.'"');
		}
			

		
		$this->db->insert('tabla_pago_creditos', $formulario_pago);
		$borrar_pago_vacio = $this->db->query('DELETE FROM tabla_pago_creditos where monto_de_pago_credito = 0 and fecha_de_pago_credito = "0000-00-00 00:00:00" and id_credito ="'.$id_credito.'"');
		return TRUE;

	}
	
        function borrar_pago($id_pago)
	{
	$this->db->query('delete from tabla_pago_creditos where id_pago_creditos = '.$id_pago.'');
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

	function listar_cierre_caja()
	{
            $listar_ultimos_cierres = $this->db->query("SELECT * FROM (select * from tabla_cierre_caja ORDER BY id_cierre desc limit 10) sub order by id_cierre asc");
	return $listar_ultimos_cierres;
        /*
		$this->db->select('*');
        $this->db->from('tabla_cierre_caja');
        $this->db->order_by("fecha_cierre", "desc"); 
        $this->db->limit(10);
		return $this->db->get();
         * 
         */
	}
function listar_ultimo_cierre_caja()
	{
    	
        $this->db->select('*');
        $this->db->from('tabla_cierre_caja');
        $this->db->order_by("fecha_cierre", "desc"); 
        $this->db->limit(1);
	return $this->db->get();
    
	}
function listar_recaudacion()
	{
            //$listar_ultimos_cierres = $this->db->query("SELECT * FROM (select * from tabla_cierre_caja ORDER BY id_cierre desc limit 10) sub order by id_cierre asc");
	
            $listar_ultimos_cierres = $this->db->query("Select week(fecha_cierre) as semana,sum(monto_caja) as recaudacion From tabla_cierre_caja group by week(fecha_cierre) order by semana asc");
            return $listar_ultimos_cierres;

	}
function listar_ultimos_pagos()
	{
        $ultimo_cierre = $this->db->query("select fecha_cierre from tabla_cierre_caja order by fecha_cierre desc limit 1");
        foreach ($ultimo_cierre->result() as $row){
            $ultimo_cierre_caja = $row->fecha_cierre; 
        }
	$listar_ultimos_pagos = $this->db->query("SELECT tc.id_dia_cobranza,tpc.id_pago_creditos, tpc.fecha_de_pago_credito, tcl.nombre_cliente, tcl.apellido_cliente, tpc.monto_de_pago_credito 
                      FROM tabla_pago_creditos tpc, tabla_creditos tc, tabla_clientes tcl 
                      WHERE tpc.id_credito = tc.id_credito and tc.id_cliente = tcl.id_cliente and tpc.fecha_de_pago_credito > '".$ultimo_cierre_caja."' ORDER BY `tpc`.`fecha_de_pago_credito` DESC");
	/*
        echo "SELECT tc.id_dia_cobranza,tpc.id_pago_creditos, tpc.fecha_de_pago_credito, tcl.nombre_cliente, tcl.apellido_cliente, tpc.monto_de_pago_credito 
                      FROM tabla_pago_creditos tpc, tabla_creditos tc, tabla_clientes tcl 
                      WHERE tpc.id_credito = tc.id_credito and tc.id_cliente = tcl.id_cliente and tpc.fecha_de_pago_credito > '".$ultimo_cierre_caja."' ORDER BY `tpc`.`fecha_de_pago_credito` DESC";
        exit();
         * 
         */
        return $listar_ultimos_pagos;
        
	}
function listar_avance()
	{
            $ultimo_cierre = $this->db->query("select max(fecha_cierre) as fecha_cierre from tabla_cierre_caja");
            $ultimo_cierre = $ultimo_cierre->row_array();
            $ultimo_cierre_preciso = $ultimo_cierre['fecha_cierre'];
            $ultimo_cierre = date("Y-m-d",strtotime($ultimo_cierre_preciso));
            $segundos=strtotime('now') - strtotime($ultimo_cierre) ;
            $diferencia_dias=intval($segundos/60/60/24);
            $dia_cierre = helper_traducir_fecha($ultimo_cierre);
            $dia_cierre = explode(" ", $dia_cierre);
            $dia_cierre = $dia_cierre[0];

            if(($diferencia_dias <= 2)&&($dia_cierre == "Sabado")){
                $ultimo_cierre=strtotime('-7 day', strtotime($ultimo_cierre)) ;// resta 1 semana
                $ultimo_cierre = date('Y-m-d', $ultimo_cierre) ; 
            }
             //echo $ultimo_cierre;
            //exit();
            $ultimo_cierre= $this->db->query("select max(fecha_cierre) as fecha_cierre from tabla_cierre_caja where fecha_cierre like '%".$ultimo_cierre."%'");
            //echo "select max(fecha_cierre) as fecha_cierre from tabla_cierre_caja where fecha_cierre like '%".$ultimo_cierre."%'";
                foreach ($ultimo_cierre->result() as $row){
                     $ultimo_cierre = $row->fecha_cierre;

                }
        
        
    
        	$listar_avance = $this->db->query("SELECT sum(tpc.monto_de_pago_credito) as avance_cobranza FROM tabla_pago_creditos tpc, tabla_creditos tc, tabla_clientes tcl 
                      WHERE tpc.id_credito = tc.id_credito and tc.id_cliente = tcl.id_cliente and tpc.fecha_de_pago_credito > '".$ultimo_cierre."' ORDER BY `tpc`.`fecha_de_pago_credito` DESC");
                
                /*
                echo"SELECT sum(tpc.monto_de_pago_credito) as avance_cobranza FROM tabla_pago_creditos tpc, tabla_creditos tc, tabla_clientes tcl 
                      WHERE tpc.id_credito = tc.id_credito and tc.id_cliente = tcl.id_cliente and tpc.fecha_de_pago_credito > '".$ultimo_cierre."' ORDER BY `tpc`.`fecha_de_pago_credito` DESC";
                
                exit();
                */ 
                 
                
                 
                return $listar_avance;
        }
        
	function calcular_cierre_caja()
	{
		$buscar_ultimo_cierre = $this->db->query('select max(fecha_cierre) as ultimo_cierre FROM tabla_cierre_caja');
		foreach ($buscar_ultimo_cierre->result() as $row) {
			$ultimo_cierre = $row->ultimo_cierre;
		}
		$sumar_ultimos_pagos = $this->db->query('select sum(monto_de_pago_credito) as ultimos_pagos, sum(pago_comision) as comision FROM tabla_pago_creditos WHERE fecha_de_pago_credito < now() and fecha_de_pago_credito > "'.$ultimo_cierre.'"');
		foreach ($sumar_ultimos_pagos->result() as $row) {
			$data["cierre_caja"]["ultimos_pagos"] = $row->ultimos_pagos;
			$data["cierre_caja"]["comision"] = $row->comision;
		}
		//$this->db->query('insert into tabla_cierre_caja (fecha_cierre,monto_caja) values (now(),'.$sumar_ultimos_pagos.')');
		return $data;
	}

	function ingresar_cierre_caja($formulario_cierre)
	{
		
		$this->db->query('insert into tabla_cierre_caja (fecha_cierre,monto_caja,comision_cierre) values (now(),'.$formulario_cierre['monto_caja'].','.$formulario_cierre['comision_cierre'].')');
		return TRUE;
	}



	function mostrar_credito($id_credito)
	{	
/*
	$query = $this->db->query('
	SELECT * FROM tabla_creditos tc, tabla_clientes tcl, tabla_creditos_tipos tct 
	WHERE tc.id_credito = "'.$id_credito.'" AND tcl.id_cliente = tc.id_cliente AND tct.id_creditos_tipos = tc.id_tipo_credito');
	*/
		$query = $this->db->query('
		SELECT tc.comision, tdc.dia as dia_cobranza, ADDDATE(tc.fecha_entrega_del_bien, 
		INTERVAL (tct.cantidad_dias*tc.cantidad_cuotas) DAY) as fecha_fin_credito,
		(DATEDIFF(fecha_fin_credito,Now())/tct.cantidad_dias) as semanas_restantes, 
		(DATEDIFF(Now(),tc.fecha_entrega_del_bien)/tct.cantidad_dias) as cantidad_cuotas_normal, 
		ROUND(sum(tpc.monto_de_pago_credito)/tc.monto_cuota) as cantidad_cuotas_real,
		sum(tpc.monto_de_pago_credito) as monto_abonado,tc.fecha_entrega_del_bien, tc.id_credito,tc.capital_costo_invertido,tc.cantidad_cuotas,
		tc.monto_cuota,tc.fecha_proximo_pago,tcl.nombre_cliente,tcl.apellido_cliente,tcl.dni_cliente,tcl.telefono_fijo_cliente,tcl.celular_cliente,
		tct.tipos_de_creditos,tct.cantidad_dias FROM tabla_creditos tc, tabla_clientes tcl, tabla_creditos_tipos tct, tabla_pago_creditos tpc, 
		tabla_dia_cobranza tdc WHERE tc.id_cliente = tcl.id_cliente and tct.id_creditos_tipos = tc.id_tipo_credito and 
		tpc.id_credito = tc.id_credito and tdc.id_dia_cobranza = tc.id_dia_cobranza and tc.id_credito = "'.$id_credito.'" group by tc.id_credito');

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
		$query = $this->db->query("SELECT max(tpc.fecha_de_pago_credito) as ultimo_pago, 
		(ROUND(DATEDIFF(Now(),tc.fecha_entrega_del_bien)/tct.cantidad_dias) - (sum(tpc.monto_de_pago_credito)/tc.monto_cuota)) as mora_de_cuotas, 
		tdc.dia as dia_cobranza, 
		ADDDATE(tc.fecha_entrega_del_bien,INTERVAL (tct.cantidad_dias*tc.cantidad_cuotas) DAY) as fecha_fin_credito,
		ROUND(DATEDIFF(fecha_fin_credito,Now())/tct.cantidad_dias) as semanas_restantes, 
		(DATEDIFF(Now(),tc.fecha_entrega_del_bien)/tct.cantidad_dias) as cantidad_cuotas_normal, 
		ROUND(sum(tpc.monto_de_pago_credito)/tc.monto_cuota) as cantidad_cuotas_real,
		sum(tpc.monto_de_pago_credito) as monto_abonado,
		tc.fecha_entrega_del_bien, tc.id_credito,tc.capital_costo_invertido,tc.cantidad_cuotas, tc.monto_cuota,tc.fecha_proximo_pago,
		tcl.nombre_cliente,tcl.apellido_cliente,tcl.dni_cliente,tcl.telefono_fijo_cliente,tcl.celular_cliente,tct.tipos_de_creditos,
		tct.cantidad_dias FROM tabla_creditos tc, tabla_clientes tcl, tabla_creditos_tipos tct, tabla_pago_creditos tpc, tabla_dia_cobranza tdc
		WHERE tc.id_cliente = tcl.id_cliente and tct.id_creditos_tipos = tc.id_tipo_credito and tpc.id_credito = tc.id_credito and 
		tdc.id_dia_cobranza = tc.id_dia_cobranza and tc.estado_credito = 1 group by tc.id_credito order by mora_de_cuotas desc");
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
							if($row->monto_abonado == ($row->monto_cuota*$row->cantidad_cuotas)){
								$this->db->query('UPDATE tabla_creditos set estado_credito = "0" where id_credito = '.$row->id_credito.'');
							}

		}
		return $query;
}   
}
   