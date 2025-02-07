<?php
include "../../models/config.php";
session_start();

if (!isset($_SESSION["idUsuario"])) {
    header("location: ../login/login.php");
    exit;
}

// Obter o ID do usuário
$usuarioId = $_SESSION['idUsuario'];

//Obter Rendado Usuário
$sql_renda = $conn->prepare("SELECT renda_Atual FROM usuario WHERE idUsuario = :usuarioId");
$sql_renda->bindValue(":usuarioId", $usuarioId);
$sql_renda->execute();
$totalRenda = $sql_renda->fetchColumn() ?: 0;


// Recuperar investimentos
$sql_investimentos = $conn->prepare("SELECT SUM(valor_atual) AS total_investimentos FROM investimentos WHERE usuario_id = :usuarioId");
$sql_investimentos->bindValue(":usuarioId", $usuarioId);
$sql_investimentos->execute();
$totalInvestimentos = $sql_investimentos->fetchColumn() ?: 0; // Se não houver investimentos, retorna 0

// Recuperar despesas
$sql_despesas = $conn->prepare("SELECT SUM(valor) AS total_despesas FROM despesas WHERE usuario_id = :usuarioId");
$sql_despesas->bindValue(":usuarioId", $usuarioId);
$sql_despesas->execute();
$totalDespesas = $sql_despesas->fetchColumn() ?: 0; // Se não houver despesas, retorna 0

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- link para estilo e icone -->
    <link rel="stylesheet" href="assets/css/dashboards.css">
    <link rel="stylesheet" href="views/assets/css/index.css">
    <link rel="stylesheet" href="assets/icone/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="views/assets/css/chatss.css">
    <style>
                .modal {
            display: none; /* Escondido por padrão */
            position: fixed; /* Fixo na tela */
            z-index: 1; /* Acima de outros elementos */
            left: 0;
            top: 0;
            width: 100%; /* Largura total */
            height: 100%; /* Altura total */
            overflow: auto; /* Scroll se necessário */
            background-color: rgba(0,0,0,0.5); /* Fundo escuro */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* Centralizado */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Largura da modal */
        }

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

    </style>
    <title>Dashboard - AposenNest</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="./AposenBot.js" defer></script>
</head>
<body>
<div class="chat-container">
        <div class="chat-top-container">
            <img src="assets/imagem/face15.jpg" alt="">
            <span>AposenNest Bot</span>
            <i class="bu bi-chevron-double-down" style="cursor:pointer"></i>
        </div>
        <div class="chat-interation-container">
            
        </div>
        <div class="chat-input-container">
            <textarea name="" id="userInput" cols="20" rows="20" placeholder="Sua mensagem!"></textarea>
            <button style="color:black" class="bu bi-send" id="button"></button>
        </div>
</div>
    <div class="container">

        <div class="container-top">

            <div class="logo">
                <h4>AposenNest</h4>
            </div>

            <div class="form">

                <i class="bu bi-text-right"></i>

                <form action="POST">

                    <input type="search" placeholder="Search Products">

                </form>
            </div>

            <div class="icon">

                <a href="#">+ Simulador</a>

                <div class="list-icon">
                    
                    <div>
                        <i class="bu bi-chat-fill" id="chatCaller"></i>
                    </div>
                  
                    <div>
                        <i class="bu bi-bell-fill"></i>
                        <span>2</span>
                    </div>
                </div>

            </div>

            <div class="user-detail">

                <div class="user">

                    <p style="text-transform: uppercase;">
                        <?php
                            
                           echo  $_SESSION['nome'];

                        ?>

                    </p>

                </div>

            </div>

        </div>

        <div class="container-body">

            <div class="container-asside">

                <div class="asside-top">

                </div>

                <div class="asside-navegation">

                  <ul>

                    <li>
                        <a href="dashboard.php?menu=index">
                            <i class="fa-brands fa-uncharted"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="dashboard.php?menu=meta">
                            <i class="bu bi-check2-square scale"></i>
                            <span>Meta Aposentadoria</span>
                        </a>
                    </li>

                    <li>
                        <a href="dashboard.php?menu=despesa">
                            <i class="bu bi-clipboard-data scale"></i>
                            <span>Despesas</span>
                        </a>
                    </li>

                    <li>
                        <a href="dashboard.php?menu=investimento">
                            <i class="bu bi-stack scale"></i>
                            <span>Investimento</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" id="reportLink">
                            <i class="bu bi-file-pdf scale"></i>
                            <span>Relatório</span>
                        </a>
                    </li>
                    <li>
                    <a href="../../Classes/php/sessao.php" class="sessao">
                        <i class="bu bi-box-arrow-right scale "></i>
                        <span>Terminar Sessão</span>
                    </a>
                    </li>

                  </ul>

                </div>

            </div>

            <div class="container-main">

              <?php

                    $menu = (isset($_GET["menu"]))?$_GET["menu"]:"index";

                    switch ($menu) {
                        case 'index':
                            include "views/index.php";
                            break;

                        case 'meta':
                            include "views/meta.php";
                            break;

                        case 'investimento':
                            include "views/investimento.php";
                            break;

                        case 'despesa':
                            include "views/despesa.php";
                            break;
                        
                        default:
                            include "views/index.php";
                            break;
                    }

              ?>

            </div>

        </div>

    </div>

    <!-- Modal para Relatórios -->
<div id="reportModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Relatórios Mensais</h2>
        <ul>
            <li><a href="gerar_relatorio.php?mes=janeiro">Janeiro</a></li>
            <li><a href="gerar_relatorio.php?mes=fevereiro">Fevereiro</a></li>
            <li><a href="gerar_relatorio.php?mes=marco">Março</a></li>
            <li><a href="gerar_relatorio.php?mes=abril">Abril</a></li>
            <li><a href="gerar_relatorio.php?mes=maio">Maio</a></li>
            <li><a href="gerar_relatorio.php?mes=junho">Junho</a></li>
            <li><a href="gerar_relatorio.php?mes=julho">Julho</a></li>
            <li><a href="gerar_relatorio.php?mes=agosto">Agosto</a></li>
            <li><a href="gerar_relatorio.php?mes=setembro">Setembro</a></li>
            <li><a href="gerar_relatorio.php?mes=outubro">Outubro</a></li>
            <li><a href="gerar_relatorio.php?mes=novembro">Novembro</a></li>
            <li><a href="gerar_relatorio.php?mes=dezembro">Dezembro</a></li>
        </ul>
    </div>
</div>


    <script src="./dashboard.js" async>
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['', 'Investimento', 'Renda', 'Despesa'],
          ['2022', 1000, 400, 200],
          ['2023', 399, 460, 250],
          ['2024', 2000, 1120, 300],
          ['2025', 12, 540, 350]
        ]);

        var options = {
          chart: {
            title: 'Análise de despesas',
            subtitle: 'Gastos e entre outros'
          },
          colors: ['#1f6852', '#1f6400', '#1f6567']
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Language', 'Speakers (in millions)'],
          ['Assamese', 13], ['Bengali', 83], ['Bodo', 1.4],
          ['Dogri', 2.3], ['Gujarati', 46], ['Hindi', 300]
        ]);

        var options = {
          title: '',
          legend: 'none',
          pieSliceText: 'label',
          slices: {  4: {offset: 0.2},
                    12: {offset: 0.3},
                    14: {offset: 0.4},
                    15: {offset: 0.5},
          },
          colors:['#1f6567', '#1f6400', '#1f6852']
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>
</body>
</html>