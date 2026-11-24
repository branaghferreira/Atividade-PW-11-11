<?php require_once 'auth.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100 mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Sistema Loja</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Vitrine</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Produtos</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="listar_produtos.php">Listar / Gerenciar</a></li>
                        <li><a class="dropdown-item" href="cadastrar_produto.php">Inserir Produto</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Usuários</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="listar_usuarios.php">Listar / Gerenciar</a></li>
                        <li><a class="dropdown-item" href="cadastrar_usuario.php">Inserir Usuário</a></li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex align-items-center text-white">
                <span class="me-3">Olá, <?php echo htmlspecialchars($_SESSION['nome_usuario']); ?></span>
                <a href="sair.php" class="btn btn-outline-light btn-sm">Sair</a>
            </div>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
