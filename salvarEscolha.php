<?php
require("sistema_bd.php");
if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Receba os dados do formulário
    $escolha = $_POST['eventoSelect'];
    $email = $_SESSION['usuario_logado'];

    $conexao = obterConexao();
    
    // Obtenha o id_evento apropriado (dependendo de como você o está obtendo)
    $id_evento = $_SESSION['id_evento'];

    // Inserir a escolha do usuário na tabela EscolhasUsuario
    $sql = "INSERT INTO EscolhasUsuario (email, id_evento, escolha) VALUES (?, ?, ?)";
    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sis", $email, $id_evento, $escolha);
        if ($stmt->execute() && $escolha === "vou") {
            // Consultar a escolha de notificação do usuário
            $sqlNotificacoes = "SELECT notificacao FROM Notificacoes WHERE email = ?";
            $stmtNotificacoes = $conexao->prepare($sqlNotificacoes);

            if ($stmtNotificacoes) {
                $stmtNotificacoes->bind_param("s", $email);
                $stmtNotificacoes->execute();
                $resultNotificacoes = $stmtNotificacoes->get_result();

                while ($rowNotificacoes = $resultNotificacoes->fetch_assoc()) {
                    // Processar os resultados das notificações
                    $notificacao = $rowNotificacoes['notificacao'];

                    $sqlEvento = "SELECT data_evento FROM Eventos WHERE id_evento = ?";
                    $stmtEvento = $conexao->prepare($sqlEvento);
                    $stmtEvento->bind_param("i", $id_evento);
                    $stmtEvento->execute();
                    $resultEvento = $stmtEvento->get_result();
                    if ($resultEvento->num_rows > 0) {
                        $rowEvento = $resultEvento->fetch_assoc();
                        $data_evento = $rowEvento['data_evento'];
                        if ($notificacao === 'Semana') {
                            $data_limite = date('Y-m-d', strtotime('-7 days', strtotime($data_evento)));
                        } elseif ($notificacao === 'DiaAnterior') {
                            $data_limite = date('Y-m-d', strtotime('-1 day', strtotime($data_evento)));
                        } elseif ($notificacao === 'MesmoDia') {
                            $data_limite = $data_evento;
                            
                        }
                    } else {
                        // Lidar com o caso em que a consulta não retornou nenhum resultado
                        echo "Nenhum evento encontrado com o ID especificado.";
                    }
                    var_dump($data_limite);
                    die();

                    // Outras ações com base nos resultados
                }
            } else {
                // Lidar com o erro na preparação da consulta de notificações
                header("Location: eventos.php");
            }
            
            $stmtEvento->close();
        } else {
            // Lidar com o erro na execução da consulta de inserção de escolhas
            header("Location: eventos.php");
        }
        
        $stmtNotificacoes->close();
        $stmt->close();
    } else {
        // Lidar com o erro na preparação da consulta de inserção de escolhas
        echo "Erro na preparação da consulta de inserção de escolhas: " . $conexao->error;
    }

    // Redirecionar o usuário após a conclusão
    header("Location: eventos.php");
}
?>
