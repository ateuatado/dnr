<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Depoimentos extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('depoimento');
		$this->load->model('seo');
	}

	public function index()
	{	$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$d['depoimentos'] = $this->depoimento->exibeDepoimentoSite();
		$this->load->view('depoimentos', $d);
	}
	public function form()
	{	$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$d['form'] = 1;
		$d['depoimentos'] = $this->depoimento->exibeDepoimentoSite();
		$this->load->view('depoimentos',$d);
	}

	public function valida()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('telefone', 'Telefone', 'required');
		$this->form_validation->set_rules('depoimento', 'Depoimentos', 'required');
		$d['depoimentos'] = $this->depoimento->exibeDepoimentoSite();
		
		if ($this->form_validation->run() === FALSE)
		{	
			$d['teste'] = $this->input->post();
			$d['form'] = 1;

			$this->load->view('depoimentos',$d);
		}
		else
		{	
			$d['id'] = $this->depoimento->pesquisaDepoimento($this->input->post('email'));
			$data = $this->input->post();
			$data['data_alt'] = date('Y-m-d');
			$data['hora_alt'] = date('H:i:s');
			$data['exibe'] = 0;

			if($d['id']){
				$this->depoimento->atualizaDepoimento($data,$d['id']);
			}
			else{
				$this->depoimento->gravaNovoDepoimento($data);
			}
			$d['msg'] = 'O Depoimento foi gravado ou atualizado com sucesso e aguarda moderação da equipe administradora do site.<br>
			Em breve será publicado. Você receberá, no email cadastrado, maiores informações. <br>Obrigado!';
			$this->load->view('depoimentos',$d);
		}
	}
	public function sair()
	{	
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$this->session->sess_destroy();
		redirect('home');
	}




}