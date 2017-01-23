<?php

require_once __DIR__ . '/inc/helpers.php';

if (!isLogedIn()) {
    header('Location: /login');
}

$pageTitle = gettext("Personal Media Library");
$pageTitle .= isset($title) ? ' | ' . $title : '';

$section = null;
$action = null;
$page = 'library';

if (!isset($items)) $items = [];

include("inc/header.php");
?>
        <div class="section catalog random">
            <div class="wrapper">
                <h2><?= gettext('May we suggest something?') ?></h2>
                <ul class="catalog">
                    <?php // TODO: add ribbon to each category (movie, book, music) ?>
                    <?php foreach ($items as $item) : ?>
                        <li>
                            <a href='<?= '/' . $item['category'] . '/' . $item['id'] ?>'>
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
