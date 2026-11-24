<?php
require_once 'auth.php';
require_once 'classes/Produto.class.php';
$produto = new Produto();

if (isset($_POST['nome'])) {
    $nome      = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $valor     = $_POST['valor'];
    $fotos     = isset($_FILES['foto']) ? $_FILES['foto'] : array();

    $produto->enviarProduto($nome, $descricao, $valor, $fotos);
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="card shadow-sm mx-auto p-4" style="max-width: 550px;">
            <h3 class="mb-4 text-center">Cadastrar Produto</h3>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Produto</label>
                    <input type="text" id="nome" name="nome" class="form-control" required placeholder="Ex: Sofá Retrátil">
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="4" class="form-control" required placeholder="Informe os detalhes do produto..."></textarea>
                </div>
                <div class="mb-3">
                    <label for="valor" class="form-label">Valor (R$)</label>
                    <input type="number" id="valor" name="valor" step="0.01" min="0" class="form-control" required placeholder="0.00">
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Imagens do Produto</label>
                    <input type="file" id="foto" name="foto[]" class="form-control" accept="image/*" multiple required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Cadastrar Produto</button>
            </form>
        </div>
    </div>
</body>
</html>