<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelo_creditos extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
function tipos_de_creditos()
	{
		$tipos_creditos = $this->db->query('select id_creditos_tipos,tipos_de_creditos from tabla_creditos_tipos where tipos_de_creditos = "Semanal" or tipos_de_creditos="Quincenal"');
		return $tipos_creditos;
	}
function alta_de_credito($formulario_creditos)
	{
		$buscar_dia_pago = $this->db->query('select dia_ingles,dia from tabla_dia_cobranza where id_dia_cobranza ="'.$formulario_creditos['id_dia_cobranza'].'"');
		foreach ($buscar_dia_pago->result() as $row){
		$dia_pago_ingles = $row->dia_ingles;
		$dia_pago = $row->dia;
		}
		$buscar_cantidad_dias = $this->db->query('select cantidad_dias,tipos_de_creditos from tabla_creditos_tipos where id_creditos_tipos ="'.$formulario_creditos['id_tipo_credito'].'"');
		foreach ($buscar_cantidad_dias->result() as $row){
		$tipos_de_creditos = $row->tipos_de_creditos;
		}
		$fecha_actual = date("Y-m-d");
		if($formulario_creditos['fecha_proximo_pago'] == "1970-01-01"){
			switch($tipos_de_creditos){
				case "Semanal":
					$dias_diferencia_proxima_semana = strtotime($dia_pago_ingles." next week");
					$dias_diferencia_proxima_semana = date("Y-m-d",$dias_diferencia_proxima_semana);
					$dias_diferencia_proxima_semana = (strtotime($dias_diferencia_proxima_semana)-strtotime($fecha_actual))/86400;
					if($dias_diferencia_proxima_semana < 7 ){
						switch($dia_pago){
							case "Miercoles":
								$proximo_cobro = strtotime("wednesday next week");
								$proximo_cobro = date("Y-m-d",$proximo_cobro);
							break;
							case "Sabado":
								$proximo_cobro = strtotime("wednesday next week");
								$proximo_cobro = date("Y-m-d",$proximo_cobro);
								
							break;
						}
					} elseif($dias_diferencia_proxima_semana > 8) {
						switch($dia_pago){
							case "Miercoles":
								$proximo_cobro = strtotime("wednesday this week");
								$proximo_cobro = date("Y-m-d",$proximo_cobro);
							break;
							case "Sabado":
								$proximo_cobro = strtotime("saturday this week");
								$proximo_cobro = date("Y-m-d",$proximo_cobro);
							break;
						}
					} else {
						$proximo_cobro = strtotime($dia_pago_ingles." next week");
						$proximo_cobro = date("Y-m-d",$proximo_cobro);

					}
				break;
				case "Quincenal":
						switch($dia_pago){
							case "Miercoles":
								$proximo_cobro = strtotime("wednesday this week");
								$proximo_cobro = date("Y-m-d",$proximo_cobro);
								$proximo_cobro = strtotime ( '+2 week' , strtotime ( $proximo_cobro ) ) ;
								$proximo_cobro = date("Y-m-d",$proximo_cobro);
							break;
							case "Sabado":
								$proximo_cobro = strtotime("saturday this week");
								$proximo_cobro = date("Y-m-d",$proximo_cobro);
								$proximo_cobro = strtotime ( '+2 week' , strtotime ( $proximo_cobro ) ) ;
								$proximo_cobro = date("Y-m-d",$proximo_cobro);

							break;
						}
				break;
				case "Mensual":
						switch($dia_pago){
							case "Miercoles":
								echo " primer miercoles ".date("Y-m-d",strtotime('first wednesday of next month'));
								break;
							case "Sabado":
								echo " primer miercoles ".date("Y-m-d",strtotime('first saturday of next month'));
							break;
						}
				break;
				case "Un Pago":
				break;
			
			}
		}

		switch($tipos_de_creditos){
			case "Semanal":
			$cantidad_dias = $formulario_creditos['cantidad_cuotas'] *7;
			$fin_credito = strtotime('+'.$cantidad_dias.' day',strtotime($proximo_cobro));
			$fin_credito = date ( 'Y-m-d' , $fin_credito );
			break;
			case "Quincenal":
			$cantidad_dias = $formulario_creditos['cantidad_cuotas'] *14;
			$fin_credito = strtotime('+'.$cantidad_dias.' day',strtotime($proximo_cobro));
			$fin_credito = date('Y-m-d',$fin_credito);
			break;
			case "Mensual":
			$cantidad_dias = $formulario_creditos['cantidad_cuotas'] *30;
			$fin_credito = strtotime('+'.$cantidad_dias.' day',strtotime($proximo_cobro));
			$fin_credito = date('Y-m-d',$fin_credito);
			break;
		}
		$formulario_creditos['fecha_fin_credito'] = $fin_credito;			
		$formulario_creditos['fecha_proximo_pago'] = $proximo_cobro;
		$formulario_creditos['fecha_entrega_del_bien'] = $fecha_actual;

		$this->db->insert('tabla_creditos', $formulario_creditos);
		$ultimo_id_credito = $this->db->insert_id();
		$this->db->query('INSERT INTO tabla_pago_creditos (id_credito,monto_de_pago_credito,fecha_ideal_de_pago) VALUES ('.$ultimo_id_credito.',0,"'.$proximo_cobro.'")');
		//echo "INSERT INTO tabla_pago_creditos (id_credito,monto_de_pago_credito,fecha_ideal_de_pago) VALUES ('$ultimo_id_credito',0,'$proximo_cobro')";

		//exit();
		return TRUE;

	}
	
	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
	function listar_creditos()
	{	

		$listar_creditos = $this->db->query('SELECT tc.estado_credito,max(tpc.fecha_de_pago_credito) as ultimo_pago, 
			tdc.dia as dia_cobranza, ADDDATE(tc.fecha_entrega_del_bien, 
			INTERVAL (tct.cantidad_dias*tc.cantidad_cuotas) DAY) as fecha_fin_credito,
		ROUND(DATEDIFF(fecha_fin_credito,Now())/tct.cantidad_dias) as semanas_restantes, 
		(DATEDIFF(Now(),tc.fecha_entrega_del_bien)/tct.cantidad_dias) as cantidad_cuotas_normal, 
		ROUND(sum(tpc.monto_de_pago_credito)/tc.monto_cuota) as cantidad_cuotas_real,
		sum(tpc.monto_de_pago_credito) as monto_abonado,tc.fecha_entrega_del_bien, 
		tc.id_credito,tc.capital_costo_invertido,tc.cantidad_cuotas, tc.monto_cuota,tc.fecha_proximo_pago,
		tcl.nombre_cliente,tcl.apellido_cliente,tcl.dni_cliente,tcl.telefono_fijo_cliente,tcl.celular_cliente,
		tct.tipos_de_creditos,tct.cantidad_dias, ((tc.monto_cuota*cantidad_cuotas)-sum(tpc.monto_de_pago_credito)) as saldo 
		FROM tabla_creditos tc, tabla_clientes tcl, tabla_creditos_tipos tct, tabla_pago_creditos tpc, tabla_dia_cobranza tdc 
		WHERE tc.id_cliente = tcl.id_cliente and tct.id_creditos_tipos = tc.id_tipo_credito and tpc.id_credito = tc.id_credito 
		and tdc.id_dia_cobranza = tc.id_dia_cobranza group by tc.id_credito');
        return $listar_creditos;
	}

/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
	function mostrar_credito($id_credito)
	{	

		$this->db->select('*');
        $this->db->from('tabla_creditos');
		$this->db->where('id_credito', $id_credito);
		$this->db->join('tabla_clientes', 'tabla_clientes.id_cliente = tabla_creditos.id_cliente');
		$this->db->join('tabla_creditos_tipos', 'tabla_creditos_tipos.id_creditos_tipos = tabla_creditos.id_tipo_credito');
		$query = $this->db->get();
		
		
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
		}

		return $data;
	}

/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
function helper_contar_creditos_activos_x_usuario($id_cliente)
	{
		$this->db->select('*');
        $this->db->from('tabla_creditos');
		$this->db->where('id_cliente', $id_cliente);		
		$query = $this->db->get();
		return  $query->num_rows(); 
		

	}
























   
   
}
   