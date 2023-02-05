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
            <?= htmlspecialchars($page_dictionary["pages"]["home"]) ?></a>
        <?php
    } else {
        ?>
        <div class="mb-3">
            <label for="input-email" class="form-label">
                <?= htmlspecialchars($page_dictionary["variables"]["email_address"]) ?></label>
            <input class="form-control"
                   id="input-email"
                   name="email" 
                   placeholder="<?= htmlspecialchars($page_dictionary["variables"]["email_address"]) ?>"
                   type="email" 
                   maxlength="<?= Config::MAX_EMAIL_LENGTH ?>">
        </div>
        <div class="mb-3">
            <label for="input-username" class="form-label">
                <?= htmlspecialchars($page_dictionary["variables"]["username"]) ?></label>
            <input class="form-control"
                   id="input-username"
                   name="username"
                   placeholder="<?= htmlspecialchars($page_dictionary["variables"]["username"]) ?>"
                   type="text" 
                   maxlength="<?= Config::MAX_USERNAME_LENGTH ?>">
        </div>
        <button class="btn btn-primary">
            <?= htmlspecialchars($page_dictionary["pages"]["sign_up_on_the_site"]) ?>
        </button>
        <?php
    }
    ?>
</form>