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
if ($page_variables->redirect_to_home_filename) {
    require_once($page_variables->redirect_to_home_filename);
}
?>
<form class="row g-3" method="post">
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
    <button class="btn btn-primary">
        <?= htmlspecialchars($page_dictionary["commands"]["login"]) ?>
    </button>
</form>