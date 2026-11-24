<?php
require_once 'auth.php';
require_once 'classes/Produto.class.php';
$produto = new Produto();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_produto   = $_GET['id'];
    $dadosProduto = $produto->buscarProduto($id_produto);
    $dadosImagens = $produto->buscarImagens($id_produto);
} else {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto</title>
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container">
        <?php if (!empty($dadosProduto)): ?>
            <div class="card shadow-sm p-4 mb-4">
                <h2><?php echo htmlspecialchars($dadosProduto['nome_produto']); ?></h2>
                <p class="text-muted mb-2"><strong>Descrição:</strong> <?php echo htmlspecialchars($dadosProduto['descricao']); ?></p>
                <h4 class="text-success">R$ <?php echo number_format((float)$dadosProduto['valor'], 2, ',', '.'); ?></h4>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($dadosImagens as $dado): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm text-center p-2">
                            <img src="imgs/<?php echo htmlspecialchars($dado['nome_imagem']); ?>" class="card-img-top" style="height: 240px; object-fit: cover;">
                            <div class="card-body">
                                <button class="btn btn-success w-100">Comprar</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>