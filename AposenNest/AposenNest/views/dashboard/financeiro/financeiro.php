<?php

session_start();

if (!isset($_SESSION["idUsuario"])) {
    header("Location: ../login/login.php");
    exit;
}
    
    // Processar o envio do formulário
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validar e salvar os dados financeiros no banco de dados
        $usuarioId = $_SESSION['idUsuario'];
        $renda = $_POST['renda'];
        $despesas = $_POST['despesas'];
        $investimentos = $_POST['investimentos'];
    
        // Inserir dados no banco
        $query = "INSERT INTO dados_financeiros (usuario_id, renda, despesas, investimentos) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$usuarioId, $renda, $despesas, $investimentos]);
    
        // Redirecionar para o dashboard após salvar os dados
        header("Location: dashboard/dashboard.php");
        exit;
    }
 ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Planejamento de Aposentadoria</title>
</head>
<body>
    <form action="../../../Classes/php/cadastro_financeiro.php" method="POST">
        <div class="container">
            <h1>Planejamento de Aposentadoria</h1>
            <button class="finalizar-button" type="button" onclick="finalizar()">Finalizar</button>
            <div class="tabs">
                <button type="button" onclick="showSection('expenses')">Despesas</button>
                <button type="button" onclick="showSection('investments')">Investimentos</button>
                <button type="button" onclick="showSection('goals')">Metas de Aposentadoria</button>
            </div>
    
            <div class="form-section" id="expensesSection" style="display: none;">
                <h2>Despesas</h2>
                <div class="input-group" id="expensesInputs">
                    <select name="expenseCategory[]" required>
                        <option value="" disabled selected>Selecione a categoria</option>
                        <option value="alimentacao">Alimentação</option>
                        <option value="transporte">Transporte</option>
                        <option value="moradia">Moradia</option>
                        <option value="saude">Saúde</option>
                        <option value="lazer">Lazer</option>
                    </select>
                    <input type="number" name="expenseValue[]" placeholder="Valor" required>
                </div>
                <button type="button" onclick="addExpense()">Adicionar Despesa</button>
            </div>
    
            <div class="form-section" id="investmentsSection" style="display: none;">
    <h2>Investimentos</h2>
    <div class="input-group" id="investmentsInputs">
        <select name="investmentType[]" required>
            <option value="" disabled selected>Selecione o tipo de investimento</option>
            <option value="poupanca">Poupança</option>
            <option value="renda_fixa">Renda Fixa</option>
            <option value="acoes">Ações</option>
            <option value="fundos">Fundos Imobiliários</option>
            <option value="criptomoedas">Criptomoedas</option>
        </select>
        <input type="number" name="currentValue[]" placeholder="Valor Atual de Investimento" required>
        <input type="number" name="annualReturn[]" placeholder="Retorno Anual (%)" required>
        <select name="riskLevel[]" required>
            <option value="" disabled selected>Nível de Risco</option>
            <option value="baixo">Baixo</option>
            <option value="medio">Médio</option>
            <option value="alto">Alto</option>
        </select>
    </div>
    <button type="button" onclick="addInvestment()">Adicionar Investimento</button>
</div>

<div class="form-section" id="goalsSection" style="display: none;">
    <h2>Metas de Aposentadoria</h2>
    <div class="input-group" id="goalsInputs">
        <input type="text" name="monthlyExpense[]" placeholder="Despesa Mensal" required>
        <input type="number" name="desiredInflationRate[]" placeholder="Taxa de Inflação Desejada (%)" required>
        <input type="number" name="necessaryFund[]" placeholder="Fundo Necessário" required>
        <input type="date" name="creationDate[]" required>
        <input type="date" name="updateDate[]" required>
    </div>
    <button type="button" onclick="addGoal()">Adicionar Meta</button>
</div>

    
            <button type="submit" class="finalizar-button">Finalizar</button>
        </div>
    </form>
    

    <script src="script.js"></script>
</body>
</html>
