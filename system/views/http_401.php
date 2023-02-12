<div class="alert alert-warning">
    <?= htmlspecialchars($page_dictionary["messages"]["not_enough_permissions"]) ?>
</div>
<div class="row g-3">
    <a class="btn btn-warning" href="<?= $page_variables->app_url_prefix ?>">
        <?= htmlspecialchars($page_dictionary["pages"][Consts::HOME_PAGE_NAME]) ?></a>
</div>