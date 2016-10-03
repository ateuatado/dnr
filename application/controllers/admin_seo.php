<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_seo extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('seo');
	}

	public function index()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$d['exibe'] = $this->seo->exibeSeo();
		$this->load->view('admin_seo',$d);	
	}
	public function form()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$id_seo = $this->uri->segment(3);
		$d['exibe'] = $this->seo->exibeSeo();
		$d['form'] = 1;
		$d['id_seo'] = $id_seo;
		$this->load->view('admin_seo',$d);	
	}
	public function validaform()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$this->form_validation->set_rules('nome_pagina', 'URL da Página', '');
		$this->form_validation->set_rules('titulo', 'Título da Página', 'required');
		$this->form_validation->set_rules('descricao', 'Descrição da Página', 'required');
		$this->form_validation->set_rules('palavra_chave', 'Palavra Chave', 'required');
		$id_seo = $this->uri->segment(3);
		$d['exibe'] = $this->seo->exibeSeo();
		$d['form'] = 1;;
		$d['id_seo'] = $id_seo;
		$d['post'] = $this->input->post();
		if(!empty($id_seo))
		{
			$d['gravados'] = $this->seo->exibeSeoPeloId($id_seo);
		}
		if ($this->form_validation->run() === false)
		{
			$this->load->view('admin_seo',$d);	
		}
		else{
			if($this->seo->verificaSeo(trim($this->input->post('nome_pagina'))))
			{
				if(isset($id_seo)){
					if($this->seo->atualizaSeo($id_seo, $d['post']))
					{
						$d['msg'] = 'Seo Atualizado com sucesso!';
					}
					else{
						$d['msg'] = 'Não foi possível atualizar';
					}
				}
			}
			else{
				if($this->seo->gravaSeo($d['post']))
				{
					$d['msg'] = 'Novo SEO Gravado com sucesso!';
				}
				else{
					$d['msg'] = 'Não foi possível gravar o novo SEO.';
				}
			}
			$this->load->view('admin_seo',$d);	
		}
		
	}
	public function excluirseo()
	{
		$id_seo = $this->uri->segment(3);
		$this->seo->excluirSeo($id_seo);
		redirect('admin_seo');

	}
}
	