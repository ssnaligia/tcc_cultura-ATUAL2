<?php
require("sistema_bd.php");

ob_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'lib/vendor/autoload.php';

$nome = $_POST["nome"];
$email = $_POST["email"];
$chave = password_hash($email . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);

$buscaUsuario = buscarEmailUser($email);

if($buscaUsuario == false) {

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'adm.ofc.arq@gmail.com';
    $mail->Password = 'yqwwlvjpcewbtrrg';
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->isHTML(true);
    $mail->ContentType = 'text/html';
    $mail->Subject = 'Confirme seu endereço de e-mail';
    $mail->AddEmbeddedImage('assets/confirmarEmail.png', 'logo_welcome');
    $mail->Body = '<div style="text-align: center;"><img src="cid:logo_welcome" alt="Imagem com a logo do sistema ARQ CULTURA e mensagem de boas vindas." style="width: 900px; height: auto; display: inline-block;"></div><br>';        
    $mail->Body .= '<p style="font-size: 17px; text-align: center;">Olá <strong>' . $nome . '</strong>, agradecemos pelo cadastro em nosso sistema!<br>Para manter sua conta protegida, precisamos que você verifique seu endereço de e-mail.<br><br></p><p style="font-size: 17px; text-align: center;">
    Basta clicar no link abaixo:<br><br><a href="http://localhost/tcc_cultura-ATUAL2/confirmarEmail.php?chave=' . $chave . '" style="text-decoration: none;"><button style="border: none; color: #fff; font-size: 17px; font-weight: 100; letter-spacing: 1px; border-radius: 5px; background-color: #915c37; cursor: pointer; transition: all .3s ease;">Confirmar</button></a><br><br></p>
    <p style="font-size: 12px; text-align: center;">Se você não realizou o cadastro no ARQ Cultura, por favor ignore esta mensagem.</p>
    <h5 style="color: #dbd5d5; font-size: 15px; text-align: center;"> Equipe ARQ Cultura</h5>';
    $mail->AltBody = "Olá" . $nome . ".\n\nAgradecemos pelo cadastro em nosso sistema!\n\nPara manter sua conta 
    sempre protegida, precisamos que você verifique seu endereço de e-mail.\n\nBasta clicar no link abaixo:\n\n
    http://localhost/tcc_cultura-ATUAL2/confirmarEmail.php?chave=$chave\n\n"; 

    $mail->setFrom('adm.ofc.arq@gmail.com', 'ARQ Cultura');
    $mail->addAddress($email, $nome);
    
    try {
        if ($mail->send()) {
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $telefone = $_POST["telefone"];
            $data = $_POST["data_nasc"];
            function formatarDataParaBanco($data) {
                $dataFormatada = DateTime::createFromFormat('d/m/Y', $data);
                return $dataFormatada ? $dataFormatada->format('Y-m-d') : null;
            }            
            $dataFormatada = formatarDataParaBanco($data);
            $senha = $_POST["senha"];
            $chave = password_hash($email . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
            $id_confirmaEmail = 3;
            $perfil = $_POST["id_tipo"];
            inserirUsuario($nome, $email, $telefone, $dataFormatada, $senha, $chave, $id_confirmaEmail, $perfil);
            $confirmar = $_POST["confirmar"];
            $_SESSION["usuario_logado"] = $email;
            $_SESSION["msg"] = "Cadastro realizado com sucesso!</br>Necessário checar sua caixa de entrada para confirmar seu email.";
            $_SESSION["tipo_msg"] = "alert-success";
            header("Location: login.php");
            die();    
        } else {
            echo 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'Exceção capturada: ' . $e->getMessage();
    }
} else {
    header("Refresh: 0; url=cadastro.php");
    $_SESSION["msg"] = "Usuário existente!";
    $_SESSION["tipo_msg"] = "alert-danger";
    exit;
}
?>