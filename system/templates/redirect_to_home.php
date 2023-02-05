<script type="text/javascript">
    window.location.href = "<?= $page_variables->app_url_prefix ?>";
</script>
<div class="alert alert-info">
    <a href="<?= $page_variables->app_url_prefix ?>">
        <?= htmlspecialchars($page_dictionary["messages"]["possible_non_automatic_redirect"]) ?></a>
</div>
<?php
exit(0);
