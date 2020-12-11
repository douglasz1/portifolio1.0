<?php 

$file=fopen("../.env","r");
$text=fread($file,filesize("../.env"));
$lines=explode(PHP_EOL,$text);
$PONTO_ENV = [];
foreach($lines as $line)
  {
	$E = explode('=', $line);
	$PONTO_ENV[$E[0]] = $E[1];
}

$nome = $_POST['nome'];
//$sobrenome = $_POST['sobrenome'];
$email = $_POST['email'];
$mensagem = $_POST['mensagem'];

require(('PHPMailer/PHPMailerAutoload.php'));

$mail = new PHPMailer;
$mail->isSMTP();

//configurações do servidor de E-mail

$mail->Host = "smtp.gmail.com";
$mail->Port = "465";
$mail->SMTPSecure = "ssl";
$mail->SMTPAuth = "true";
$mail->Username = $PONTO_ENV['MAIL'];
$mail->Password = $PONTO_ENV['SENHA'];

//Configuração da Mensagem
$mail->setFrom($mail->Username, "$nome"); // Remetente
$mail->addAddress($PONTO_ENV['MAIL']); // Destinatário
$mail->Subject = "Portifolio | Mail"; //Assunto do e-mail

$conteudo_email = "

Você está recebendo uma menssagem de $nome ($email):
<br><br>

Mensagem:<br>
$mensagem
";

$mail->IsHTML(true);
$mail->Body = $conteudo_email;

if ($mail->Send()) {

	header("Location: https://douglaszqq.herokuapp.com/"); 
exit();

} else {
	echo "Falha ao enviar o e-mail: " . $mail->ErrorInfo;
}
