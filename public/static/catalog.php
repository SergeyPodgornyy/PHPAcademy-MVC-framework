<?php

$pageTitle = "Personal Media Library";
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
        <div class="pull-right">
            <a href="<?= '/' . $page . '/create' ?>" type="button" class="btn btn-success">
                <span class="fa fa-plus fa-fw"></span> Insert new item
            </a>
        </div>
        <ul class="catalog">
            <?php foreach ($items as $item) : ?>
                <li>
                    <a href='<?= '/' . $page . '/' . $item['id'] ?>'>
                        <img src="/static/<?= $item['poster'] ?: 'img/300x300.gif' ?>" alt="<?= $item['title'] ?>">
                        <p>View Details</p>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<?php include("inc/footer.php"); ?>
