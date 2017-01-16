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
    <link rel="stylesheet" href="/static/css/style.css" type="text/css">

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
            <ul class="nav">
                <li class="books <?= ($section=='books') ? 'on' : ''; ?>">
                    <a href="/books"><?= gettext("Books") ?></a>
                </li>
                <li class="movies <?= ($section=='movies') ? 'on' : ''; ?>">
                    <a href="/movies"><?= gettext("Movies") ?></a>
                </li>
                <li class="music <?= ($section=='music') ? 'on' : ''; ?>">
                    <a href="/music"><?= gettext("Music") ?></a>
                </li>
            </ul>
        </div>
    </div>
    <div id="content" data-page="<?= $page; ?>" data-action="<?= $action ?>">