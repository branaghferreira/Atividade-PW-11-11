<?php
require_once 'auth.php';
require_once 'classes/Produto.class.php';
$produto = new Produto();
$dadosProduto = $produto->buscarProdutos();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos Cadastrados</title>
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2 class="mb-4 text-center">Produtos Cadastrados</h2>

        <?php if (empty($dadosProduto)): ?>
            <div class="alert alert-info text-center">Ainda não há produtos cadastrados aqui!</div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                <?php foreach ($dadosProduto as $Value): ?>
                    <div class="col">
                        <a href="exibir_produto.php?id=<?php echo $Value['id_produto']; ?>" class="text-decoration-none text-dark">
                            <div class="card h-100 shadow-sm">
                                <?php if (!empty($Value['foto_capa'])): ?>
                                    <img src="imgs/<?php echo $Value['foto_capa']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?php echo htmlspecialchars($Value['nome_produto']); ?>">
                                <?php endif; ?>
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo htmlspecialchars($Value['nome_produto']); ?></h5>
                                    <p class="card-text text-success fw-bold">R$ <?php echo number_format((float)$Value['valor'], 2, ',', '.'); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>