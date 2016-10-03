<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminpainel extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario');
		$this->load->model('depoimento');
		$this->load->model('seo');
	}

	public function index()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$this->load->view('adminpainel',$d);
	}

	public function valida()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('senha', 'Senha', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view('admin',$d);
		}
		else
		{	
			$login = $this->usuario->validaEmaileSenha( trim($this->input->post('email') ), md5( trim( $this->input->post('senha') ) ) ) ;
			if($login) 
			{
				$a['nome'] = trim($login);
				$this->session->set_userdata($a);
				redirect('home');
			}
			else{
				$this->load->view('admin',$d );
			}
		}
	}
	public function sair()
	{
		$this->session->sess_destroy();
		redirect('home');

	}




}