<?php
    if (!isset($pagina)) exit;

    if (!empty($id)) {
        $sql = "select * from banner where id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dadosBanner = $consulta->fetch(PDO::FETCH_OBJ);
    }

    $id = $dadosBanner->id ?? NULL;
    $descricao = $dadosBanner->descricao ?? NULL;
    $banner = $dadosBanner->banner ?? NULL;
    $ativo = $dadosBanner->ativo ?? "S";
?>

<div class="card shadow">

    <div class="card-header">

        <div class="float-start">
            <h2>Cadastro de Banner</h2>
        </div>

        <div class="float-end">

            <a href="cadastrar/banner" class="btn btn-success">
                Novo Registro
            </a>

            <a href="listar/banner" class="btn btn-info">
                Listar
            </a>

        </div>

    </div>

    <div class="card-body">

        <form
            name="formCadastro"
            method="post"
            action="salvar/banner"
            enctype="multipart/form-data"
            data-parsley-validate
        >

            <div class="row">

                <div class="col-12 col-md-2">

                    <label for="id">ID:</label>

                    <input
                        type="text"
                        name="id"
                        id="id"
                        class="form-control"
                        readonly
                        value="<?= $id ?>"
                    >

                </div>

                <div class="col-12 col-md-10">

                    <label for="descricao">Descrição:</label>

                    <input
                        type="text"
                        name="descricao"
                        id="descricao"
                        class="form-control"
                        maxlength="100"
                        required
                        value="<?= $descricao ?>"
                        data-parsley-required-message="Preencha a descrição"
                    >

                </div>

                <div class="col-12 col-md-8 mt-3">

                    <label for="banner">Imagem do Banner:</label>

                    <input
                        type="file"
                        name="banner"
                        id="banner"
                        class="form-control"
                        accept=".jpg,.jpeg,.png"
                    >

                    <?php
                    if (!empty($banner)) {
                        ?>
                        <p class="mt-2">
                            Imagem atual:
                            <strong><?= $banner ?></strong>
                        </p>
                        <?php
                    }
                    ?>

                </div>

                <div class="col-12 col-md-4 mt-3">

                    <label for="ativo">Ativo:</label>

                    <select
                        name="ativo"
                        id="ativo"
                        class="form-control"
                        required
                    >

                        <option value="S" <?= $ativo == "S" ? "selected" : "" ?>>
                            Sim
                        </option>

                        <option value="N" <?= $ativo == "N" ? "selected" : "" ?>>
                            Não
                        </option>

                    </select>

                </div>

            </div>

            <br>

            <button
                type="submit"
                class="btn btn-success float-end"
            >
                Salvar Registro
            </button>

        </form>

    </div>

</div>