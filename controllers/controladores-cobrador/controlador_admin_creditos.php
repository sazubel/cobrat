<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controlador_admin_creditos extends CI_Controller {

public function listar_proximos_cobros()
{		
	if($this->session->userdata('permiso_usuario')!=1) { redirect('controlador_administracion/cerrar_cession'); }
	
	            $this -> load -> model ('modelo_creditos');
					/*cargo arreglo con los resultados de la funcion listar_clientes*/
			    $data['lista'] = $this -> modelo_creditos -> contar_creditos();
				
				//echo ('LOS DATOS INGRESADOS SON CORRECTOS');
				$data['titulo_pagina']="Sistema de Administracion - Inti Hogar";
				$data['botonera']="administrador/botonera_admin";
				$data['botonera_top']="administrador/botonera_admin_top";
				$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administrador/creditos/pagina_admin_listar_proximos_cobros";
				$data['boton_destacado']=8;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('admin_template', $data);				
}




}