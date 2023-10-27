<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once("database/conecta_bd.php");

ob_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'lib/vendor/autoload.php';

function buscarUsuario($email, $senha)
{
  $sql = "SELECT email, id_confirmaEmail FROM cadastro WHERE email = ?";
  $conexao = obterConexao();
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $resultado = $stmt->get_result();
  $usuario = mysqli_fetch_assoc($resultado);
  if ($usuario == null) {
    $msg = "Usuário incorreto!";
  } else {
    $senha_md5 = md5($senha);
    $sql = "SELECT * FROM Cadastro
              WHERE email = ? AND senha = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $email, $senha_md5);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = mysqli_fetch_assoc($resultado);
    if ($usuario == null) {
      $msg = "Senha incorreta!";
    } elseif ($usuario['id_confirmaEmail'] != 1) {
      $_SESSION["msg"] = "Seu email ainda não foi verificado, verifique sua caixa de entrada!";
      $_SESSION["tipo_msg"] = "alert-danger";
    } else {
      $msg = null;
    }
  }

  $stmt->close();
  $conexao->close();

  return [$usuario, $msg];
}


function listarPerfis()
{
  $lista_perfis = [];
  $sql = "SELECT * FROM TipoPerfil";

  $conexao = obterConexao();
  $resultado = mysqli_query($conexao, $sql);

  while ($perfil = mysqli_fetch_assoc($resultado)) {
    array_push($lista_perfis, $perfil);
  }

  mysqli_close($conexao);

  return $lista_perfis;
}

function inserirUsuario($nome, $email, $telefone, $dataFormatada, $senha, $chave, $id_confirmaEmail, $perfil)
{
  $sql = "SELECT email FROM Cadastro WHERE email = ?";
  $conexao = obterConexao();
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $resultado = $stmt->get_result();
  $usuario = mysqli_fetch_assoc($resultado);
  if ($usuario == null) {
    $_SESSION["senhaUser"] = $senha;
    $senha_md5 = md5($senha);
    $sql = "INSERT INTO Cadastro (nome, email, telefone, data_nasc, senha, chave, id_confirmaEmail, id_tipo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssssssii", $nome, $email, $telefone, $dataFormatada, $senha_md5, $chave, $id_confirmaEmail, $perfil);
    $stmt->execute();
    $_SESSION["msg"] = "Cadastro realizado com sucesso!";
    $_SESSION["tipo_msg"] = "alert-success";
    $_SESSION["usuario_logado"] = $email;
    $_SESSION["verificacao"] = $perfil;
  } else {
    $_SESSION["msg"] = "Usuário existente!";
    $_SESSION["tipo_msg"] = "alert-danger";
  }
  $stmt->close();
  $conexao->close();
}

function buscarNomeUser($email)
{
  $sql = "SELECT nome FROM cadastro WHERE email = ?";
  $conexao = obterConexao();
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $resultado = $stmt->get_result();
  $string = mysqli_fetch_assoc($resultado);
  $nome_usuario = $string["nome"];
  $_SESSION["nome_user"] = $nome_usuario;
  $stmt->close();
  $conexao->close();
  return $nome_usuario;
}

function buscarEmailUser($email)
{
  $sql = "SELECT email FROM cadastro WHERE email = ?";
  $conexao = obterConexao();
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $resultado = $stmt->get_result();
  $string = mysqli_fetch_assoc($resultado);
  $email_usuario = $string["email"];
  $stmt->close();
  $conexao->close();
  if ($email_usuario === null) {
    return false;
  }
  return $email_usuario;
}


function protectAdm()
{
  if (!isset($_SESSION['usuario_logado']) || ($_SESSION['verificacao'] != 1)) {
    unset($_SESSION["usuario_logado"]);
    $_SESSION["logado"] = 0;
    session_destroy();
    header("Location: ../protectAdm.php");
  }
}

function protectUser()
{
  if (!isset($_SESSION['usuario_logado']) || ($_SESSION['verificacao'] != 2)) {
    unset($_SESSION["usuario_logado"]);
    $_SESSION["logado"] = 0;
    session_destroy();
    header("Location: ../protectUser.php");
  }
}

function recuperacaoUsuario($email)
{
  $sql = "SELECT email FROM cadastro WHERE email = ?";
  $conexao = obterConexao();
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $resultado = $stmt->get_result();
  $usuario = mysqli_fetch_assoc($resultado);
  if ($usuario == null) {
    header("Location: esqueci_senha.php");
    $_SESSION["msg"] = "Usuário incorreto ou inexistente!";
    $_SESSION["tipo_msg"] = "alert-danger";
  } else {
    $sql = "SELECT nome FROM cadastro WHERE email = ?";
    $conexao = obterConexao();
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $string = mysqli_fetch_assoc($resultado);
    $nome = implode(", ", $string);
    $_SESSION["usuario_nome"] = $nome;
    enviarEmailrec($email, $nome);
    header("Location: login.php");
  }
  $stmt->close();
  $conexao->close();
  return $nome;
}

function enviarEmailrec($email, $nome)
{
  $nome = $_SESSION["usuario_nome"];
  $chave = password_hash($email . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
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
  $mail->Subject = 'Recuperação de Senha';
  $mail->AddEmbeddedImage('assets/logo.png', 'logo');
  $mail->Body = '<div style="text-align: center;"><img src="cid:logo" alt="Imagem com a logo do sistema ARQ CULTURA" style="width: 35%; margin: 0px auto; display: inline-block;"></div><br>';
  $mail->Body .= '<br><p style="font-size: 17px; text-align: center;">Olá <strong>' . $nome . '</strong>, recebemos uma solicitação para redefinir a senha da sua conta em nosso sistema.<br>
        Acesse o link abaixo para recuperá-la:<br><br></p><p style="font-size: 17px; text-align: center;"><button style="border: none; color: #fff;  text-align: center; font-size: 17px; font-weight: 100; letter-spacing: 1px; border-radius: 5px; background-color: #915c37; cursor: pointer; transition: all .3s ease;">
        <a href="http://localhost/tcc_cultura-ATUAL2/confirmarSenha.php?chave=' . $chave . '" style="text-decoration: none; color: inherit;">Recuperar</button></a><br><br></p>
        <p style="font-size: 12px; text-align: center;">Se você não requisitou essa ação no ARQ Cultura, por favor NÃO acesse o link.</p>
        <h5 style="color: #dbd5d5; font-size: 15px; text-align: center;"> Equipe ARQ Cultura</h5>';
  $mail->AltBody = "Olá" . $nome . ".\n\nRecebemos uma solicitação para redefinir sua senha da sua conta em nosso sistema.
        Acesse o link abaixo para recuperá-la:\n\nhttp://localhost/tcc_cultura-ATUAL2/confirmarSenha.php?chave=$chave\n\n";
  $mail->setFrom('adm.ofc.arq@gmail.com', 'ARQ Cultura');
  $mail->addAddress($email);
  try {
    if ($mail->send()) {
      $email = $_POST["email"];
      $_SESSION["usuario_logado"] = $email;
      $_SESSION["msg"] = "Link para recuperação de senha enviado no email!";
      $_SESSION["tipo_msg"] = "alert-success";
      header("Location: login.php");
      die();
    } else {
      echo 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo;
    }
  } catch (Exception $e) {
    echo 'Exceção capturada: ' . $e->getMessage();
  }
}

function perfilUsuario($email)
{
  $sql = "SELECT * FROM cadastro WHERE email = ?";
  $conexao = obterConexao();
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $resultado = $stmt->get_result();
  $perfil = mysqli_fetch_assoc($resultado);
  $stmt->close();
  $conexao->close();
  return [$perfil];
}

function inserirComentario($comentario, $email)
{
  $sql = "INSERT INTO Comentarios (comentario, data_publicacao, email) VALUES (?, NOW(), ?)";
  $conexao = obterConexao();
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("ss", $comentario, $email);
  if ($stmt->execute()) {
    $_SESSION["msg"] = "Comentário enviado com sucesso!";
    $_SESSION["tipo_msg"] = "alert-success";
    header("Location: pontosCulturais.php#areaComentarios");
    die();
  } else {
    $_SESSION["msg"] = "Erro ao enviar o comentário. Tente novamente!";
    $_SESSION["tipo_msg"] = "alert-danger";
    header("Location: pontosCulturais.php");
    die();
  }
  $stmt->close();
}

function alterarPerfil($nome, $telefone, $data, $email)
{
  $sql = "UPDATE Cadastro SET nome = ?, telefone = ?, data_nasc = ? WHERE email = ?";
  $dataFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $data)));
  $conexao = obterConexao();
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("ssss", $nome, $telefone, $dataFormatada, $email);
  $resultado = $stmt->execute();
  try {
    if ($stmt->affected_rows > 0) {
      $_SESSION["msg"] = "Seu perfil foi alterado com sucesso!";
      $_SESSION["tipo_msg"] = "alert-success";
    } else {
      $_SESSION["msg"] = "Erro ao alterar o perfil.";
      $_SESSION["tipo_msg"] = "alert-danger";
    }
  } catch (Exception $e) {
    $stmt->close();
    $conexao->close();
    $_SESSION["msg"] = "Erro ao alterar o perfil: " . $e->getMessage();
    $_SESSION["tipo_msg"] = "alert-danger";
  }
}

function atualizarPreferenciasUsuario($email, $categorias)
{
  $conexao = obterConexao();
  $sqlDelete = "DELETE FROM Preferencias WHERE email = ?";
  $stmtDelete = mysqli_prepare($conexao, $sqlDelete);
  mysqli_stmt_bind_param($stmtDelete, "s", $email);
  mysqli_stmt_execute($stmtDelete);
  mysqli_stmt_close($stmtDelete);
  $sqlInsert = "INSERT INTO Preferencias (email, categoria) VALUES (?, ?)";
  $stmtInsert = mysqli_prepare($conexao, $sqlInsert);
  mysqli_stmt_bind_param($stmtInsert, "si", $email, $categoria);

  foreach ($categorias as $categoria) {
    mysqli_stmt_execute($stmtInsert);
  }

  mysqli_stmt_close($stmtInsert);
  mysqli_close($conexao);
}

function inserirPonto($criador, $nome, $endereco, $descricao, $categoria) {
  $sql = "INSERT INTO PontosCulturais (criador, nome_ponto, endereco, descricao, categoria) VALUES (?, ?, ?, ?, ?)";
  $conexao = obterConexao();
  $stmt = $conexao->prepare($sql);
  if ($stmt) {
    $stmt->bind_param("ssssi", $criador, $nome, $endereco, $descricao, $categoria);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      $_SESSION["msg"] = "Ponto Cultural \"" . $nome . "\" inserido com sucesso!";
      $_SESSION["tipo_msg"] = "alert-success";
      return $conexao->insert_id;
      header("Location: mostrarPontos.php");
    } else {
      $_SESSION["msg"] = "Falha ao inserir o ponto.";
      $_SESSION["tipo_msg"] = "alert-danger";
      header("Location: pontosCulturais.php");
    }
    $stmt->close();
  } else {
    $_SESSION["msg"] = "Erro na preparação da consulta: " . $conexao->error;
    $_SESSION["tipo_msg"] = "alert-danger";
    header("Location: pontosCulturais.php");
  }
  return null;
}

function obterPontosCulturais()
{
  $sql = "SELECT id_ponto, nome_ponto FROM PontosCulturais";
  $conexao = obterConexao();
  $resultado = mysqli_query($conexao, $sql);
  $pontos = array();
  while ($row = mysqli_fetch_assoc($resultado)) {
    $pontos[] = $row;
  }
  mysqli_close($conexao);
  return $pontos;
}

function inserirEvento($criador, $nomeEvento, $pontoRef, $dataEventoFormatada, $horarioEvento, $categoria, $descricaoEvento)
{
  $sql = "INSERT INTO Eventos (criador, nome_evento, id_ponto, data_evento, horario, categoria, descricao_evento) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $conexao = obterConexao();
  $stmt = $conexao->prepare($sql);
  if ($stmt) {
    $stmt->bind_param("ssissis", $criador, $nomeEvento, $pontoRef, $dataEventoFormatada, $horarioEvento, $categoria, $descricaoEvento);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      $_SESSION["msg"] = "Evento cadastrado com sucesso!";
      $_SESSION["tipo_msg"] = "alert-success";
      header("Location: cadastroEvento.php");
      exit;
    } else {
      $_SESSION["msg"] = "Falha ao cadastrar o evento!";
      $_SESSION["tipo_msg"] = "alert-danger";
      header("Location: cadastroEvento.php");
      exit;
    }
    $stmt->close();
  } else {
    echo "Erro na preparação da consulta: " . $conexao->error;
  }
}

function obterEventos()
{
  $conexao = obterConexao();
  $sql = "SELECT e.nome_evento, e.data_evento, e.id_evento, e.horario, p.nome_ponto, c.nome_categoria, e.descricao_evento
  FROM Eventos e
  INNER JOIN PontosCulturais p ON e.id_ponto = p.id_ponto
  INNER JOIN Categoria c ON e.categoria = c.id_categoria
  WHERE e.aprovado = 1";
  
  $resultado = mysqli_query($conexao, $sql);

  if (!$resultado) {
    die("Erro na consulta: " . mysqli_error($conexao)); 
  }

  $eventos = array();

  if (mysqli_num_rows($resultado) > 0) {
    while ($evento = mysqli_fetch_assoc($resultado)) {
      $eventos[] = array(
        'nome_evento' => $evento['nome_evento'],
        'data_evento' => $evento['data_evento'],
        'id_evento' => $evento['id_evento'],
        'horario' => $evento['horario'],
        'nome_ponto' => $evento['nome_ponto'],
        'categoria' => $evento['nome_categoria'],
        'descricao_evento' => $evento['descricao_evento'],
      );
    }
  }

  mysqli_close($conexao);

  return $eventos;
}
function inserirComunidade($criador, $nome_com, $idade_min, $descricao_com)
{
  $sql = "INSERT INTO Comunidade (criador, nome_comunidade, idade_minima, descricao_comunidade) VALUES (?, ?, ?, ?)";
  $conexao = obterConexao();
  $stmt = $conexao->prepare($sql);
  if ($stmt) {
    $stmt->bind_param("ssss", $criador, $nome_com, $idade_min, $descricao_com);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      $_SESSION["msg"] = "Comunidade criada com sucesso!";
      $_SESSION["tipo_msg"] = "alert-success";
      header("Location: addComunidade.php");
      exit;
    } else {
      $_SESSION["msg"] = "Falha ao criar a comunidade!";
      $_SESSION["tipo_msg"] = "alert-danger";
      header("Location: addComunidade.php");
      exit;
    }
    $stmt->close();
  } else {
    echo "Erro na preparação da consulta: " . $conexao->error;
  }
}

function obterComunidades()
{
  $conexao = obterConexao();
  $sql = "SELECT nome_comunidade, idade_minima, descricao_comunidade FROM Comunidade WHERE aprovado = 1";
  $resultado = mysqli_query($conexao, $sql);
  if (!$resultado) {
    die("Erro na consulta: " . mysqli_error($conexao));
  }
  $comunidades = array();

  if (mysqli_num_rows($resultado) > 0) {
    while ($comunidade = mysqli_fetch_assoc($resultado)) {
      $comunidades[] = array(
        'nome_comunidade' => $comunidade['nome_comunidade'],
        'idade_minima' => $comunidade['idade_minima'],
        'descricao_comunidade' => $comunidade['descricao_comunidade'],
      );
    }
  }

  mysqli_close($conexao);

  return $comunidades;
}
?>