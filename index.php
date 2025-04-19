<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexao.php'; // Inclui o arquivo de conexão com o banco de dados

    // Recebe os dados do formulário
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    // Prepara a consulta SQL para pegar id, senha e nome
    $sql = "SELECT id, senha, nome FROM funcionarios WHERE login = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hash_senha, $nome);
        $stmt->fetch();

        // Verifica a senha
        if (password_verify($senha, $hash_senha)) {
            // Armazena informações na sessão
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['nome'] = $nome; // 👈 Armazena o nome do usuário

            header("Location: forum.php");
            exit;
        } else {
            echo "<script>alert('Senha ou Usuário incorretos!');</script>";
        }
    } else {
        echo "<script>alert('Senha ou Usuário incorretos!');</script>";
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  <link href="css/login_cadastro.css?v=<?= filemtime('css/login_cadastro.css') ?>" rel="stylesheet" type="text/css">

  <script src="js/login.js?v=1.0.5" defer></script>

</head>
<body>
<div class="container">
    <header>
    <img src="images/logo.svg" alt="Logomarca">
    </header>
  
    <main >
    <div class="titulo"> 
        <h3>Login</h3>
        <h6>Insira a sua matrícula para fazer o login</h6>
    </div>
    <section>
    <div class="div-form">
        <div class="">
            
            <form id="form-login" method="post" action="">
              
              <div class="form-group">
               
               <!-- <label for="email">Email:</label>-->
                <input type="email" id="email" name="login" required placeholder="O domínio deve ser studioplay.com">
                <p id="email-helper" class="helper-text">Mensagem de ajuda</p>
              </div>
              <div class="form-group">
                <!--<label for="senha">Senha:</label>-->
                <input type="password" id="senhaLogin" name="senha" required placeholder="Digite a senha"/>
               
              </div>
              <div class="form-group">
              <input type="submit" value="Continuar" class="botaoInput">
              </div>
            </form>
          </div>
        </div>
        <div>
        <a href="redefinirSenha.php">Esqueci a senha</a>
        </div>
        <div class="linha-ou">
        <span>ou</span>
        </div>
        <div id="cadastre-se">
        <button onclick="window.location.href='cadastro.php'"> Cadastre-se aqui</button>
        </div>

        </section>


    
    </main>
    
    <footer >
      <div > <p >Copyright &#169; 2025 Specialisterne. Grupo: Gabriella, João Carlos, Rebecca e Renato | Todos os direitos reservados.</p></div>
    </footer>



</div>


</body>
</html>