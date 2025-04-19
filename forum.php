<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

include 'conexao.php';

if (isset($_POST['enviar_pergunta'])) {
    $pergunta = trim($_POST['pergunta']);
    $id_usuario = $_SESSION['id'];
    $imagem_path = null;

    if (!empty($_FILES['imagem']['name'])) {
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid() . "." . $ext;
        $caminho = "uploads/" . $nome_arquivo;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            $imagem_path = $caminho;
        }
    }

    if (!empty($pergunta)) {
        $stmt = $conexao->prepare("INSERT INTO perguntas (id_usuario, pergunta, imagem) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id_usuario, $pergunta, $imagem_path);
        $stmt->execute();
        $stmt->close();
    }
}

if (isset($_POST['enviar_resposta'])) {
    $id_pergunta = $_POST['id_pergunta'];
    $resposta = trim($_POST['resposta']);
    $id_usuario = $_SESSION['id'];
    $id_resposta_pai = isset($_POST['id_resposta_pai']) ? $_POST['id_resposta_pai'] : null;

    if (!empty($resposta)) {
        $stmt = $conexao->prepare("INSERT INTO respostas (id_pergunta, id_usuario, resposta, id_resposta_pai) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iisi", $id_pergunta, $id_usuario, $resposta, $id_resposta_pai);
        $stmt->execute();
        $stmt->close();
    }
}

if (isset($_POST['excluir_pergunta'])) {
    $id = $_POST['id_pergunta_excluir'];
    $stmt = $conexao->prepare("DELETE FROM perguntas WHERE id = ? AND id_usuario = ?");
    $stmt->bind_param("ii", $id, $_SESSION['id']);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['editar_pergunta'])) {
    $id_editar = $_POST['id_pergunta_editar'];
    $stmt = $conexao->prepare("SELECT pergunta FROM perguntas WHERE id = ? AND id_usuario = ?");
    $stmt->bind_param("ii", $id_editar, $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($pergunta_editar);
    $stmt->fetch();
    $stmt->close();
}

if (isset($_POST['salvar_pergunta_editada'])) {
    $nova_pergunta = $_POST['nova_pergunta'];
    $id_pergunta = $_POST['id_pergunta'];
    $stmt = $conexao->prepare("UPDATE perguntas SET pergunta = ? WHERE id = ? AND id_usuario = ?");
    $stmt->bind_param("sii", $nova_pergunta, $id_pergunta, $_SESSION['id']);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['excluir_resposta'])) {
    $id = $_POST['id_resposta_excluir'];
    $stmt = $conexao->prepare("DELETE FROM respostas WHERE id = ? AND id_usuario = ?");
    $stmt->bind_param("ii", $id, $_SESSION['id']);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['editar_resposta'])) {
    $id_editar_resposta = $_POST['id_resposta_editar'];
    $stmt = $conexao->prepare("SELECT resposta FROM respostas WHERE id = ? AND id_usuario = ?");
    $stmt->bind_param("ii", $id_editar_resposta, $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($resposta_editar);
    $stmt->fetch();
    $stmt->close();
}

if (isset($_POST['salvar_resposta_editada'])) {
    $nova_resposta = $_POST['nova_resposta'];
    $id_resposta = $_POST['id_resposta'];
    $stmt = $conexao->prepare("UPDATE respostas SET resposta = ? WHERE id = ? AND id_usuario = ?");
    $stmt->bind_param("sii", $nova_resposta, $id_resposta, $_SESSION['id']);
    $stmt->execute();
    $stmt->close();
}

function mostrar_respostas($conexao, $id_pergunta, $id_resposta_pai = null, $nivel = 1) {
    $sql = "SELECT r.id, r.resposta, r.data, f.nome, f.setor, r.id_usuario FROM respostas r JOIN funcionarios f ON r.id_usuario = f.id WHERE r.id_pergunta = ? AND ".($id_resposta_pai === null ? "r.id_resposta_pai IS NULL" : "r.id_resposta_pai = ?")." ORDER BY r.data ASC";
    $stmt = $id_resposta_pai === null ? $conexao->prepare($sql) : $conexao->prepare($sql);
    $id_resposta_pai === null ? $stmt->bind_param("i", $id_pergunta) : $stmt->bind_param("ii", $id_pergunta, $id_resposta_pai);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($resp = $res->fetch_assoc()) {
        echo "<div class='resposta' style='margin-left:" . (20 * $nivel) . "px'>";
        echo "<strong>{$resp['nome']}</strong> ({$resp['setor']}) respondeu em {$resp['data']}<br><br>";
        echo "<p>" . nl2br(htmlspecialchars($resp['resposta'])) . "</p>";

        if ($_SESSION['id'] == $resp['id_usuario']) {
            echo "<div class='editarExcluir-botoes'><form method='POST' action='' style='display:inline;'>
                    <input type='hidden' name='id_resposta_editar' value='{$resp['id']}'>
                    <input type='submit' class='editar' name='editar_resposta' value='Editar'>
                  </form>";
            echo "<form method='POST' action='' onsubmit='return confirm(\"Excluir esta resposta?\")' style='display:inline;'>
                    <input type='hidden' name='id_resposta_excluir' value='{$resp['id']}'>
                    <input type='submit' class='excluir' name='excluir_resposta' value='Excluir'>
                  </form></div>";
        }

        echo "<form method='POST' action=''>
                <input type='hidden' name='id_pergunta' value='{$id_pergunta}'>
                <input type='hidden' name='id_resposta_pai' value='{$resp['id']}'>
                <textarea name='resposta' rows='2' required></textarea><br>
                <div id='botaoResposta'>
                <input type='submit' name='enviar_resposta' value='Responder'></div>
              </form>";

        mostrar_respostas($conexao, $id_pergunta, $resp['id'], $nivel + 1);
        echo "</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Fórum Simples</title>
    <link href="css/forum.css?v=<?= filemtime('css/forum.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="js/forum.js?v=1.0.5" defer></script>
</head>
<body>
    <div class="container">
<header>
    <img src="images/logo.svg" id="logoForum" alt="logo-do-forum">
    <nav class="menu">
        <ul>
            <li><a href="#" class="active">Fórum</a></li>
            <li><a href="#">Para você</a></li>
            <li><a href="#">Favoritos</a></li>
            
        </ul>
    </nav>
</header>
<div class="submenu"><div id="nome"><p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</p></div>
<div><a href="logout.php" class="botao-sair" onclick="return confirmarSaida()">🔒 Sair</a></div>


</div>

<form method="GET" action="">
    <label for="setor">Filtrar por setor:</label>
    <select name="setor" id="setor">
        <option value="">Todos</option>
        <?php
        $setores = $conexao->query("SELECT DISTINCT setor FROM funcionarios WHERE setor IS NOT NULL ORDER BY setor");
        while ($s = $setores->fetch_assoc()) {
            $selecionado = (isset($_GET['setor']) && $_GET['setor'] == $s['setor']) ? "selected" : "";
            echo "<option value='{$s['setor']}' $selecionado>{$s['setor']}</option>";
        }
        ?>
    </select>
    <input type="submit" value="Filtrar">
</form>
<hr>

<h2>Fazer uma nova pergunta</h2>
<form method="POST" action="" enctype="multipart/form-data">
    <textarea name="pergunta" rows="3" required></textarea><br>
    <input type="file" name="imagem" accept="image/*"><br><br>
    <div id='botaoPergunta'><input type="submit" name="enviar_pergunta" value="Enviar Pergunta"></div>
</form>

<?php if (isset($pergunta_editar)): ?>
    <hr>
    <div class="divEditar">
    <h3>Editando Pergunta</h3>
    <form method="POST" action="">
        <input type="hidden" name="id_pergunta" value="<?php echo $id_editar; ?>">
        <textarea name="nova_pergunta" rows="3" required><?php echo htmlspecialchars($pergunta_editar); ?></textarea><br>
        <div class='botoes-principais'><input type="submit" name="salvar_pergunta_editada" value="Salvar Alterações"></div>
    </form>
    </div>
<?php endif; ?>
<?php if (isset($resposta_editar)) {
    echo "<hr><div class='divEditar'><h3>Editando Resposta</h3>
          <form method='POST' action=''>
            <input type='hidden' name='id_resposta' value='{$id_editar_resposta}'>
            <textarea name='nova_resposta' rows='2' required>" . htmlspecialchars($resposta_editar) . "</textarea><br>
            <input type='submit' name='salvar_resposta_editada' value='Salvar Alterações'>
          </form></div>";
}?>

<hr>
<h2>Perguntas e Respostas</h2>
<?php
$filtro_setor = isset($_GET['setor']) && $_GET['setor'] != "" ? $_GET['setor'] : null;

$sql = "SELECT p.id, p.pergunta, p.imagem, p.data, f.nome, f.setor, p.id_usuario FROM perguntas p 
        JOIN funcionarios f ON p.id_usuario = f.id";
if ($filtro_setor) {
    $sql .= " WHERE f.setor = ?";
}
$sql .= " ORDER BY p.data DESC";

$stmt = $conexao->prepare($sql);
if ($filtro_setor) {
    $stmt->bind_param("s", $filtro_setor);
}
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $id_pergunta = $row['id'];

    echo "<div class='pergunta'>";
    echo "<strong>{$row['nome']}</strong> ({$row['setor']}) perguntou em {$row['data']}<br><br>";
    echo "<p>" . nl2br(htmlspecialchars($row['pergunta'])) . "</p>";
    if (!empty($row['imagem'])) {
        echo "<img src='{$row['imagem']}'>";
    }

    if ($_SESSION['id'] == $row['id_usuario']) {
        echo "<div class='editarExcluir-botoes'><form method='POST' action='' style='display:inline;'>
                <input type='hidden' name='id_pergunta_editar' value='{$row['id']}'>
                <input type='submit' class='editar' name='editar_pergunta' value='Editar'>
              </form>";
        echo "<form method='POST' action='' onsubmit='return confirm(\"Tem certeza que deseja excluir esta pergunta?\")' style='display:inline;'>
                <input type='hidden' name='id_pergunta_excluir' value='{$row['id']}'>
                <input type='submit' class='excluir' id='botaoExcluir' name='excluir_pergunta' value='Excluir'>
              </form></div>";
    }

    echo "<form method='POST' action=''>
            <input type='hidden' name='id_pergunta' value='{$id_pergunta}'>
            <textarea name='resposta' rows='2' required></textarea><br>
            <div id='botaoResposta'><input type='submit' name='enviar_resposta' value='Responder'>
          </form></div>";

    // Aqui entra o sistema de respostas aninhadas:
    mostrar_respostas($conexao, $id_pergunta);

    echo "</div>";
}
$stmt->close();



$conexao->close();
?>
</div>
</body>
</html>