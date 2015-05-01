<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelo_creditos extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
//function alta_de_credito($f_var_id_usuario,$f_var_id_cliente,$f_var_tipo_credito,$f_var_cant_cuotas,$f_var_monto_cuota,$f_var_monto_prestamo,$f_var_detalle_credito,$f_var_fecha_entrega,$f_var_fecha_1er_pago,$fecha_fin_credito,$f_var_notas_complementarias,$f_var_id_zona_cobros,$f_var_id_dia_cobranza)
function alta_de_credito($formulario_creditos){
$this->db->insert('tabla_creditos', $formulario_creditos);
	{
		/*
		//$this->db->insert('tabla_creditos', $formulario_creditos);
		$buscar_cantidad_dias = $this->db->query('SELECT cantidad_dias from tabla_creditos_tipos where id_creditos_tipos = '.$f_var_tipo_credito.'');
		foreach ($buscar_cantidad_dias->result() as $row) { 
			$cantidad_dias = $row->cantidad_dias * $f_var_cant_cuotas;
			$fecha_fin_credito = strtotime( '+ '.$cantidad_dias.' day' , strtotime ( $f_var_fecha_entrega ) ) ;
			$fecha_fin_credito = date ( 'Y-m-d' , $fecha_fin_credito );
		}
		$this->db->query('INSERT INTO tabla_creditos,  (id_usuario,id_cliente,id_tipo_credito,cantidad_cuotas,monto_cuota,capital_costo_invertido,detalle_credito,fecha_de_entrega_del_bien,fecha_proximo_pago,fecha_fin_credito,estado_credito,notas_complementarias,id_zona_de_cobros,id_dia_cobranza) VALUES ('.$f_var_id_usuario.','.$f_var_id_cliente.','.$f_var_tipo_credito.','.$f_var_cant_cuotas.','.$f_var_monto_cuota.','.$f_var_monto_prestamo.','.$f_var_detalle_credito.','.$f_var_fecha_entrega.','.$f_var_fecha_1er_pago.','.$fecha_fin_credito.','.$f_var_notas_complementarias.','.$f_var_id_zona_cobros.','.$f_var_id_dia_cobranza.'');
		*/	
		$ultimo_id_credito = $this->db->insert_id();
		
		$this->db->query('INSERT INTO tabla_pago_creditos (id_credito,monto_de_pago_credito) VALUES ('.$ultimo_id_credito.',0)');
		return TRUE;

	}
	
}
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
	function listar_creditos()
	{	
		$query = $this->db->query("
		SELECT tc.id_credito,tc.capital_costo_invertido,tc.cantidad_cuotas, tc.monto_cuota,tc.fecha_proximo_pago,tcl.nombre_cliente,tcl.apellido_cliente,tcl.dni_cliente,tct.tipos_de_creditos
		FROM tabla_creditos tc, tabla_clientes tcl, tabla_creditos_tipos tct 
		WHERE tc.id_cliente = tcl.id_cliente and tct.id_creditos_tipos = tc.id_tipo_credito");
		return $query;
	}

/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
	function mostrar_credito($id_credito)
	{	

	$query = $this->db->query('
	SELECT * FROM tabla_creditos tc, tabla_clientes tcl, tabla_creditos_tipos tct 
	WHERE tc.id_credito = "'.$id_credito.'" AND tcl.id_cliente = tc.id_cliente AND tct.id_creditos_tipos = tc.id_tipo_credito');
	/*
		$this->db->select('*');
        $this->db->from('tabla_creditos');
		$this->db->where('id_credito', $id_credito);
		$this->db->join('tabla_clientes', 'tabla_clientes.id_cliente = tabla_creditos.id_cliente');
		$this->db->join('tabla_creditos_tipos', 'tabla_creditos_tipos.id_creditos_tipos = tabla_creditos.id_tipo_credito');
		$query = $this->db->get();
		
		*/
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


























   
   
}
   