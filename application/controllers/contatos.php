<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contatos extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('depoimento');
		$this->load->model('contato');
		$this->load->model('email');
		$this->load->model('seo');
	}
	public function index()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$this->load->view('contatos',$d);
		
	}
	public function form()
	{	
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$d['form'] = 1;
		$this->load->view('contatos',$d);
	}
	public function valida()
	{
		$d['admseo'] = $this->seo->admseo($this->uri->uri_string());
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('telefone', 'Telefone', 'required');
		$this->form_validation->set_rules('msg', 'Mensagem', 'required');

		if ($this->form_validation->run() === false)
		{
			$d['form'] = 1;
			$this->load->view('contatos',$d);			
		}
		else
		{
			
			$email 		= $this->input->post('email'); 
			$msg 		= $this->input->post('msg'); 
			$nome 		= $this->input->post('nome'); 
			$telefone 	= $this->input->post('telefone'); 
			$dados['nome'] 		= trim($nome);
			$dados['email'] 	= trim($email);
			$dados['telefone'] 	= trim($telefone);
			$dados['msg'] 		= trim($msg);
			$dados['data_alt'] 	= date('Y-m-d');
			$dados['hora_alt'] 		= date('H:i:s'); 
			$d['teste'] = $this->contato->mesmoEmailMsg($email,$msg);
			if($this->contato->mesmoEmailMsg($email,$msg))
			{
				$d['form'] 	= 1;
				$d['msg'] 	= 'Mensagem já gravada. Obrigado!';
				$this->load->view('contatos',$d);
			}
			else
			{
				$this->contato->gravaContato($dados);//gravou dados do contato
				if( $this->email->enviaEmail(
					$email_sender		= 'contato@dnrdecoracaorustica.com.br',
					$nome_remetente		= 'Noésia Francisca Araújo dos Santos',
					$email_destinatario = $dados['email'],
					$com_copia 			= '',
					$com_copia_oculta	= '',
					$assunto			= 'Contato no site DNR - Festas e Decoracao Rústica',
					$mensagem 			= 'Obrigado pelo seu contato.<hr> Entraremos em contato assim que possível. ',
					$nome 				= $nome
					)
				)
				{
					$d['msg_email'] 	= 'Obrigado pelo seu contato! <br> Uma email foi encaminhado para sua caixa de mensagem. Aguarde que em breve entraremos em contato.';
				}
				else{
					$d['msg_email'] 	= 'Desculpe!<br>Ocorreu um erro no envio e seu email foi enviado mas não se preocupe, guardamos sua mensagem mesmo assim e entraremos em contato assim que possível.';
				}
				$this->email->enviaEmail(
					$email_sender		= 'contato@dnrdecoracaorustica.com.br',
					$nome_remetente		= 'Noésia Francisca Araújo dos Santos',
					$email_destinatario = 'contato@dnrdecoracaorustica.com.br',
					$com_copia 			= 'anjosdoamor@gmail.com',
					$com_copia_oculta	= '',
					$assunto			= 'Contato de Usuário no Site',
					$mensagem 			= 'O usuário: '.$nome.',<br>Telefone: '.$telefone.'<br>Email: '.$email.', <br><br> lhes enviou a seguinte mensagem: <br><hr>'.$msg,
					$nome 				= 'Noésia'
				);

				$d['form'] 	= null;
				$d['msg'] 	= 'Sua mensagem foi enviada com sucesso!';
				$this->load->view('contatos',$d);
			}
		}
	}
}