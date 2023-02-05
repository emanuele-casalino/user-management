<ul class="list-group">
    <li class="list-group-item">
        <b><?= htmlspecialchars($page_dictionary["variables"]["username"]) ?>:</b>
        <?=
        htmlspecialchars($page_variables->logged_user[Config::USERNAME_VARIABLE_NAME])
        ?>   
    </li>
    <li class="list-group-item">
        <b><?= htmlspecialchars($page_dictionary["variables"]["email_address"]) ?>:</b>
        <?=
        htmlspecialchars($page_variables->logged_user[Config::EMAIL_VARIABLE_NAME])
        ?>   
    </li>
</ul>