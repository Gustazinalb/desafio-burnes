<?php

if (!isset($pagina)) {
    exit;
}

if (empty($id)) {
    mensagem(
        "Erro!",
        "Banner inválido.",
        "error"
    );
    exit;
}

$sql = "select * from banner where id = :id limit 1";

$consulta = $pdo->prepare($sql);
$consulta->bindParam(":id", $id);
$consulta->execute();

$dados = $consulta->fetch(PDO::FETCH_OBJ);

if (!$dados) {
    mensagem(
        "Erro!",
        "Banner não encontrado.",
        "error"
    );
    exit;
}

$sql = "delete from banner where id = :id";

$consulta = $pdo->prepare($sql);
$consulta->bindParam(":id", $id);

if ($consulta->execute()) {

    if (!empty($dados->banner)) {

        $arquivo = "../_arquivos/" . $dados->banner;

        if (file_exists($arquivo)) {
            unlink($arquivo);
        }
    }

    mensagem(
        "Sucesso!",
        "Banner excluído com sucesso.",
        "success"
    );

} else {

    mensagem(
        "Erro!",
        "Erro ao excluir o banner.",
        "error"
    );
}