<?php

function isLangSet() {
    return isset($_SESSION['Lang']) ? true : false;
}

function getLanguage() {
    return isset($_SESSION['Lang']) ? $_SESSION['Lang'] : null;
}
