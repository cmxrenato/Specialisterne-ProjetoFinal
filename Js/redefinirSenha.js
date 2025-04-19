// Elementos do formulário
let emailInput = document.getElementById("email");
let emailHelper = document.getElementById('email-helper');
let form = document.getElementById("envio-form"); 

// Validação do email
emailInput.addEventListener("input", (e) => {
    let valor = e.target.value;
    if (valor.includes("@") && valor.includes("studioplay.com")) {
        emailInput.classList.add('correct');
        emailInput.classList.remove('error');
        emailHelper.classList.remove('visible');
    } else {
        emailInput.classList.remove('correct');
        emailInput.classList.add('error');
        emailHelper.innerText = "O email deve ter @ e studioplay.com";
        emailHelper.classList.add('visible');
    }
});

// Envio do formulário
form.addEventListener("submit", (e) => {
    let emailValido = emailInput.classList.contains('correct');
    
    if (!emailValido) {
        e.preventDefault(); 
        alert("Por favor, insira um email válido (@studioplay.com) antes de enviar."); 
    } else {
        e.preventDefault(); // Remove isso se quiser enviar o formulário
        alert("Email enviado! Verifique sua caixa de entrada!");
        
        // Redireciona após 2 segundos
        setTimeout(() => {
            window.location.href = "index.php"; // Altere para o caminho correto
        }, 1000);
    }
});




mostrarPopup(emailInput, labelEmail);
