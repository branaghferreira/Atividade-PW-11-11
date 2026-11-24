<?php
require_once 'auth.php';
require_once 'classes/Usuario.class.php';
$usuario = new Usuario();

$msg = '';
if (isset($_POST['nome'])) {
    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($usuario->inserirUsuario($nome, $email, $senha)) {
        header("Location: listar_usuarios.php");
        exit();
    } else {
        $msg = "Este e-mail já está cadastrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Usuário</title>
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="card shadow-sm mx-auto p-4" style="max-width: 500px;">
            <h3 class="mb-4 text-center">Inserir Usuário</h3>
            <?php if (!empty($msg)): ?>
                <div class="alert alert-warning"><?php echo $msg; ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Cadastrar Usuário</button>
            </form>
        </div>
    </div>
</body>
</html>