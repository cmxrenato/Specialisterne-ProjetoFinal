<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Redefinir Senha</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  
  <link href="css/esqueci-a-senha.css?v=<?= filemtime('css/esqueci-a-senha.css') ?>" rel="stylesheet" type="text/css">
  <script src="js/redefinirSenha.js" defer></script>
</head>
<body>
<div class="container">
    <header>
    <img src="images/logo.svg" alt="Logomarca">
    </header>
  
    <main >
    <div class="titulo"> 
        <h3>Redefinição de Senha</h3>
        <h6>Insira a seu email institucional para redefinir a senha</h6>
    </div>
    <section>
    <div class="div-form">
                        <form action="" id="envio-form">

                      

                            

                            <div class="form-group" id="teste">
                                <label for="email" >Email:</label>
                                <input type="email" id="email" name="email" required placeholder="exemplo@studioplay.com">
                                <p id="email-helper" class="helper-text">Mensagem de ajuda</p>
                            </div>

                            

                            

                            <div class="form-group">
                                <button type="submit">Enviar</button>
                            </div>
                            <div class="linha-ou">
                                <span>ou</span>
                                </div>
                            <div class="form-group">
                                <button  onclick="window.location.href='index.php'">Voltar ao login</button>
                            </div>
                        </form>
                    </div>
        

        </section>

        
    
    </main>
    </div>
    <footer>
    <div > <p >Copyright &#169; 2025 Specialisterne. Grupo: Gabriella, João Carlos, Rebecca e Renato | Todos os direitos reservados.</p></div>
    </footer>



</div>


</body>
</html>