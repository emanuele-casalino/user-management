<?php
if (count($page_variables->messages) >= 1) {
    foreach ($page_variables->messages as $message) {
        ?>
        <div class="alert alert-<?= $message->type ?>">
            <?php
            if ($message->parameters) {
                ?>
                <?= vsprintf(htmlspecialchars($page_dictionary["messages"][$message->lemma]), $message->parameters) ?>
                <?php
            } else {
                ?>
                <?= htmlspecialchars($page_dictionary["messages"][$message->lemma]) ?>
                <?php
            }
            ?>
        </div>
        <?php
    }
}
?>
<form class="row g-3" method="post">
    <?php
    if ($page_variables->hide_form) {
        ?>
        <a class="btn btn-success" href="<?= $page_variables->app_url_prefix ?>/<?= Consts::HOME_PAGE_NAME ?>">
            <?= htmlspecialchars($page_dictionary["pages"][Consts::HOME_PAGE_NAME]) ?></a>
        <?php
    } else {
        ?>
        <div class="mb-3">
            <label for="input-password" class="form-label">
                <?= htmlspecialchars($page_dictionary["variables"]["password"]) ?></label>
            <input class="form-control"
                   id="input-password"
                   name="password" 
                   placeholder="<?= htmlspecialchars($page_dictionary["variables"]["password"]) ?>"
                   type="password" 
                   maxlength="<?= Config::MAX_PASSWORD_LENGTH ?>">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="input-confirm-unsubscription" name="confirm_unsubscription" value="1">
                <label class="form-check-label" for="input-confirm-unsubscription"><?= htmlspecialchars($page_dictionary["variables"]["confirm_unsubscription"]) ?></label>
            </div>
        </div>
        <button class="btn btn-primary">
            <?= htmlspecialchars($page_dictionary["pages"]["unsubscribe_from_the_site"]) ?>
        </button>
        <?php
    }
    ?>
</form>