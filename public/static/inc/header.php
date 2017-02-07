<?php
    require_once __DIR__ . '/helpers.php';

    $langs = [
        'en'    => 'EN',
        'de'    => 'DE',
        'ru'    => 'RU',
        'ua'    => 'UA',
    ];
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $pageTitle; ?></title>
    <link rel="stylesheet" type="text/css" href="/static/vendor/components-font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/static/vendor/chosen/chosen.css">
    <link rel="stylesheet" type="text/css" href="/static/vendor/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/static/css/style.css">

    <script type="text/javascript" src="/static/vendor/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="/static/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/static/vendor/chosen/chosen.jquery.js"></script>
</head>
<body>
    <div class="header">
        <div class="wrapper">
            <h1 class="branding-title"><a href="/"><?= gettext("Personal Media Library") ?></a></h1>
            <span class="lang">
                <?php foreach ($langs as $code => $langName) : ?>
                    <button data-value='<?= $code ?>'
                            class="btn btn-lang <?= getLanguage() == $code ? 'active' : '' ?>">
                        <?= $langName ?>
                    </button>
                <?php endforeach; ?>
            </span>
            <?php if (isLogedIn()) : ?>
                <ul class="nav">
                    <li class="books <?= $section == 'books' ? 'on' : '' ?>">
                        <a href="/books"><?= gettext("Books") ?></a>
                    </li>
                    <li class="movies <?= $section == 'movies' ? 'on' : '' ?>">
                        <a href="/movies"><?= gettext("Movies") ?></a>
                    </li>
                    <li class="music <?= $section == 'music' ? 'on' : '' ?>">
                        <a href="/music"><?= gettext("Music") ?></a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    <div class="options-block">
        <div class="wrapper">
            <?php if (isLogedIn()) : ?>
                <span class="user">
                    <?= gettext("Hello") ?>, <?= $_SESSION['UserName'] ?: $_SESSION['UserEmail'] ?>
                </span>
                <span class="pull-right">
                    <a href="/user/<?= $_SESSION['UserId'] ?>/edit" role="button" class="btn btn-default btn-sm">
                        <?= gettext("Edit personal data") ?>
                        <span class="fa fa-user-circle fa-fw"></span>
                    </a>
                    <button class="btn btn-default btn-sm" id='logout'>
                        <?= gettext("Log Out") ?>
                        <span class="fa fa-sign-out fa-fw"></span>
                    </button>
                </span>
            <?php else: ?>
                <span class="hint">
                    <?= gettext('To see library\'s content, you need to be logged in') ?>
                </span>
            <?php endif; ?>
        </div>
    </div>
    <div id="content" data-page="<?= $page; ?>" data-action="<?= $action ?>">