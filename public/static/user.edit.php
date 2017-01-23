<?php

require_once __DIR__ . '/inc/helpers.php';

if (!isLogedIn()) {
    header('Location: /login');
}
if ($_SESSION['UserId'] != $userId && (!isAdmin() || !isSuperAdmin())) {
    header('Location: /user/' . $_SESSION['UserId'] . '/edit');
}

$pageTitle = gettext("Personal Media Library");
$pageTitle .= isset($title) ? ' | ' . $title : '';

$section = null;
$page = 'user';
$action = 'update';

include("inc/header.php");
?>
        <div class="section catalog random">
            <div class="wrapper">
                <h2><?= gettext('You can update personal data') ?></h2>
                <form>
                    <table>
                        <tr>
                            <th>
                                <label for="name"><?= gettext("Name") ?></label>
                            </th>
                            <td>
                                <input type="text" id="name" name="name" value="<?= $_SESSION['UserName'] ?>">
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
                                <input type="text" id="email" name="email" value="<?= $_SESSION['UserEmail'] ?>">
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
                    <input type="hidden" name="user" id="user" value="<?= $userId ?>">
                    <input type="submit" value="<?= gettext('Update data') ?>">
                </form>
            </div>
        </div>

<?php include("inc/footer.php"); ?>
