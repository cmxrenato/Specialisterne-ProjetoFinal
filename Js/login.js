let usernameEmail = document.getElementById("email")
let labelEmail = document.querySelector('label[for="email"]')
let emailHelper = document.getElementById('email-helper')



usernameEmail.addEventListener("change", (e)=>{
    let valor = e.target.value
    if (valor.includes("@") && valor.includes("studioplay.com")){
        usernameEmail.classList.add('correct')
        usernameEmail.classList.remove('error')
        emailHelper.classList.remove('visible')
       
    } else{
        usernameEmail.classList.remove('correct')
        usernameEmail.classList.add('error')
        emailHelper.innerText = "O email dever ter @ e studioplay.com"
        emailHelper.classList.add('visible')
       
    }



})

function mostrarPopup(input,label){
    input.addEventListener("focus",()=>{
        label.classList.add('required-popup')
    })
    input.addEventListener("blur",()=>{
        label.classList.remove('required-popup')
    })
}


let form = document.getElementById("form-login"); 

form.addEventListener("submit", (e) => {
   
    let emailValido = usernameEmail.classList.contains('correct');
   
    if (!emailValido) { 
        e.preventDefault(); 
        alert("Por favor, corrija os erros antes de enviar."); 
        } });



mostrarPopup(usernameEmail, labelEmail)
mostrarPopup(senhaInput, senhaLabel)
