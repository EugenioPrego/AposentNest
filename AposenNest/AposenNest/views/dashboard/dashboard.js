var scale = document.querySelectorAll(".scale")

document.querySelector(".bi-text-right").addEventListener('click', () =>{
    document.querySelector(".container-body").classList.toggle("active")

    scale.forEach(e => {
        e.classList.add("scale")
    });
    
})

// Script para abrir e fechar a modal
const reportModal = document.getElementById('reportModal');
const reportLink = document.querySelector('a[href="#"]'); // Link do relatório
const closeModal = document.getElementById('closeModal');

// Quando o usuário clicar no link do relatório
reportLink.addEventListener('click', (e) => {
    e.preventDefault(); // Previne a ação padrão
    reportModal.style.display = 'block'; // Exibe a modal
});

// Quando o usuário clicar no 'x' (fechar)
closeModal.addEventListener('click', () => {
    reportModal.style.display = 'none'; // Esconde a modal
});

// Quando o usuário clicar fora da modal
window.addEventListener('click', (event) => {
    if (event.target === reportModal) {
        reportModal.style.display = 'none';
    }
});
