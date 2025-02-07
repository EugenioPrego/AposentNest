<?php
include "../../models/config.php";
session_start(); // Inicie a sessão

if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);

    if (!empty($email) && !empty($senha)) {
        // Usar password_hash() para criar o hash da senha ao cadastrar
        $senhaHash = md5($senha); // Mantenha o hash atual por enquanto, mas atualize para password_hash() futuramente

        $sql_verify = $conn->prepare("SELECT u.idUsuario, u.nome 
                                       FROM usuario u
                                       JOIN login l ON u.idUsuario = l.Usuario_idUsuario
                                       JOIN contato c ON l.Contato_idContato = c.idContato
                                       WHERE c.email = :email AND l.password = :senha");
        
        $sql_verify->bindValue(":email", $email);
        $sql_verify->bindValue(":senha", $senhaHash);
        $sql_verify->execute();

        if ($sql_verify->rowCount() > 0) {
            $dados = $sql_verify->fetch();

            $_SESSION['idUsuario'] = $dados['idUsuario'];
            $_SESSION['nome'] = $dados['nome']; // Armazena o nome do usuário na sessão

            // Verificar se o usuário tem despesas e investimentos cadastrados
            $usuarioId = $_SESSION['idUsuario'];

            // Verifica despesas
            $sql_despesas = $conn->prepare("SELECT COUNT(*) FROM despesas WHERE usuario_id = :usuarioId");
            $sql_despesas->bindValue(":usuarioId", $usuarioId);
            $sql_despesas->execute();
            $despesasCount = $sql_despesas->fetchColumn();

            // Verifica investimentos
            $sql_investimentos = $conn->prepare("SELECT COUNT(*) FROM investimentos WHERE usuario_id = :usuarioId");
            $sql_investimentos->bindValue(":usuarioId", $usuarioId);
            $sql_investimentos->execute();
            $investimentosCount = $sql_investimentos->fetchColumn();

            // Lógica de redirecionamento
            if ($despesasCount > 0 && $investimentosCount > 0) {
                // Usuário pode acessar a dashboard
                header("location: ../../views/dashboard/dashboard.php");
            } else {
                // Usuário não tem despesas ou investimentos, redireciona para a área de cadastramento financeiro
                header("location: ../../views/dashboard/financeiro/financeiro.php");
            }
            exit; // Adicione exit após o redirecionamento
            
        } else {
            echo "Usuário não encontrado na base de dados.";
            header("location: ../../views/login/login.php");
            exit;
        }
    } else {
        echo "Preencha todos os campos!";
        header("location: ../../views/login/login.php");
        exit;
    }
}
?>
