<div class="container p-5">

    <?php

        $sqlBanner = "
            SELECT *
            FROM banner
            WHERE ativo = 'S'
            ORDER BY id DESC
        ";

        $consultaBanner = $pdo->prepare($sqlBanner);
        $consultaBanner->execute();

        $banners = $consultaBanner->fetchAll(PDO::FETCH_OBJ);

    ?>

    <?php if (!empty($banners)) { ?>

        <div
            id="carouselBanner"
            class="carousel slide mb-5 shadow"
            data-bs-ride="carousel"
        >

            <div class="carousel-indicators">

                <?php foreach ($banners as $indice => $banner) { ?>

                    <button
                        type="button"
                        data-bs-target="#carouselBanner"
                        data-bs-slide-to="<?= $indice ?>"
                        class="<?= $indice == 0 ? 'active' : '' ?>"
                        aria-current="<?= $indice == 0 ? 'true' : 'false' ?>"
                        aria-label="Banner <?= $indice + 1 ?>"
                    ></button>

                <?php } ?>

            </div>

            <div class="carousel-inner">

                <?php foreach ($banners as $indice => $banner) { ?>

                    <div
                        class="carousel-item <?= $indice == 0 ? 'active' : '' ?>"
                    >

                        <img
                            src="_arquivos/<?= htmlspecialchars($banner->banner) ?>"
                            class="d-block w-100 banner-img"
                            alt="<?= htmlspecialchars($banner->descricao) ?>"
                        >

                    </div>

                <?php } ?>

            </div>

            <?php if (count($banners) > 1) { ?>

                <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#carouselBanner"
                    data-bs-slide="prev"
                >

                    <span
                        class="carousel-control-prev-icon"
                        aria-hidden="true"
                    ></span>

                    <span class="visually-hidden">
                        Anterior
                    </span>

                </button>

                <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#carouselBanner"
                    data-bs-slide="next"
                >

                    <span
                        class="carousel-control-next-icon"
                        aria-hidden="true"
                    ></span>

                    <span class="visually-hidden">
                        Próximo
                    </span>

                </button>

            <?php } ?>

        </div>

    <?php } ?>

    <h2>Destaques de Hoje:</h2>

    <div class="row">

        <?php

            $sqlDestaques = "
                SELECT
                    f.id,
                    f.titulo,
                    f.ano,
                    f.original,
                    f.capa,
                    c.categoria
                FROM filme f
                INNER JOIN categoria c
                    ON c.id = f.categoria_id
                ORDER BY RAND()
                LIMIT 4
            ";

            $consulta = $pdo->prepare($sqlDestaques);
            $consulta->execute();

            $dadosDestaques = $consulta->fetchAll(PDO::FETCH_OBJ);

            foreach ($dadosDestaques as $dados) {

        ?>

            <div class="col-12 col-md-3">

                <div class="card shadow">

                    <img
                        src="arquivos/<?= $dados->capa ?>"
                        alt="<?= $dados->titulo ?>"
                        class="w-100"
                    >

                    <div class="card-body">

                        <h3>
                            <?= $dados->titulo ?>
                        </h3>

                        <p>
                            <i><?= $dados->original ?></i>
                            (<?= $dados->ano ?>)
                        </p>

                        <p>
                            Categoria:
                            <?= $dados->categoria ?>
                        </p>

                        <p>

                            <a
                                href="filme/<?= $dados->id ?>"
                                title="Detalhes"
                                class="btn btn-warning w-100"
                            >
                                Detalhes
                            </a>

                        </p>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</div>