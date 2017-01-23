<?php

require_once __DIR__ . '/inc/helpers.php';

if (!isSuperAdmin()) {
    header('Location: /music');
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
if (!isset($items)) $items = [];

include("inc/header.php");
?>

<div class="section page">
    <div class="wrapper">
        <h1><?= isset($title) ? $title : '' ?></h1>
        <form data-id="<?= isset($item['id']) ? $item['id'] : '' ?>">
            <table>
                <tr>
                    <th>
                        <label for="title"><?= gettext("Title") ?> <span class="required">(<?= gettext("required") ?>)</span></label>
                    </th>
                    <td>
                        <input type="text"
                               id="title"
                               name="title"
                               <?= isset($item['title']) ? "value='{$item['title']}'" : ""; ?>>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="year"><?= gettext("Year") ?> <span class="required">(<?= gettext("required") ?>)</span></label>
                    </th>
                    <td>
                        <input type="text"
                               id="year"
                               name="year"
                               <?= isset($item['year']) ? "value='{$item['year']}'" : ""; ?>>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="genre"><?= gettext("Genre") ?> <span class="required">(<?= gettext("required") ?>)</span></label>
                    </th>
                    <td>
                        <select id="genre" name="genre" data-placeholder="<?= gettext("Select One") ?>" class="chosen-select">
                            <?php foreach ($genres as $genre): ?>
                                <option value="<?= $genre['id'] ?>"
                                    <?= isset($item['genre_id']) && $item['genre_id'] == $genre['id']
                                        ? "selected"
                                        : ""; ?>>
                                    <?= isLangSet() && $genre['translated_name'] ? $genre['translated_name'] : $genre['name'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="format"><?= gettext("Format") ?></label>
                    </th>
                    <td>
                        <?php $format = isset($item['format']) ? $item['format'] : null; ?>
                        <select id="format" name="format" data-placeholder="<?= gettext("Select One") ?>" class="chosen-select">
                            <option value=""><?= gettext("None") ?></option>
                            <option value="Cassette" <?= $format == "Cassette" ? "selected" : ""; ?>><?= gettext("Cassette") ?></option>
                            <option value="CD" <?= $format == "CD" ? "selected" : ""; ?>>CD</option>
                            <option value="MP3" <?= $format == "MP3" ? "selected" : ""; ?>>MP3</option>
                            <option value="Vinyl" <?= $format == "Vinyl" ? "selected" : ""; ?>><?= gettext("Vinyl") ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="artist"><?= gettext("Artist") ?> <span class="required">(<?= gettext("required") ?>)</span></label>
                    </th>
                    <td>
                        <select id="artist" name="artist" data-placeholder="<?= gettext("Select One") ?>" class="chosen-select">
                            <?php foreach ($artists as $artist): ?>
                                <option value="<?= $artist['id'] ?>"
                                    <?= isset($item['artist_id']) && $item['artist_id'] == $artist['id']
                                        ? "selected"
                                        : ""; ?>>
                                    <?= $artist['name'] . ' ' . $artist['surname'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
            </table>
            <input type="submit" value="<?= isset($item) ? gettext('Update') : gettext('Create') ?>">
        </form>
    </div>
</div>

<?php include("inc/footer.php"); ?>
