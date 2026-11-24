<?php
require_once 'auth.php';
require_once 'classes/Usuario.class.php';
$usuario = new Usuario();

$msg = '';
if (isset($_POST['id_usuario'])) {
    if ($_POST['id_usuario'] == $_SESSION['id_usuario']) {
        $msg = "Você não pode excluir o usuário que está logado.";
    } else {
        $usuario->apagarUsuario($_POST['id_usuario']);
        header("Location: listar_usuarios.php");
        exit();
    }
}

$lista = $usuario->listarUsuarios();
$idSelecionado = isset($_GET['id']) ? $_GET['id'] : null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Usuário</title>
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="card shadow-sm mx-auto p-4" style="max-width: 500px;">
            <h3 class="mb-4 text-center text-danger">Deletar Usuário</h3>
            <?php if (!empty($msg)): ?>
                <div class="alert alert-warning"><?php echo htmlspecialchars($msg); ?></div>
            <?php endif; ?>
            <form method="post" onsubmit="return confirm('Tem certeza que deseja apagar este usuário?');">
                <div class="mb-3">
                    <label class="form-label">Escolha o usuário para excluir</label>
                    <select name="id_usuario" class="form-select" required>
                        <?php foreach ($lista as $u): ?>
                            <option value="<?php echo $u['id_usuario']; ?>" <?php echo ($u['id_usuario'] == $idSelecionado) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($u['nome'] . " - " . $u['email']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-danger w-100">Apagar Usuário</button>
            </form>
        </div>
    </div>
</body>
</html>