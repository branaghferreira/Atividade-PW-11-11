<?php
require_once 'auth.php';
require_once 'classes/Usuario.class.php';
$usuario = new Usuario();

if (isset($_POST['id_usuario'])) {
    $usuario->alterarUsuario($_POST['id_usuario'], $_POST['nome'], $_POST['email'], $_POST['senha']);
    header("Location: listar_usuarios.php");
    exit();
}

$lista = $usuario->listarUsuarios();
$idSelecionado = isset($_GET['id']) ? $_GET['id'] : (isset($lista[0]['id_usuario']) ? $lista[0]['id_usuario'] : null);
$dadosUsuario  = $idSelecionado ? $usuario->buscarUsuario($idSelecionado) : array();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Usuário</title>
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="card shadow-sm mx-auto p-4" style="max-width: 500px;">
            <h3 class="mb-4 text-center">Atualizar Usuário</h3>

            <form method="get" class="mb-4">
                <label class="form-label">Selecione o Usuário</label>
                <select name="id" class="form-select" onchange="this.form.submit()">
                    <?php foreach ($lista as $u): ?>
                        <option value="<?php echo $u['id_usuario']; ?>" <?php echo ($u['id_usuario'] == $idSelecionado) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($u['nome'] . " (" . $u['email'] . ")"); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if (!empty($dadosUsuario)): ?>
                <form method="post">
                    <input type="hidden" name="id_usuario" value="<?php echo $dadosUsuario['id_usuario']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($dadosUsuario['nome']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($dadosUsuario['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                        <input type="password" name="senha" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Salvar Alterações</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>