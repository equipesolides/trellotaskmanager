<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_control extends CI_Controller {

	public function index()
	{
		$this->load->view('master/page_header');
		$this->load->view('pages/form_registra_task');
		$this->load->view('master/page_footer');
	}


	public function envia_requisicao()
    {
    	$post = $this->input->post();
    	$label_setor = label_setor_request( $post['setor'] );
		$label_tcategoria = label_type_request( $post['categoria'] );
		$due = date( 'Y-m-d', strtotime( str_replace( '/', '-', $post['prazo'] ) ) );

    	$dataPost = array(
			'name' => $post['titulo'],
			'desc' => htmlToPlainText( $post['descricao'] . PHP_EOL . nl2br( PHP_EOL ) . "***Enviado por " . $post['solicitante'] ."***"),
            'pos' => "top",
			'idList' => "5bb4ce5f6d9aa13a7fd9116c",
			'idLabels' => $label_setor . "," . $label_tcategoria,
			'due' => $due
		);
    	$cria_card = request_trelo( "POST", "cards", $dataPost );
    	if( $cria_card ){
            /*$msg_email = "Olá, <strong>" . $post['solicitante'] . "</strong>. <br /><br />
                Recebemos sua solicitação e logo em breve esta será tratada! <br /><br />
                Dados da solicitação: <br /><br />
                <table border='1' width='100%' align='center' autosize='0' cellspacing='0' cellpadding='2' style='border-collapse:collapse; border: 1px solid #000; font-size:12px; text-align:center;'>
                    <thead>
                        <tr>
                            <th style='text-align:center;'>Solicitante/Setor</th>
                            <th style='text-align:center;'>Categoria da Solicitação</th>
                            <th style='text-align:center;'>Prazo Solicitado para Conclusão</th>
                            <th style='text-align:center;'>Título</th>
                            <th style='text-align:center;'>Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>" . $post['solicitante'] . "/" . $post['setor'] ."</td>
                            <td>" . $post['categoria'] . "</td>
                            <td>" . $post['prazo'] . "</td>
                            <td>" . $post['titulo'] . "</td>
                            <td style='word-break:break-all;'>" . $post['descricao'] . "</td>
                        </tr>
                    </tbody>
                </table>
                <br /><br />
                Att, <br />
                Equipe de T.I - Solides
                <br /><br />";
            enviar_email(
                array(
                    'email' => array( $post['email'] ),
                    'assunto' => 'Sua solicitação foi enviada com sucesso!',
                    'mensagem' => $msg_email
                )
            );*/
    		echo json_encode(array('success' => true, 'title'=> 'Enviado!', 'msg' => 'Solicitação enviada com sucesso!'));
    	}else{
    		echo json_encode(array('success' => false, 'title'=> 'Erro!', 'msg' => 'Não foi possivel enviar a solicitação. Informe a equipe de tecnologia sobre o ocorrido.'));
    	}

    }
}