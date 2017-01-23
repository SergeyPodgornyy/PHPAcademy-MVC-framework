<?php

require_once __DIR__ . '/inc/helpers.php';

if (!isSuperAdmin()) {
    header('Location: /books');
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
                        <label for="isbn">ISBN <span class="required">(<?= gettext("required") ?>)</span></label>
                    </th>
                    <td>
                        <input type="text"
                               id="isbn"
                               name="isbn"
                               <?= isset($item['isbn']) ? "value='{$item['isbn']}'" : ""; ?>>
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
                        <label for="authors"><?= gettext("Authors") ?> <span class="required">(<?= gettext("required") ?>)</span></label>
                    </th>
                    <td>
                        <select id="authors" name="authors" multiple data-placeholder="<?= gettext("Select authors") ?>" class="chosen-select">
                            <?php foreach ($authors as $author): ?>
                                <option value="<?= $author['id'] ?>"
                                    <?= isset($item['author_ids']) && in_array($author['id'], $item['author_ids'])
                                        ? "selected"
                                        : ""; ?>>
                                    <?= $author['name'] . ' ' . $author['surname'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="publisher"><?= gettext("Publisher") ?></label>
                    </th>
                    <td>
                        <select id="publisher" name="publisher" data-placeholder="<?= gettext("Select One") ?>" class="chosen-select">
                            <option value="">-</option>
                            <?php foreach ($publishers as $publisher): ?>
                                <option value="<?= $publisher['id'] ?>"
                                    <?= isset($item['publisher_id']) && $item['publisher_id'] == $publisher['id']
                                        ? "selected"
                                        : ""; ?>>
                                    <?= $publisher['name'] ?>
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
                            <option value=""><?= gettext('None') ?></option>
                            <option value="Paperback" <?= $format == "Paperback" ? "selected" : ""; ?>>
                                <?= gettext("Paperback") ?>
                            </option>
                            <option value="Hardcover" <?= $format == "Hardcover" ? "selected" : ""; ?>>
                                <?= gettext("Hardcover") ?>
                            </option>
                            <option value="Ebook" <?= $format == "Ebook" ? "selected" : ""; ?>>
                                <?= gettext("Ebook") ?>
                            </option>
                            <option value="Audio" <?= $format == "Audio" ? "selected" : ""; ?>>
                                <?= gettext("Audio") ?>
                            </option>
                        </select>
                    </td>
                </tr>
            </table>
            <input type="submit" value="<?= isset($item) ? gettext('Update') : gettext('Create') ?>">
        </form>
    </div>
</div>

<?php include("inc/footer.php"); ?>
