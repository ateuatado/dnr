<?php if ( ! defined('BASEPATH')) exit('Oh! Nãããoooo! Você tentou acessar um script direto!!! Não faz isso, não!');

class Admindepoimento extends CI_Controller {
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
		$d['depoimentos'] = $this->depoimento->exibeDepoimentosPainelAdmin();
		$this->load->view('admindepoimento',$d);
	}

	public function exibe(){
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$exibe = $this->uri->segment(3);
		$id_depoimento = $this->uri->segment(4);
		$edita = $this->depoimento->editaExibicaoDepoimento($exibe, $id_depoimento);
		if($edita)
		{
			redirect('admindepoimento');
		}
	}

}