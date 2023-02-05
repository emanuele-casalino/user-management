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
        <a class="btn btn-success" href="<?= $page_variables->app_url_prefix ?>/<?= Consts::LOGIN_PAGE_NAME ?>">
            <?= htmlspecialchars($page_dictionary["pages"]["login"]) ?></a>
        <?php
    } else {
        ?>
        <div class="mb-3">
            <label for="input-old-password" class="form-label">
                <?= htmlspecialchars($page_dictionary["variables"]["old_password"]) ?></label>
            <input class="form-control"
                   id="input-old-password"
                   name="old_password" 
                   placeholder="<?= htmlspecialchars($page_dictionary["variables"]["old_password"]) ?>"
                   type="password" 
                   maxlength="<?= Config::MAX_PASSWORD_LENGTH ?>">
        </div>
        <div class="mb-3">
            <label for="input-new-password-1" class="form-label">
                <?= htmlspecialchars($page_dictionary["variables"]["new_password_1"]) ?></label>
            <input class="form-control"
                   id="input-new-password-1"
                   name="new_password_1" 
                   placeholder="<?= htmlspecialchars($page_dictionary["variables"]["new_password_1"]) ?>"
                   type="password" 
                   maxlength="<?= Config::MAX_PASSWORD_LENGTH ?>">
        </div>
        <div class="mb-3">
            <label for="input-new-password-2" class="form-label">
                <?= htmlspecialchars($page_dictionary["variables"]["new_password_2"]) ?></label>
            <input class="form-control"
                   id="input-new-password-2"
                   name="new_password_2" 
                   placeholder="<?= htmlspecialchars($page_dictionary["variables"]["new_password_2"]) ?>"
                   type="password" 
                   maxlength="<?= Config::MAX_PASSWORD_LENGTH ?>">
        </div>
        <button class="btn btn-primary">
            <?= htmlspecialchars($page_dictionary["pages"]["change_password"]) ?>
        </button>
        <?php
    }
    ?>
</form>