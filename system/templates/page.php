<!doctype html>
<html lang="<?= $page_variables->page_lang ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/<?= Config::APP_DIR ?>/css/theme.css?time=<?= time() ?>">
        <title>
            <?= htmlspecialchars($page_dictionary["app_title"]) ?>
            -
            <?= htmlspecialchars($page_dictionary["pages"][$page_variables->page_name]) ?>
        </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <?= htmlspecialchars($page_dictionary["menus"]["main_menu"]) ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= $page_variables->app_url_prefix ?>">
                                <?= htmlspecialchars($page_dictionary["pages"]["home"]) ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= $page_variables->app_url_prefix ?>/<?= Consts::INFO_PAGE_NAME ?>">
                                <?= htmlspecialchars($page_dictionary["pages"]["info"]) ?></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php
                                if ($page_variables->logged_user) {
                                    ?>
                                    <b><?= $page_variables->logged_user[Config::USERNAME_VARIABLE_NAME] ?></b>
                                    <?php
                                } else {
                                    ?>
                                    (<?= htmlspecialchars($page_dictionary["messages"]["guest_user"]) ?>)
                                    <?php
                                }
                                ?></a>
                            <ul class="dropdown-menu">
                                <?php
                                if ($page_variables->logged_user) {
                                    ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $page_variables->app_url_prefix ?>/<?= Consts::LOGOUT_PAGE_NAME ?>">
                                            <?= htmlspecialchars($page_dictionary["pages"]["logout"]) ?></a>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $page_variables->app_url_prefix ?>/<?= Consts::LOGIN_PAGE_NAME ?>">
                                            <?= htmlspecialchars($page_dictionary["pages"]["login"]) ?></a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="/<?= Config::APP_DIR ?>/images/langs/<?= $page_variables->page_lang ?>.jpg" style="max-height: 16px;" />
                                <?= htmlspecialchars($page_dictionary["variables"]["language"]) ?></a>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($page_variables->page_langs as $page_lang) {
                                    ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $page_lang->url ?>">
                                            <img src="/<?= Config::APP_DIR ?>/images/langs/<?= $page_lang->value ?>.jpg" style="max-height: 16px;" />
                                            <?= htmlspecialchars($page_dictionary["languages"][$page_lang->value]) ?></a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <h1 class="text-primary">
                <?= htmlspecialchars($page_dictionary["app_title"]) ?>
            </h1>
            <h2 class="text-secondary">
                <?= htmlspecialchars($page_dictionary["pages"][$page_variables->page_name]) ?>
            </h2>
            <?php
            require_once($page_variables->view_filename);
            ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>