<?php
require_once 'auth.php';
require_once 'classes/Produto.class.php';
$produto = new Produto();

if (isset($_POST['id_produto'])) {
    $produto->apagarProduto($_POST['id_produto']);
    header("Location: listar_produtos.php");
    exit();
}

$lista = $produto->buscarProdutos();
$idSelecionado = isset($_GET['id']) ? $_GET['id'] : null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Produto</title>
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="card shadow-sm mx-auto p-4" style="max-width: 500px;">
            <h3 class="mb-4 text-center text-danger">Deletar Produto</h3>
            <form method="post" onsubmit="return confirm('Tem certeza? O produto e suas imagens serão apagados.');">
                <div class="mb-3">
                    <label class="form-label">Escolha o produto para excluir</label>
                    <select name="id_produto" class="form-select" required>
                        <?php foreach ($lista as $p): ?>
                            <option value="<?php echo $p['id_produto']; ?>" <?php echo ($p['id_produto'] == $idSelecionado) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($p['nome_produto']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-danger w-100">Apagar Produto</button>
            </form>
        </div>
    </div>
</body>
</html>
