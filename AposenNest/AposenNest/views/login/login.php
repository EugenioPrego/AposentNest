 <?php

require_once "../../models/config.php";


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Login</title>
    <style>
        /* Estilo do modal */
        .modal {
            display: none; /* Oculta o modal por padrão */
            position: fixed;
            z-index: 1; /* Fica acima do conteúdo da página */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4); /* Cor de fundo com opacidade */
        }

        /* Conteúdo do modal */
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto; /* Ajusta a margem superior para centralizar melhor */
            padding: 20px;
            border: 1px solid #888;
            width: 90%; /* Ajusta a largura para um layout mais flexível */
            max-width: 650px; /* Aumenta o máximo para acomodar o formulário maior */
            border-radius: 8px; /* Adiciona bordas arredondadas para um visual mais moderno */
            box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* Adiciona sombra ao modal para destacá-lo */
        }

        /* Botão de fechar */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Estilo do formulário no modal */
        #register-form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        #register-form input,
        #register-form textarea,
        #register-form select {
            display: block;
            width: calc(100% - 20px); /* Ajusta a largura para considerar o padding */
            margin: 0 0 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px; /* Adiciona bordas arredondadas aos campos */
        }

        #register-form textarea {
            resize: vertical; /* Permite redimensionar o textarea verticalmente */
            height: 80px; /* Define uma altura padrão para textareas */
        }

        #register-form input[type="submit"] {
            background-color: #4CAF50; /* Cor de fundo verde */
            color: white; /* Cor do texto branca */
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 15px;
            border-radius: 4px;
        }

        #register-form input[type="submit"]:hover {
            background-color: #45a049; /* Cor de fundo verde escuro ao passar o mouse */
        }
    </style>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Verifica se existe uma mensagem de erro no PHP
        const errorMessage = "<?php echo isset($_SESSION['error']) ? addslashes($_SESSION['error']) : ''; ?>";

        if (errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMessage,
            });
            // Limpa a sessão
            <?php unset($_SESSION['error']); ?>
        }
    });
</script>

<body>
    <section class="container">
        <div class="login">
            <div class="left">
                <img src="../assets/img/finance2.png" alt="login_finance">
            </div>
            <div class="right">
                <div class="conteudo">
                    <h3>AposenNeSt</h3>
                    <form id="login-form" method="POST" action="../../Classes/php/usuario_login.php">
                        
                        <input type="email" name="email" id="login-email" placeholder="Email ou telefone">
                        <input type="password" name="senha" id="login-senha" placeholder="Senha">
                        <input type="submit" value="Entrar">

                    </form>
                    <div class="link">
                        <a href="#" id="create-account">Criar Conta</a>
                        <a href="#">Esqueceu a senha?</a>
                    </div>
                    <hr>
                    <a href="../index.php">Página Principal</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" id="close-modal">&times;</span>
            <h2>Criar Conta</h2>
            <br>
            <form id="register-form" method="POST" action="../../Classes/php/usuario_cadastro.php">
                
                <label for="nome">Nome Completo:</label>
                <input type="text" name="nome" id="nome" placeholder="Digite seu nome Completo">

                <label for="nascimento">Data de Nascimento:</label>
                <input type="date" name="nascimento" id="nascimento" >

                <label for="bilhete">Bilhete:</label>
                <input type="text" name="bilhete" id="bilhete" placeholder="Digite o seu bilhete">
                
                <label for="renda_atual">Renda:</label>
                <input type="number" name="renda_atual" id="renda_atual" placeholder="renda_atual">

                <label for="data_aposent">Data de Aposentadoria:</label>
                <input type="date" name="nascimento_aposent" id="nascimento_aposent" >

                <select name="plano_aposent" id="plano_aposent">
                 
                <?php
                    
                    $sql_aposent=$conn->prepare("SELECT 	idPlano_Aposent, Tipo_Planos, Valor_Plano FROM plano_aposent");
                    $sql_aposent->execute();

                    if ($sql_aposent){
                        
                        $planos=$sql_aposent->fetchall();

                    } else {
                        
                        echo "Ainda não tem Planos Cadastrado na Base de dados";

                    }

                    foreach ($planos as $plano) {

                        ?>

                        <option value="<?php echo $plano["idPlano_Aposent"] ?>">

                                <?php 
                                   echo  $plano["Tipo_Planos"]. " | "  .$plano["Valor_Plano"] ."KZ";
                                ?>

                        </option>

                        <?Php
                    
                    }
                    

                ?>
                </select>

                <label for="telefone">Telefone:</label>
                <input type="tel" name="telefone" id="register-telefone" placeholder="Digite seu Telefone" maxlength="9">

                <label for="email">Email:</label>
                <input type="email" name="email" id="register-email" placeholder="Digite o seu Email">

                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="register-senha" placeholder="Digite a sua Senha">

                <label for="conf_senha">Confirmar Senha:</label>
                <input type="password" name="conf_senha" id="conf_senha" placeholder="Confirmar Senha">

                <input type="submit" value="Criar Conta">
            </form>
        </div>
    </div>

    <script>
        // Obtém o modal e os botões
        var modal = document.getElementById("modal");
        var btn = document.getElementById("create-account");
        var span = document.getElementById("close-modal");

        // Quando o usuário clicar no link "Criar Conta", abre o modal
        btn.onclick = function(event) {
            event.preventDefault(); // Evita o comportamento padrão do link
            modal.style.display = "block";
        }

        // Quando o usuário clicar no botão de fechar, fecha o modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Quando o usuário clicar fora do modal, fecha-o
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Adiciona um evento de teclado para fechar o modal com a tecla ESC
        document.onkeydown = function(event) {
            if (event.key === "Escape" || event.key === "Esc") {
                modal.style.display = "none";
            }
        }


    </script>


</body>
</html>
