<?php

require_once __DIR__ . '/inc/helpers.php';

if (!isLogedIn()) {
    header('Location: /login');
}

$pageTitle = gettext("Personal Media Library");
$pageTitle .= isset($title) ? ' | ' . $title : '';

$section = null;
$action = null;

if (isset($page)) {
    $section = $page;
} else {
    $page = $section;
}
if (!isset($items)) $items = [];

include("inc/header.php");
?>

<div class="section catalog page">
    <div class="wrapper">
        <?php // TODO: Add breadcrumbs ?>
        <?php if (isSuperAdmin()) : ?>
            <div class="pull-right">
                <a href="<?= '/' . $page . '/create' ?>" type="button" class="btn btn-success">
                    <span class="fa fa-plus fa-fw"></span> <?= gettext('Insert new item') ?>
                </a>
            </div>
        <?php endif; ?>
        <ul class="catalog">
            <?php foreach ($items as $item) : ?>
                <li>
                    <a href='<?= '/' . $page . '/' . $item['id'] ?>'>
                        <img src="/static/<?= $item['image'] ?: 'img/300x300.gif' ?>" alt="<?= $item['title'] ?>">
                        <p><?= gettext('View Details') ?></p>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php // TODO: implement pagination ?>
    </div>
</div>

<?php include("inc/footer.php"); ?>
