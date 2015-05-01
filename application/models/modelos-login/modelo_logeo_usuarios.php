<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelo_logeo_usuarios extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
	function verificar_login ($username, $password)
	{
        // Esta función recibe como parámetros el nombre de usuario y password
		$this -> db -> select('usuario, clave,id_tipo_usuario'); 
		$this -> db -> from('tabla_usuarios'); // indicamos la tabla a usar
		$this -> db -> where('usuario = ' . "'" . $username . "'"); // Indicamos que va a buscar el nombre de usuario
		$this -> db -> where('clave = ' . "'" . $password . "'"); // Indicamos que va a buscar el password con MD5
		$this -> db -> limit(1);
                // Solo deberá de existir un usuario

		$query = $this -> db -> get();
                // Obtenemos los resultados del query

		if($query -> num_rows() == 1)
		{
			return $query->result();
                        // Existen nombre de usuario y contra seña.
		}
		else
		{
			return false;
                       // No existe nombre de usuario o contraseña.
		}

	}
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
	function verificar_privilegios_de_usuarios ($username)
	{
		$this->db->select('id_tipo_usuario');
        $this->db->from('tabla_usuarios');
        $this->db->where('usuario', $username);
		$this -> db -> limit(1);
		
		$query = $this->db->get();
		
		foreach ($query->result() as $row) 
		{
		return  $row->id_tipo_usuario;
		}
	}
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////*/	
	function pedir_id_usuario($username)
	{
		$this->db->select('id_usuario');
        $this->db->from('tabla_usuarios');
        $this->db->where('usuario', $username);
		$this -> db -> limit(1);
		
		$query = $this->db->get();
		
		foreach ($query->result() as $row) 
		{
		return  $row->id_usuario;
		}
	}
	






























   
   
}
   