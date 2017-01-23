<?php

require_once __DIR__ . '/inc/helpers.php';

if (isLogedIn()) {
    header('Location: /');
}


$pageTitle = gettext("Personal Media Library");
$pageTitle .= isset($title) ? ' | ' . $title : '';

$section = null;
$page = 'library';
$action = 'register';

if (!isset($items)) $items = [];

include("inc/header.php");
?>
        <div class="section catalog random">
            <div class="wrapper">
                <h2><?= gettext('Register new user') ?></h2>
                <form>
                    <table>
                        <tr>
                            <th>
                                <label for="name"><?= gettext("Name") ?></label>
                            </th>
                            <td>
                                <input type="text" id="name" name="name">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="email">
                                    <?= gettext("Email") ?>
                                    <span class="required">(<?= gettext("required") ?>)</span>
                                </label>
                            </th>
                            <td>
                                <input type="text" id="email" name="email">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="password">
                                    <?= gettext("Password") ?>
                                    <span class="required">(<?= gettext("required") ?>)</span>
                                </label>
                            </th>
                            <td>
                                <input type="password" id="password" name="password">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="password_repeat">
                                    <?= gettext("Repeat Password") ?>
                                    <span class="required">(<?= gettext("required") ?>)</span>
                                </label>
                            </th>
                            <td>
                                <input type="password" id="password_repeat" name="password_repeat">
                            </td>
                        </tr>
                    </table>
                    <?php // TODO: Implement CSRF token protection ?>
                    <input type="submit" value="<?= gettext('Register') ?>">
                    <p class="text-center">
                        <a href="/login"><?= gettext('If you already have an account, you can sign in here') ?></a>
                    </p>
                </form>
            </div>
        </div>

<?php include("inc/footer.php"); ?>
