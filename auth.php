<?php
// Protege a página: deve ser incluído no TOPO, antes de qualquer processamento
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
