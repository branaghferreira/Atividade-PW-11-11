<?php
require_once 'auth.php';
require_once 'classes/Usuario.class.php';
$usuario = new Usuario();
$lista = $usuario->listarUsuarios();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Usuários</title>
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="card shadow-sm p-4">
            <h3 class="mb-4">Usuários Cadastrados</h3>
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $u): ?>
                        <tr>
                            <td><?php echo $u['id_usuario']; ?></td>
                            <td><?php echo htmlspecialchars($u['nome']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td class="text-end">
                                <a href="atualizar_usuario.php?id=<?php echo $u['id_usuario']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="deletar_usuario.php?id=<?php echo $u['id_usuario']; ?>" class="btn btn-sm btn-danger">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>