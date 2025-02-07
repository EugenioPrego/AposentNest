function showSection(section) {
    // Oculta todas as seções
    document.getElementById('expensesSection').style.display = 'none';
    document.getElementById('investmentsSection').style.display = 'none';
    document.getElementById('goalsSection').style.display = 'none';

    // Exibe a seção selecionada
    document.getElementById(section + 'Section').style.display = 'block';
}

function addExpense() {
    const expensesInputs = document.getElementById('expensesInputs');
    const newExpense = document.createElement('div');
    newExpense.className = 'input-group';
    newExpense.innerHTML = `
        <select name="expenseCategory[]" required>
            <option value="" disabled selected>Selecione a categoria</option>
            <option value="alimentacao">Alimentação</option>
            <option value="transporte">Transporte</option>
            <option value="moradia">Moradia</option>
            <option value="saude">Saúde</option>
            <option value="lazer">Lazer</option>
        </select>
        <input type="number" name="expenseValue[]" placeholder="Valor" required>
        <button type="button" onclick="removeElement(this)">Remover</button>
    `;
    expensesInputs.appendChild(newExpense);
}

function addInvestment() {
    const investmentsInputs = document.getElementById('investmentsInputs');
    const newInvestment = document.createElement('div');
    newInvestment.className = 'input-group';
    newInvestment.innerHTML = `
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
        <input type="hidden" name="userId[]" value="">
        <button type="button" onclick="removeElement(this)">Remover</button>
    `;
    investmentsInputs.appendChild(newInvestment);
}

function addGoal() {
    const goalsInputs = document.getElementById('goalsInputs');
    const newGoal = document.createElement('div');
    newGoal.className = 'input-group';
    newGoal.innerHTML = `
        <input type="text" name="monthlyExpense[]" placeholder="Despesa Mensal" required>
        <input type="number" name="desiredInflationRate[]" placeholder="Taxa de Inflação Desejada (%)" required>
        <input type="number" name="necessaryFund[]" placeholder="Fundo Necessário" required>
        <input type="date" name="creationDate[]" required>
        <input type="date" name="updateDate[]" required>
        <input type="hidden" name="userIdGoal[]" value="">
        <button type="button" onclick="removeElement(this)">Remover</button>
    `;
    goalsInputs.appendChild(newGoal);
}


function removeElement(button) {
    // Remove o elemento pai (input-group) do botão clicado
    button.parentElement.remove();
}

function validarCampos() {
    const sections = ['expenses', 'investments', 'goals'];
    let allFilled = true;

    sections.forEach(section => {
        const inputs = document.querySelectorAll(`#${section}Section input`);
        inputs.forEach(input => {
            if (input.value.trim() === '') {
                allFilled = false;
            }
        });
    });

    return allFilled;
}

function finalizar() {
    if (validarCampos()) {
        alert("Todos os campos estão preenchidos! Planejamento finalizado."); // Aqui você pode adicionar a lógica de envio do formulário
    } else {
        alert("Por favor, preencha todos os campos antes de finalizar.");
    }
}
