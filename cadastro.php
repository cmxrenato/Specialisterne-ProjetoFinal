<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexao.php'; // Inclui o arquivo de conexão com o banco de dados

    // Recebe os dados do formulário
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $setor = strtoupper(trim($_POST['setor'])); // <-- transforma em maiúsculas
    $confirma_senha = $_POST['confirma-senha'];

    // Hash da senha para armazenamento seguro
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Verifica se o login já existe
    $sql = "SELECT id FROM funcionarios WHERE login = ? OR matricula = ?";
    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conexao->error);
    }

    $stmt->bind_param("ss", $login, $matricula);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Se já existe, exibe mensagem de erro
        echo "<script>alert('Já existe um usuário cadastrado!');</script>";
    } else {
        // Caso contrário, insere o novo usuário
        $sql = "INSERT INTO funcionarios (login, senha, nome, matricula, setor) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);

        if ($stmt === false) {
            die("Erro na preparação da consulta de inserção: " . $conexao->error);
        }

        $stmt->bind_param("sssss", $login, $senha_hash, $nome, $matricula, $setor);

        if ($stmt->execute()) {
            echo "<script>alert('Usuário cadastrado com sucesso!');</script>";
        } else {
            echo "Erro ao cadastrar usuário: " . $stmt->error;
        }
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
  <title>Cadastro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  <link href="css/login_cadastro.css?v=<?= filemtime('css/login_cadastro.css') ?>" rel="stylesheet" type="text/css">
  <script src="js/cadastro.js?v=1.0.3" defer></script>
</head>
<body>
<div class="container">
    <header>
    <img src="images/logo.svg" alt="Logomarca">
    </header>
  
    <main>
    <div class="titulo"> 
        <h3>Cadastro de usuário</h3>
        <h6>Insira abaixo os dados solicitados</h6>
    </div>
    <section>
    <div class="div-form">
                        <form action="" method="post" id="cadastro-form">

                        <div class="form-group">
                               
                               <label for="matricula" class="label">Matrícula:</label>
                               <input type="number" id="matricula" name="matricula"  min="1" step="1" oninput="validity.valid||(value='')" required placeholder="Somente números inteiros">
                               
                           </div>


                            <div class="form-group">
                               
                                <label for="nome">Nome Completo:</label>
                                <input type="text" id="nome" name="nome" required>
                                <p id="username-helper" class="helper-text">Mensagem de ajuda</p>
                            </div>

                            <div class="form-group">
                               
                                <label for="setor">Setor:</label>
                                <input type="text" id="setor" name="setor" required>
                                
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="login" required placeholder="exemplo@studioplay.com">
                                <p id="email-helper" class="helper-text">Mensagem de ajuda</p>
                            </div>

                            <div class="form-group">
                                <label for="senha">Senha:</label>
                                <input type="password" id="senha" name="senha" required placeholder="exemplo: sdg@" />
                                <p id="senha-helper" class="helper-text">Mensagem de ajuda</p>
                                <span class="toggle-password-btn" onclick="togglePassword(this, 'senha')">👁️‍🗨️</span>
                            </div>

                            <div class="form-group">
                                <label for="confirma-senha">Confirmar senha:</label>
                                <input type="password" id="confirma-senha" name="confirma-senha" required placeholder="As senhas precisam ser iguais" />
                                <p id="confirma-senha-helper" class="helper-text">Mensagem de ajuda</p>
                                <span class="toggle-password-btn" onclick="togglePassword(this, 'confirma-senha')">👁️‍🗨️</span>
                            </div>

                            <div class="form-group">
                                <!--<button type="submit">Salvar</button>-->
                                <input type="submit" value="Cadastrar" class="botaoInput">
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

        </div>
    
    </main>
    
    <footer>
    <div > <p >Copyright &#169; 2025 Specialisterne. Grupo: Gabriella, João Carlos, Rebecca e Renato | Todos os direitos reservados.</p></div>
    </footer>



</div>


</body>
</html>