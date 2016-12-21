<?php

$pageTitle = "Personal Media Library";
$pageTitle .= isset($title) ? ' | ' . $title : '';

$section = null;

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
        <form>
            <table>
                <tr>
                    <th>
                        <label for="title">Title <span class="required">(required)</span></label>
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
                        <label for="year">Year <span class="required">(required)</span></label>
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
                        <label for="genres">Genre <span class="required">(required)</span></label>
                    </th>
                    <td>
                        <select id="genres" name="genres" data-placeholder="Select One" class="chosen-select">
                            <?php foreach ($genres as $genre): ?>
                                <option value="<?= $genre['id'] ?>"
                                    <?= isset($item['genre_id']) && $item['genre_id'] == $genre['id']
                                        ? "selected"
                                        : ""; ?>>
                                    <?= $genre['name'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="format">Format</label>
                    </th>
                    <td>
                        <?php $format = isset($item['format']) ? $item['format'] : null; ?>
                        <select id="format" name="format" data-placeholder="Select One" class="chosen-select">
                            <option value="DVD" <?= $format == "DVD" ? "selected" : ""; ?>>DVD</option>
                            <option value="Blu-Ray" <?= $format == "Blu-Ray" ? "selected" : ""; ?>>Blu-Ray</option>
                            <option value="VHS" <?= $format == "VHS" ? "selected" : ""; ?>>VHS</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="director">Director <span class="required">(required)</span></label>
                    </th>
                    <td>
                        <select id="director" name="director" data-placeholder="Select One" class="chosen-select">
                            <?php foreach ($directors as $director): ?>
                                <option value="<?= $director['id'] ?>"
                                    <?= isset($item['director_id']) && $item['director_id'] == $director['id']
                                        ? "selected"
                                        : ""; ?>>
                                    <?= $director['name'] . ' ' . $director['surname'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="casts">Casts</label>
                    </th>
                    <td>
                        <select id="casts" name="casts" multiple data-placeholder="Select Stars" class="chosen-select">
                            <?php foreach ($stars as $star): ?>
                                <option value="<?= $star['id'] ?>"
                                    <?= isset($item['cast_ids']) && in_array($star['id'], $item['cast_ids'])
                                        ? "selected"
                                        : ""; ?>>
                                    <?= $star['name'] . ' ' . $star['surname'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
            </table>
            <input type="submit" value="Create">
        </form>
    </div>
</div>

<script type="text/javascript">
    $('#genres').chosen({width: '100%'});
    $('#format').chosen({width: '100%'});
    $('#director').chosen({width: '100%'});
    $('#casts').chosen({width: '100%'});
</script>

<?php include("inc/footer.php"); ?>
