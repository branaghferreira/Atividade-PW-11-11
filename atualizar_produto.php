<?php
require_once 'auth.php';
require_once 'classes/Produto.class.php';
$produto = new Produto();

// Remover uma imagem específica
if (isset($_POST['apagar_imagem'])) {
    $produto->apagarImagem($_POST['apagar_imagem']);
    header("Location: atualizar_produto.php?id=" . (int) $_POST['id_produto']);
    exit();
}

// Salvar alterações
if (isset($_POST['id_produto'])) {
    $fotos = isset($_FILES['foto']) ? $_FILES['foto'] : array();
    $produto->alterarProduto($_POST['id_produto'], $_POST['nome'], $_POST['descricao'], $_POST['valor'], $fotos);
    header("Location: listar_produtos.php");
    exit();
}

$lista = $produto->buscarProdutos();
$idSelecionado = isset($_GET['id']) ? $_GET['id'] : (isset($lista[0]['id_produto']) ? $lista[0]['id_produto'] : null);
$dadosProduto  = $idSelecionado ? $produto->buscarProduto($idSelecionado) : array();
$dadosImagens  = $idSelecionado ? $produto->buscarImagens($idSelecionado) : array();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Produto</title>
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="card shadow-sm mx-auto p-4" style="max-width: 600px;">
            <h3 class="mb-4 text-center">Atualizar Produto</h3>

            <form method="get" class="mb-4">
                <label class="form-label">Selecione o Produto</label>
                <select name="id" class="form-select" onchange="this.form.submit()">
                    <?php foreach ($lista as $p): ?>
                        <option value="<?php echo $p['id_produto']; ?>" <?php echo ($p['id_produto'] == $idSelecionado) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($p['nome_produto']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if (!empty($dadosProduto)): ?>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_produto" value="<?php echo $dadosProduto['id_produto']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Nome do Produto</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($dadosProduto['nome_produto']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" rows="4" class="form-control" required><?php echo htmlspecialchars($dadosProduto['descricao']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Valor (R$)</label>
                        <input type="number" name="valor" step="0.01" min="0" class="form-control" value="<?php echo htmlspecialchars($dadosProduto['valor']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adicionar novas imagens (opcional)</label>
                        <input type="file" name="foto[]" class="form-control" accept="image/*" multiple>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Salvar Alterações</button>
                </form>

                <?php if (!empty($dadosImagens)): ?>
                    <hr class="my-4">
                    <h6>Imagens atuais</h6>
                    <div class="row row-cols-3 g-2">
                        <?php foreach ($dadosImagens as $img): ?>
                            <div class="col text-center">
                                <img src="imgs/<?php echo htmlspecialchars($img['nome_imagem']); ?>" class="img-fluid rounded mb-1" style="height: 90px; object-fit: cover; width: 100%;" alt="">
                                <form method="post" onsubmit="return confirm('Remover esta imagem?');">
                                    <input type="hidden" name="id_produto" value="<?php echo $dadosProduto['id_produto']; ?>">
                                    <button type="submit" name="apagar_imagem" value="<?php echo $img['id_imagem']; ?>" class="btn btn-sm btn-outline-danger w-100">Remover</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
