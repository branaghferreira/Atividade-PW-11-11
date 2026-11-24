<?php
require_once 'auth.php';
require_once 'classes/Produto.class.php';
$produto = new Produto();
$lista = $produto->buscarProdutos();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Produtos</title>
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="card shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Produtos Cadastrados</h3>
                <a href="cadastrar_produto.php" class="btn btn-primary">+ Novo Produto</a>
            </div>
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($lista)): ?>
                        <tr><td colspan="5" class="text-center text-muted">Nenhum produto cadastrado.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($lista as $p): ?>
                        <tr>
                            <td><?php echo $p['id_produto']; ?></td>
                            <td>
                                <?php if (!empty($p['foto_capa'])): ?>
                                    <img src="imgs/<?php echo htmlspecialchars($p['foto_capa']); ?>" width="56" height="56" style="object-fit: cover;" class="rounded" alt="">
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($p['nome_produto']); ?></td>
                            <td>R$ <?php echo number_format((float)$p['valor'], 2, ',', '.'); ?></td>
                            <td class="text-end">
                                <a href="exibir_produto.php?id=<?php echo $p['id_produto']; ?>" class="btn btn-sm btn-info">Ver</a>
                                <a href="atualizar_produto.php?id=<?php echo $p['id_produto']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="deletar_produto.php?id=<?php echo $p['id_produto']; ?>" class="btn btn-sm btn-danger">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
