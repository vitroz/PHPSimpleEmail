<?php
require 'PHPMailer/PHPMailerAutoload.php';

if(isset($_POST) && !empty($_POST)){
	if(!empty($_FILES['attachment']['name'])){

		$file_name = $_FILES['attachment']['name'];
		$temp_name = $_FILES['attachment']['tmp_name'];
		$file_type = $_FILES['attachment']['type'];

		$base = basename($file_name);
		$extension = substr($base, strlen($base)-4, strlen($base));

		$allowed_extensions = array('.doc','docx','.pdf'); //Extensoes permitidas no anexo

		if(in_array($extension, $allowed_extensions)) {

			$mail = new PHPMailer;

			$mail->isSMTP();                                   // Setando protocolo STMP
			$mail->Host = 'smtp.gmail.com';                    // Servidor SMTP
			$mail->SMTPAuth = true;                            // Autenticacao SMTP TRUE
			$mail->Username = 'saimpluss@gmail.com';           // Email de origem 
			$mail->Password = 'daniel321'; // Senha do Email de Origen
			$mail->SMTPSecure = 'tls';                         // Encriptacao TlS, `ssl` tambem permitido
			$mail->Port = 587;                                 // Porta TCP utilizada (SMTP)

			$mail->setFrom('meninotrevoso@gmail.com', 'Site - Contato');
			$mail->addReplyTo('meninotrevoso@gmail.com', 'Site - Contato');
			$mail->addAddress('vitorvqz@gmail.com'); // Email que recebera as mensagens

			$mail->isHTML(true);  // Conteudo formatado em HTML

			$bodyContent = '<h1>Email - Localhost</h1>';
			$bodyContent .= '<p>This is the HTML email sent from localhost using PHP </p>';

			$file = $temp_name;

			$content = chunk_split(base64_encode(file_get_contents($file)));
			$uid = md5(uniqid(time()));

 			$mail->AddAttachment($file,
                         		 $file_name);

			$mail->Subject = 'Teste';
			$mail->Body    = $bodyContent;

			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			    echo 'Message has been sent';
			}


		} else{ // Verificacao de Extensao do Anexo
			echo 'file type not allowed';
		}

	}else{  // Verificacao se houve anexo selecionado.
		echo "no file posted";
	}

}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>		
		<title>PHP Simple Email</title>
	</head>
		<body>
			<div class="container">
				<form method="post" action="index.php" enctype="multipart/form-data">
					<input type="file" name="attachment"/><br>
					<input class="btn btn-success" type="submit" value="Enviar"/>
				</form>				
			</div>
		</body>
</html>