<?php
require_once "../../models/config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pegar o id do usuário logado
    $usuario_id = $_SESSION['idUsuario'];

    // Captura as despesas
    if (isset($_POST['expenseCategory']) && isset($_POST['expenseValue'])) {
        foreach ($_POST['expenseCategory'] as $key => $category) {
            $value = $_POST['expenseValue'][$key];
            $stmt = $conn->prepare("INSERT INTO despesas(categoria, valor, usuario_id) VALUES (:categoria, :valor, :usuario)");
            $stmt->execute([':categoria' => $category, ':valor' => $value, ':usuario' => $usuario_id]);
        }
    }

    // Captura os investimentos
    if (isset($_POST['investmentType']) && isset($_POST['currentValue']) && 
        isset($_POST['annualReturn']) && isset($_POST['riskLevel'])) {
        foreach ($_POST['investmentType'] as $key => $tipo_investimento) {
            $valor_atual = $_POST['currentValue'][$key];
            $retorno_anual = $_POST['annualReturn'][$key];
            $nivel_risco = $_POST['riskLevel'][$key];

            $stmt = $conn->prepare("INSERT INTO investimentos(tipo_investimento, valor_atual, retorno_anual, nivel_de_risco, usuario_id) VALUES(:tipo_investimento, :valor_atual, :retorno_anual, :nivel_de_risco, :usuario)");
            $stmt->execute([
                ':tipo_investimento' => $tipo_investimento,
                ':valor_atual' => $valor_atual,
                ':retorno_anual' => $retorno_anual,
                ':nivel_de_risco' => $nivel_risco,
                ':usuario' => $usuario_id
            ]);
        }
    }

    // Captura as metas
    if (isset($_POST['monthlyExpense']) && isset($_POST['desiredInflationRate']) && 
        isset($_POST['necessaryFund']) && isset($_POST['creationDate']) && isset($_POST['updateDate'])) {
        foreach ($_POST['monthlyExpense'] as $key => $monthlyExpense) {
            $desiredInflationRate = $_POST['desiredInflationRate'][$key];
            $necessaryFund = $_POST['necessaryFund'][$key];
            $creationDate = $_POST['creationDate'][$key];
            $updateDate = $_POST['updateDate'][$key];

            $stmt = $conn->prepare("INSERT INTO meta_aposent(Despesa_Mensal, Taxa_Inflacao_Desejada, Fundo_Necessario, Data_Criacao, Data_Atualizacao, 	Usuario_idUsuario) VALUES (:monthlyExpense, :desiredInflationRate, :necessaryFund, :creationDate, :updateDate, :usuario)");
            $stmt->execute([
                ':monthlyExpense' => $monthlyExpense,
                ':desiredInflationRate' => $desiredInflationRate,
                ':necessaryFund' => $necessaryFund,
                ':creationDate' => $creationDate,
                ':updateDate' => $updateDate,
                ':usuario' => $usuario_id
            ]);
        }
    }

    echo '<h1>Planejamento de Aposentadoria Salvo com Sucesso!</h1>';
}
?>
