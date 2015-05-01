<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelo_clientes extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


function validar_dni2($usr)
{
	$query = $this->db->query('SELECT * FROM tabla_clientes where dni_cliente="'.$usr.'"');
	//$query = $this->db->query('SELECT * FROM tabla_clientes where dni_cliente="27751880"');
	if($query->num_rows()> 0){
	return true;
	} else {
	return false;
	}
}


function validar_dni()
{
    //echo $var_dni = $this->input->post('var_dni');
	//$query = $this->db->query('SELECT * FROM clientes where dni="'.$var_dni.'"');
	//$query = $this->db->query('SELECT * FROM tabla_clientes where dni_cliente="'.$validateValue.'"');
	$query = $this->db->query('SELECT * FROM tabla_clientes where dni_cliente="27751880"');
	if($query->num_rows() == 0)
	return 0;
	else
	return 1;
}

/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
function alta_de_clientes($formulario_clientes)
	{
		$query = $this->db->query('SELECT * FROM tabla_clientes where dni_cliente="'.$formulario_clientes["dni_cliente"].'"');
		if($query->num_rows() == 0){
			$this->db->insert('tabla_clientes', $formulario_clientes);
			return TRUE;
		}
		else return FALSE;

	}
	
	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
	function listar_clientes()
	{	
		$this->db->select('*');
        $this->db->from('tabla_clientes');
		$this->db->order_by('apellido_cliente', 'asc'); 
		return $this->db->get();
	}




























   
   
}
   