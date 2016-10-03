<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminparceiro extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario');
		$this->load->model('parcerias');
		$this->load->model('seo');
	}

	public function index()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$d['parceiros'] = $this->parcerias->exibeParceiros();
		$this->load->view('adminparceiro',$d);
	}
	public function exibe()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$exibe 			= $this->uri->segment(3);
		$id_parceiro 	= $this->uri->segment(4);
		$edita 			= $this->parcerias->editaExibicaoParceiro($exibe, $id_parceiro);
		if($edita)
		{
			redirect('adminparceiro');
		}
	}
}