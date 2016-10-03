<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Parceria extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('tipo_servico');
		$this->load->model('parcerias','parceiro');
		$this->load->model('seo');
	}

	public function index()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$d['tipo_servico'] = $this->tipo_servico->exibeTipoServico();
		$d['exibe_parceiros'] = $this->parceiro->exibeParceirosNoSite();
		$this->load->view('parceria',$d);
	}
	public function form()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$d['tipo_servico'] = $this->tipo_servico->exibeTipoServico();
		$d['exibe_parceiros'] = $this->parceiro->exibeParceirosNoSite();
		$d['form'] = 1;
		$this->load->view('parceria',$d);
	}
	public function valida()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('telefone', 'Telefone', 'required');
		$this->form_validation->set_rules('tipo_servico', 'Serviço', 'required');
		$this->form_validation->set_rules('site', 'Site', 'required');
		$this->form_validation->set_rules('descricao', 'descricao', 'required');
		$this->form_validation->set_rules('url', 'URL', 'required|is_unique["parceria.url"]');
		$d['tipo_servico'] = $this->tipo_servico->exibeTipoServico();
		$d['exibe_parceiros'] = $this->parceiro->exibeParceirosNoSite();
		$d['form'] = 1;
		if ($this->form_validation->run() == FALSE)
		{
			$d['post'] = $this->input->post();

			$d['msg'] = 'Todos os dados são necessários';
			$this->load->view('parceria',$d);	
		}
		else{

			$d['post'] = $this->input->post();
			if($this->parceiro->consultaUrlCadastrada( $this->input->post('url') ) )
			{
				$d['post'] = $this->input->post();
				$d['msg'] = 'Esse site já foi gravado';
				$this->load->view('parceria',$d);
			}
			else
			{
				$d['post'] = $this->input->post();
				$d['post']['data_alt'] = date('Y-m-d');
				$d['post']['hora_alt'] = date('H:i:s');
				if($this->parceiro->gravaParceria($d['post'] ))
				{
					$d['msg'] = 'Site Gravado com sucesso!';
					
					redirect('parceria');	
				}
				else{
					$d['msg'] = 'O Site não foi gravado';
					$this->load->view('parceria',$d);
				}
			}	
		}	
	}
}