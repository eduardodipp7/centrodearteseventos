<?php

namespace Projeto;

use Rain\Tpl;

class Envia{

	const EMAIL = "xxxxxxxxxxxxxxx";
	const SENHA = "xxxxxxxxx";
	const NAME_FROM = "Centro de Artes e Eventos";

	private $mail;

	public function __construct($nome, $email, $mensagem){


        $body = "<table style='background: #ccc; width: 100%;' cellpadding='10' border='1' >";
        $body = $body ."<tr>";
        $body = $body ."<th>NOME</th>";
        $body = $body ."<th>E-MAIL</th>";
        $body = $body ."<th>MENSAGEM</th>";
        $body = $body ."</tr>";
        $body = $body ."<tr>";
        $body = $body ."<td>".$nome."</td>";
        $body = $body ."<td>".$email."</td>";
        $body = $body ."<td>".$mensagem."</td>";
        $body = $body ."</tr>";
        $body = $body ."</table>";

        // Inicia a classe PHPMailer
        $this->mail = new \PHPMailer();

        // Define os dados do servidor e tipo de conexão
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $this->mail->IsSMTP(); // Define que a mensagem será SMTP
        $this->mail->Host = "smtp.gmail.com"; // Endereço do servidor SMTP
        $this->mail->Port = '587';
        $this->mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
        $this->mail->Username = Envia::EMAIL; // Usuário do servidor SMTP
        $this->mail->Password = Envia::SENHA; // Senha do servidor SMTP

        // Define o remetente --- DE fulano
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $this->mail->From = $email; // Seu e-mail
        $this->mail->FromName = $nome; // Seu nome

        // Define os destinatário(s) -- Para fulona
       // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
       $this->mail->AddAddress(Envia::EMAIL, 'Eduardo Dipp');


      // Define os dados técnicos da Mensagem
      // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
      $this->mail->IsHTML(true); // Define que o e-mail será enviado como HTML
      $this->mail->CharSet = 'UTF-8'; // Charset da mensagem (opcional)

      // Define a mensagem (Texto e Assunto)
      // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
      $this->mail->Subject  = "Centro de Artes e Eventos"; // Assunto da mensagem
      $this->mail->Body = $body;
      $this->mail->AltBody = "Para visualizar a mensagem utilize um cliente de email compativel com HTML!";

      // Envia o e-mail
      $enviado = $this->mail->Send();

      // Limpa os destinatários e os anexos
      $this->mail->ClearAllRecipients();

      // Exibe uma mensagem de resultado
      if ($enviado) {

      $body = "<table align='center' style='font-size: 18px; color: #dd3d3f; background: #fff; width: 60%; text-align: center; padding: 30px; margin: 0 auto;' cellpadding='10' border='0' >";
      $body = $body ."<tr>";
      $body = $body ."<td>Olá <b>".$nome."</b>! 
                        Recebemos a sua mensagem, 
                        dentro do prazo de 60min em horário comercial retornaremos o contato.<br><br><br>
                        <img src='https://i.ibb.co/Lp3nHzB/logotipo-branco3.png' width='100' alt='logo' /><br><br>
                        Centro de Artes e Eventos <br>
                    

                        </td>";
      $body = $body ."</tr>";
      $body = $body ."</table>";

      // Define os dados do servidor e tipo de conexão
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $this->mail->IsSMTP(); // Define que a mensagem será SMTP
        $this->mail->Host = "smtp.gmail.com"; // Endereço do servidor SMTP
        $this->mail->Port = '587';
        $this->mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
        $this->mail->Username = Envia::EMAIL; // Usuário do servidor SMTP
        $this->mail->Password = Envia::SENHA; // Senha do servidor SMTP

        // Define o remetente
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $this->mail->From = Envia::EMAIL; // Seu e-mail
        $this->mail->FromName = Envia::NAME_FROM; // Seu nome


        // Define os destinatário(s)
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $this->mail->AddAddress($email, $nome);

        // Define os dados técnicos da Mensagem
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
       $this->mail->IsHTML(true); // Define que o e-mail será enviado como HTML
       $this->mail->CharSet = 'UTF-8'; // Charset da mensagem (opcional)

       // Define a mensagem (Texto e Assunto)
       // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
       $this->mail->Subject  = "Mensagem Automatica"; // Assunto da mensagem
       $this->mail->Body = $body;
       $this->mail->AltBody = "Para visualizar a mensagem utilize um cliente de email compativel com HTML!";

       // Envia o e-mail
       $this->mail->Send();

      // Limpa os destinatários e os anexos
      $this->mail->ClearAllRecipients();

}


} 

}//fim da classe envia
           
        /*Instância do objeto PHPMailer
		$this->mail = new \PHPMailer;
        // Configura para envio de e-mails usando SMTP
		$this->mail->isSMTP();

		$this->mail->SMTPDebug = 0;

		$this->mail->Debugoutput = 'html';
        // Servidor SMTP
		$this->mail->Host = 'smtp.gmail.com';
        // Porta do servidor SMTP
		$this->mail->Port = 587;
        // Tipo de encriptação que será usado na conexão SMTP
		$this->mail->SMTPSecure = 'tls';
        // Usar autenticação SMTP
		$this->mail->SMTPAuth = true;
        // Usuário da conta
		$this->mail->Username = Mailer::EMAIL;
        // Senha da conta
		$this->mail->Password = Mailer::SENHA;
        // Email do Remetente e o nome
		$this->mail->setFrom(Mailer::EMAIL, MAILER::NAME_FROM);
        // Endereço do e-mail do destinatário
		$this->mail->addAddress($toAddress, $toName);
        // Assunto do e-mail
		$this->mail->subject = $subject;
        // Informa se vamos enviar mensagens usando HTML
		$this->mail->msgHTML($html);
        // Mensagem que vai no corpo do e-mail
		$this->mail->AltBody = 'This is a plain-text message body'; */

	/*public function send(){

		return $this->mail->send();
	}*/


?>