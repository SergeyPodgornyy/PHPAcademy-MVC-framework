<!DOCTYPE html>
<html>
<head>
    <title><?= $pageTitle; ?></title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
            <h1 class="branding-title"><a href="/">Personal Media Library</a></h1>
            <ul class="nav">
                <li class="books <?= ($section=='books') ? 'on' : ''; ?>">
                    <a href="/books">Books</a>
                </li>
                <li class="movies <?= ($section=='movies') ? 'on' : ''; ?>">
                    <a href="/movies">Movies</a>
                </li>
                <li class="music <?= ($section=='music') ? 'on' : ''; ?>">
                    <a href="/music">Music</a>
                </li>
            </ul>
        </div>
    </div>
    <div id="content" data-page="<?= $page; ?>" data-action="<?= $action ?>">