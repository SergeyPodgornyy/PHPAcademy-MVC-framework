<?php

$pageTitle = gettext("Personal Media Library");
$pageTitle .= isset($title) ? ' | ' . $title : '';

$section = null;
$action = isset($action) ? $action : null;

if (isset($page)) {
    $section = $page;
} else {
    $page = $section;
}

if (!isset($item) || !$item) {
    header("location: ");
    exit;
}

include("inc/header.php");
?>

<div class="section page">
    <div class="wrapper">
        <?php // TODO: Add breadcrumbs ?>
        <div class="pull-right">
            <a href="<?= '/' . $page . '/' . $item['id'] . '/edit' ?>" type="button" class="btn btn-warning">
                <span class="fa fa-pencil"></span> <?= gettext('Edit data') ?>
            </a>
            <button type="button"
                    class="btn btn-danger"
                    id="delete-item"
                    data-id="<?= $item['id'] ?>"
                    style="width: 150px">
                <span class="fa fa-trash-o fa-fw"></span> <?= gettext('Delete item') ?>
            </button>
        </div>
        <div class="clear-fix"></div>
        <div class="media-picture">
            <span>
                <img src="/static/<?= $item["image"] ?: 'img/300x300.gif' ?>" alt="<?= $item["title"];?>">
            </span>
        </div>
        <div class="media-details">
            <h1><?= $item["title"]; ?></h1>
            <table>
                <tr>
                    <th><?= gettext('Genre') ?></th>
                    <td><?= $item["genre"] ?></td>
                </tr>
                <tr>
                    <th><?= gettext('Format') ?></th>
                    <td><?= $item["format"] ?></td>
                </tr>
                <tr>
                    <th><?= gettext('Year') ?></th>
                    <td><?= $item["year"] ?></td>
                </tr>

                <?php if (strtolower($page) === "books") : ?>

                    <tr>
                        <th><?= gettext('Authors') ?></th>
                        <td><?= implode(", ", $item["authors"]) ?></td>
                    </tr>
                    <tr>
                        <th><?= gettext('Publisher') ?></th>
                        <td><?= $item["publisher"] ?></td>
                    </tr>
                    <tr>
                        <th><?= gettext('ISBN') ?></th>
                        <td><?= $item["isbn"] ?></td>
                    </tr>

                <?php elseif (strtolower($page) === "movies") : ?>

                    <tr>
                        <th><?= gettext('Director') ?></th>
                        <td><?= $item["director"] ?></td>
                    </tr>
                    <tr>
                        <th><?= gettext('Stars') ?></th>
                        <td><?= implode(", ", $item["casts"]) ?></td>
                    </tr>

                <?php elseif (strtolower($page) === "music") : ?>

                    <tr>
                        <th><?= gettext('Artist') ?></th>
                        <td><?= $item["artist"] ?></td>
                    </tr>

                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

<?php include("inc/footer.php"); ?>
