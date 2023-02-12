<form class="row g-3" method="post">
    <?php
    if ($page_variables->logged_user) {
        ?>
        <a class="btn btn-primary" href="<?= $page_variables->app_url_prefix ?>/<?= Consts::VIEW_USER_INFO_PAGE_NAME ?>">
            <?= htmlspecialchars($page_dictionary["pages"][Consts::VIEW_USER_INFO_PAGE_NAME]) ?></a>
        <a class="btn btn-primary" href="<?= $page_variables->app_url_prefix ?>/<?= Consts::CHANGE_USERNAME_PAGE_NAME ?>">
            <?= htmlspecialchars($page_dictionary["pages"][Consts::CHANGE_USERNAME_PAGE_NAME]) ?></a>
        <a class="btn btn-primary" href="<?= $page_variables->app_url_prefix ?>/<?= Consts::CHANGE_PASSWORD_PAGE_NAME ?>">
            <?= htmlspecialchars($page_dictionary["pages"][Consts::CHANGE_PASSWORD_PAGE_NAME]) ?></a>
        <a class="btn btn-primary" href="<?= $page_variables->app_url_prefix ?>/<?= Consts::UNSUBSCRIBE_FROM_THE_SITE_PAGE_NAME ?>">
            <?= htmlspecialchars($page_dictionary["pages"][Consts::UNSUBSCRIBE_FROM_THE_SITE_PAGE_NAME]) ?></a>
        <?php
    } else {
        ?>
        <a class="btn btn-primary" href="<?= $page_variables->app_url_prefix ?>/<?= Consts::PASSWORD_RECOVERY_PAGE_NAME ?>">
            <?= htmlspecialchars($page_dictionary["pages"][Consts::PASSWORD_RECOVERY_PAGE_NAME]) ?></a>
        <a class="btn btn-primary" href="<?= $page_variables->app_url_prefix ?>/<?= Consts::REQUEST_ACTIVATION_LINK_PAGE_NAME ?>">
            <?= htmlspecialchars($page_dictionary["pages"][Consts::REQUEST_ACTIVATION_LINK_PAGE_NAME]) ?></a>
        <a class="btn btn-primary" href="<?= $page_variables->app_url_prefix ?>/<?= Consts::SIGN_UP_ON_THE_SITE_PAGE_NAME ?>">
            <?= htmlspecialchars($page_dictionary["pages"][Consts::SIGN_UP_ON_THE_SITE_PAGE_NAME]) ?></a>
            <?php
        }
        ?>
</form>