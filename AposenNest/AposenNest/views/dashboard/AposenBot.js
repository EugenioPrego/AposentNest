const chatCaller = document.querySelector('#chatCaller');
const chatExit = document.querySelector('.bi-chevron-double-down');

chatCaller.addEventListener('click', () => {
    document.querySelector('.chat-container').style.transform = 'scale(1)';
});

chatExit.addEventListener('click', () => {
    document.querySelector('.chat-container').style.transform = 'scale(0)';
});

const userInput = document.getElementById('userInput');
const chatlogs = document.querySelector('.chat-interation-container');
const button = document.querySelector('#button');

button.addEventListener('click', () => {
    const userMessage = userInput.value.trim();
    if (!userMessage) return; // Ignora se a mensagem estiver vazia
    userInput.value = '';

    // Cria um novo elemento para a mensagem do usuário
    const userDiv = document.createElement('div');
    userDiv.classList.add('receiver');
    chatlogs.appendChild(userDiv);
    
    const userDivText = document.createElement('p');
    userDivText.textContent = userMessage;
    userDiv.appendChild(userDivText);

    // Simula a resposta do bot
    const botDiv = document.createElement('div');
    botDiv.classList.add('sender');
    chatlogs.appendChild(botDiv);
    
    const botDivP = document.createElement('p');
    botDiv.appendChild(botDivP);

    // Efeito typing
    const typing = () => {
        const botMessage = getBotResponse(userMessage); // Função para gerar a resposta do bot
        botDivP.textContent = '';
        let i = 0;
        const interval = setInterval(() => {
            botDivP.textContent += botMessage[i++];
            if (i === botMessage.length) {
                clearInterval(interval);
            }
        }, 50);
    };

    setTimeout(() => {
        typing();
    }, 1000);
});

// Função para gerar uma resposta mais robusta
function getBotResponse(message) {
    message = message.toLowerCase(); // Normaliza a mensagem para comparação

    // Lógica de resposta
    if (message.includes('oi') || message.includes('olá')) {
        return 'Olá! Como posso te ajudar com suas dúvidas sobre finanças e aposentadoria?';
    } else if (message.includes('como vai')) {
        return 'Estou bem, obrigado! E você? Como posso ajudar?';
    } else if (message.includes('aposentadoria')) {
        return 'A aposentadoria é um tema importante! Você gostaria de saber sobre planos de aposentadoria, cálculos ou algo específico?';
    } else if (message.includes('investimento')) {
        return 'Investimentos são fundamentais para uma aposentadoria segura. Você já possui algum plano de investimento?';
    } else if (message.includes('planejamento')) {
        return 'O planejamento é crucial. Você gostaria de ajuda para criar um plano de aposentadoria personalizado?';
    } else if (message.includes('seguro')) {
        return 'Fazer um plano de aposentadoria seguro envolve diversificar seus investimentos e considerar diferentes fontes de renda. Podemos te ajudar a entender suas opções!';
    } else if (message.includes('como começar')) {
        return 'Começar é mais fácil do que você pensa! Avalie suas despesas, defina seus objetivos e entre em contato conosco para ajudar a montar um plano!';
    } else if (message.includes('dicas')) {
        return 'Aqui vão algumas dicas: comece a poupar cedo, diversifique seus investimentos e revise seu plano anualmente. Estamos aqui para te ajudar em cada passo!';
    } else if (message.includes('quem és tu') || message.includes('quem é você')) {
        return 'EU SOU o AposenBot, desenvolvido por uma equipe de Desenvolvedores Web dirigido por Lúcio José na empresa Mundo da Tecnologia em 2024.';
    } else if (message.includes('como devo fazer para ter um plano financeiro seguro')) {
        return 'Para ter um planejamento financeiro seguro, você deve ser usuário do AposenNest, um sistema de planejamento seguro desenvolvido pela empresa Mundo da Tecnologia.';
    } else if (message.includes('obrigado')) {
        return 'Estou sempre aqui para ajudar! Se tiver mais perguntas, não hesite em perguntar.';
    } else {
        return 'Não entendi, mas estou aqui para ajudar! Tente reformular a sua pergunta ou pergunte sobre finanças ou aposentadoria.';
    }
}
