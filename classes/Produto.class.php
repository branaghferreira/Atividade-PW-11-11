<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Produto {
    private $pdo;

    public function __construct(){
        $dns  = "mysql:host=localhost;dbname=imagem_db";
        $user = "root";
        $pass = "";
   
        try{
            $this->pdo = new PDO($dns, $user, $pass);
        }catch(PDOException $e){
            echo "Erro na Conexão: ".$e->getMessage();
            exit();
        }
    }

    public function conecta(){
        return $this->pdo;
    }

    public function enviarProduto($nome, $descricao, $valor, $fotos = array()){
     
        $valor = $this->converterValor($valor);

       
        $sql = "INSERT INTO produtos (nome_produto, descricao, valor) VALUES (:n, :d, :v)";
        $sql = $this->pdo->prepare($sql);

        $sql->bindValue(':n', $nome);
        $sql->bindValue(':d', $descricao);
        $sql->bindValue(':v', $valor);
        
        $isOk = $sql->execute();
        
        if($isOk){
            $id_produto = $this->pdo->lastInsertId();

   
            $this->salvarImagens($id_produto, $fotos);
        }
    }

    // Aceita "10.50" (input number) ou "1.234,56" (formato brasileiro)
    private function converterValor($valor){
        $valor = trim((string) $valor);
        if (strpos($valor, ',') !== false) {
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
        }
        return (float) $valor;
    }

    // Grava os arquivos enviados em imgs/ e registra na tabela imagens
    private function salvarImagens($id_produto, $fotos){
        if (!file_exists("imgs")) {
            mkdir("imgs", 0777, true);
        }

        if(isset($fotos['name']) && is_array($fotos['name'])){
            for ($i = 0; $i < count($fotos['name']); $i++) {
                if ($fotos['error'][$i] === UPLOAD_ERR_OK) {
                    $nome_original = $fotos['name'][$i];
                    $tmp_name      = $fotos['tmp_name'][$i];

                    $ext = strtolower(pathinfo($nome_original, PATHINFO_EXTENSION));
                    if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'webp'))) {
                        continue; // ignora arquivos que não são imagem
                    }
                    $nome_foto = md5($nome_original . time() . rand(0, 9999)) . '.' . $ext;

                    if (move_uploaded_file($tmp_name, "imgs/" . $nome_foto)) {
                        $sqlImg = "INSERT INTO imagens (nome_imagem, fk_id_produto) VALUES (:n, :p)";
                        $sqlImg = $this->pdo->prepare($sqlImg);
                        $sqlImg->bindValue(':n', $nome_foto);
                        $sqlImg->bindValue(':p', $id_produto);
                        $sqlImg->execute();
                    }
                }
            }
        }
    }

    // Alterar/Atualizar produto (e acrescentar novas imagens, se enviadas)
    public function alterarProduto($id, $nome, $descricao, $valor, $fotos = array()){
        $valor = $this->converterValor($valor);

        $sql = "UPDATE produtos SET nome_produto = :n, descricao = :d, valor = :v WHERE id_produto = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':n', $nome);
        $sql->bindValue(':d', $descricao);
        $sql->bindValue(':v', $valor);
        $sql->bindValue(':id', $id);
        $isOk = $sql->execute();

        if ($isOk) {
            $this->salvarImagens($id, $fotos);
        }
        return $isOk;
    }

    // Apagar/Deletar produto (as linhas de imagens caem por ON DELETE CASCADE)
    public function apagarProduto($id){
        // apaga os arquivos físicos antes de remover o registro
        foreach ($this->buscarImagens($id) as $img) {
            $arq = "imgs/" . basename($img['nome_imagem']);
            if (is_file($arq)) {
                unlink($arq);
            }
        }
        $sql = "DELETE FROM produtos WHERE id_produto = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        return $sql->execute();
    }

    // Apagar uma imagem específica do produto
    public function apagarImagem($id_imagem){
        $sql = "SELECT nome_imagem FROM imagens WHERE id_imagem = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id_imagem);
        $sql->execute();
        $img = $sql->fetch(PDO::FETCH_ASSOC);

        if ($img) {
            $arq = "imgs/" . basename($img['nome_imagem']);
            if (is_file($arq)) {
                unlink($arq);
            }
        }
        $sql = "DELETE FROM imagens WHERE id_imagem = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id_imagem);
        return $sql->execute();
    }

    public function buscarProdutos(){
        $sql = "SELECT p.*, 
                (SELECT nome_imagem FROM imagens WHERE fk_id_produto = p.id_produto LIMIT 1) AS foto_capa 
                FROM produtos p ORDER BY id_produto DESC";
        $sql = $this->pdo->query($sql);

        if($sql && $sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return array();
        }
    }

    public function buscarProduto($id){
        $sql = "SELECT * FROM produtos WHERE id_produto = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
    
        if($sql->rowCount() > 0){
            return $sql->fetch(PDO::FETCH_ASSOC);
        }else{
            return array();
        }
    }

    public function buscarImagens($id){
        $sql = "SELECT * FROM imagens WHERE fk_id_produto = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return array();
        }
    }
}