<?php

require_once __DIR__ . '/inc/helpers.php';

if (!isLogedIn()) {
    header('Location: /login');
}

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
            <?php if (isSuperAdmin()) : ?>
                <a href="<?= '/' . $page . '/' . $item['id'] . '/edit' ?>" type="button" class="btn btn-warning">
                    <span class="fa fa-pencil"></span> <?= gettext('Edit data') ?>
                </a>
            <?php endif; ?>
            <?php if (isAdmin() || isSuperAdmin()) : ?>
                <button type="button"
                        class="btn btn-danger"
                        id="delete-item"
                        data-id="<?= $item['id'] ?>"
                        style="width: 150px">
                    <span class="fa fa-trash-o fa-fw"></span> <?= gettext('Delete item') ?>
                </button>
            <?php endif; ?>
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

<div class="modal fade in" id="delete-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                <h4 class="modal-title">
                    </span> <?= gettext('Confirmation of item deletion') ?>
                </h4>
            </div>
            <div class="modal-body">
                <p><?= gettext('Are you sure you want to permanently delete this item?') ?></p>
            </div>
            <input type="hidden" name="_method" value="delete" />
            <div class="modal-footer">
                <button class="btn btn-danger delete-btn">
                    <span class="fa fa-remove fa-fw"></span> <?= gettext('Delete') ?>
                </button>
                <button class="btn btn-default close-btn" data-dismiss="modal"><?= gettext('Close') ?></button>
            </div>
        </div>
    </div>
</div>

<?php include("inc/footer.php"); ?>
