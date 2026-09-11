<?php

if (!isset($pagina)) {
    exit;
}

$id = $_POST["id"] ?? "";
$descricao = trim($_POST["descricao"] ?? "");
$ativo = $_POST["ativo"] ?? "N";

if (empty($descricao)) {
    mensagem(
        "Erro!",
        "Preencha a descrição do banner.",
        "error"
    );
    exit;
}

if ($ativo != "S" && $ativo != "N") {
    $ativo = "N";
}

$nomeImagem = "";

if (
    isset($_FILES["banner"]) &&
    !empty($_FILES["banner"]["name"])
) {

    $arquivo = $_FILES["banner"];

    if ($arquivo["error"] != UPLOAD_ERR_OK) {
        mensagem(
            "Erro!",
            "Ocorreu um erro ao enviar a imagem.",
            "error"
        );
        exit;
    }

    $extensao = strtolower(
        pathinfo(
            $arquivo["name"],
            PATHINFO_EXTENSION
        )
    );

    $extensoesPermitidas = [
        "jpg",
        "jpeg",
        "png",
        "webp"
    ];

    if (!in_array($extensao, $extensoesPermitidas)) {
        mensagem(
            "Erro!",
            "Envie uma imagem JPG, JPEG, PNG ou WEBP.",
            "error"
        );
        exit;
    }

    $nomeImagem = time() . "_" . uniqid() . "." . $extensao;

    $pasta = "../_arquivos/";

    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $destino = $pasta . $nomeImagem;

    if (!move_uploaded_file($arquivo["tmp_name"], $destino)) {
        mensagem(
            "Erro!",
            "Não foi possível salvar a imagem.",
            "error"
        );
        exit;
    }
}

if (empty($id)) {

    if (empty($nomeImagem)) {
        mensagem(
            "Erro!",
            "Selecione uma imagem para o banner.",
            "error"
        );
        exit;
    }

    $sql = "
        INSERT INTO banner (
            descricao,
            banner,
            ativo
        )
        VALUES (
            :descricao,
            :banner,
            :ativo
        )
    ";

    $consulta = $pdo->prepare($sql);

    $consulta->bindParam(":descricao", $descricao);
    $consulta->bindParam(":banner", $nomeImagem);
    $consulta->bindParam(":ativo", $ativo);

} else {

    if (!empty($nomeImagem)) {

        $sql = "
            UPDATE banner
            SET
                descricao = :descricao,
                banner = :banner,
                ativo = :ativo
            WHERE id = :id
        ";

        $consulta = $pdo->prepare($sql);

        $consulta->bindParam(":descricao", $descricao);
        $consulta->bindParam(":banner", $nomeImagem);
        $consulta->bindParam(":ativo", $ativo);
        $consulta->bindParam(":id", $id);

    } else {

        $sql = "
            UPDATE banner
            SET
                descricao = :descricao,
                ativo = :ativo
            WHERE id = :id
        ";

        $consulta = $pdo->prepare($sql);

        $consulta->bindParam(":descricao", $descricao);
        $consulta->bindParam(":ativo", $ativo);
        $consulta->bindParam(":id", $id);
    }
}

if ($consulta->execute()) {

    mensagem(
        "Sucesso!",
        "Registro salvo com sucesso.",
        "success"
    );

} else {

    mensagem(
        "Erro!",
        "Erro ao salvar o registro.",
        "error"
    );
}