<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controlador_administracion extends CI_Controller {

	

public function escritorio()
{		
	//if($this->session->userdata('permiso_usuario')!=1) { redirect('controlador_administracion/cerrar_cession'); }
				
				//echo ('LOS DATOS INGRESADOS SON CORRECTOS');
				$data['titulo_pagina']="Sistema de Administracion - Inti Hogar";
				$data['sidebar_botonera']="administracion/admin_sidebar_menu";
				$data['admin_menu_top']="administracion/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administracion/pagina_escritorio";
				$data['boton_destacado']=1;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('administracion/admin_template', $data);				
}











}//class Controlador_administracion extends CI_Controller {


