<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Controlador_login extends CI_Controller {
	public function index()
	{
		$this->form_validation->set_rules('var_usuario', 'Usuario', 'required');
		$this->form_validation->set_rules('var_pass', 'Password', 'required');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
		if ($this->form_validation->run() == FALSE)
		{
		$this->load->view('loginusuarios/pagina-bienvenida');
		}
		else
			{
				if($this -> input -> post('var_usuario'))
	        		{
					$usuario = $this -> input -> post('var_usuario');
					$password = $this -> input -> post('var_pass');
					}else{
						echo ('las variables no vienen del formulario de ingreso');
						}
				$this->load->model('modelos-login/modelo_logeo_usuarios', '', TRUE);
		    	$datos_usuario = $this->modelo_logeo_usuarios->verificar_login($usuario, $password);
				if($datos_usuario)
						{
								$this->session->set_userdata('usuario', $usuario);
								$this->session->set_userdata('id_usuario', $this->modelo_logeo_usuarios->pedir_id_usuario($usuario));
								$this->session->set_userdata('permiso_usuario', $this->modelo_logeo_usuarios->verificar_privilegios_de_usuarios($usuario));		
								switch ($this->modelo_logeo_usuarios->verificar_privilegios_de_usuarios($usuario)) 
							    {
							      case 1 :
							               redirect('controladores-admin/controlador_administracion/escritorio');
   							      break;
   							      case 2 :
							                redirect('controladores-cobrador/controlador_administracion/escritorio');
   							      break;
							}
						}					
						else{
								$this->load->view('loginusuarios/pagina-bienvenida');
							}
			}	
	}
}