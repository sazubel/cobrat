<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controlador_administracion extends CI_Controller {

	

public function escritorio()
{		
	//if($this->session->userdata('permiso_usuario')!=1) { redirect('controlador_administracion/cerrar_cession'); }
				
				//echo ('LOS DATOS INGRESADOS SON CORRECTOS');
				$this -> load -> model ('modelos-cobrador/modelo_creditos');
				$this -> load -> model ('modelos-cobrador/modelo_pagos');              
				$data['lista'] = $this -> modelo_creditos -> listar_creditos();
                                $data['cierre_caja'] = $this -> modelo_pagos -> listar_ultimo_cierre_caja();
                                $data['listar_recaudacion'] = $this -> modelo_pagos -> listar_recaudacion();
                                $data['ultimos_pagos'] = $this -> modelo_pagos -> listar_ultimos_pagos();
				$data['titulo_pagina']="Sistema de Administracion - Cobrat";
				$data['sidebar_botonera']="administracion-cobrador/admin_sidebar_menu";
				$data['admin_menu_top']="administracion-cobrador/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administracion-cobrador/pagina_escritorio";
				$data['boton_destacado']=1;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('administracion-cobrador/admin_template', $data);				
}

public function salir(){
  $this->session->sess_destroy();
  $this->load->view('loginusuarios/pagina-bienvenida');
 }









}//class Controlador_administracion extends CI_Controller {


