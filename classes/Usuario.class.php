<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Usuario {
    private $pdo;

    public function __construct() {
        $dns  = "mysql:host=localhost;dbname=imagem_db";
        $user = "root";
        $pass = "";

        try {
            $this->pdo = new PDO($dns, $user, $pass);
        } catch (PDOException $e) {
            echo "Erro na Conexão: " . $e->getMessage();
            exit();
        }
    }

    // Autenticar usuário no login
    public function logar($email, $senha) {
        $sql = "SELECT * FROM usuarios WHERE email = :e AND senha = :s";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':e', $email);
        $sql->bindValue(':s', md5($senha));
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $dados = $sql->fetch(PDO::FETCH_ASSOC);
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['id_usuario']   = $dados['id_usuario'];
            $_SESSION['nome_usuario'] = $dados['nome'];
            return true;
        }
        return false;
    }

    // Inserir usuário
    public function inserirUsuario($nome, $email, $senha) {
        $sql = "SELECT id_usuario FROM usuarios WHERE email = :e";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':e', $email);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return false; // E-mail já cadastrado
        }

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:n, :e, :s)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':n', $nome);
        $sql->bindValue(':e', $email);
        $sql->bindValue(':s', md5($senha));
        return $sql->execute();
    }

    // Listar todos os usuários
    public function listarUsuarios() {
        $sql = "SELECT id_usuario, nome, email FROM usuarios ORDER BY id_usuario DESC";
        $sql = $this->pdo->query($sql);

        if ($sql && $sql->rowCount() > 0) {
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return array();
    }

    // Buscar um usuário específico pelo ID
    public function buscarUsuario($id) {
        $sql = "SELECT id_usuario, nome, email FROM usuarios WHERE id_usuario = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return $sql->fetch(PDO::FETCH_ASSOC);
        }
        return array();
    }

    // Alterar/Atualizar usuário
    public function alterarUsuario($id, $nome, $email, $senha = '') {
        if (!empty($senha)) {
            $sql = "UPDATE usuarios SET nome = :n, email = :e, senha = :s WHERE id_usuario = :id";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':s', md5($senha));
        } else {
            $sql = "UPDATE usuarios SET nome = :n, email = :e WHERE id_usuario = :id";
            $sql = $this->pdo->prepare($sql);
        }
        $sql->bindValue(':n', $nome);
        $sql->bindValue(':e', $email);
        $sql->bindValue(':id', $id);
        return $sql->execute();
    }

    // Apagar/Deletar usuário
    public function apagarUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        return $sql->execute();
    }
}