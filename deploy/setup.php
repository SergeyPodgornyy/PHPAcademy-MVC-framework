#!/usr/bin/php

<?php

$options = getopt('fdthu', array('force', 'data', 'test', 'help', 'update'));

main($options);

function main($options) {
    if (isset($options['help']) || isset($options['h'])) help();

    $appConf = include_once __DIR__ . '/../etc/app-conf.php';
    $confInst = (isset($options['test']) || isset($options['t'])) ? 'test' : 'main';
    $dbConf = $appConf['dbConfig'][$confInst];

    if (isset($options['force']) || isset($options['f'])) {
        dropDB($dbConf['name'], $dbConf['user'], $dbConf['password']);
    }

    $data = (isset($options['data']) || isset($options['d'])) ? true : false;
    $noCreate = (isset($options['update']) || isset($options['u'])) ? true : false;

    createDB($dbConf['name'], $dbConf['user'], $dbConf['password'], $data, $confInst, $noCreate);
}

function createDB($dbname, $user, $pass, $data, $confInst, $noCreate) {
    if(!$noCreate) {
        print "Creating database $dbname...\n";

        $str = "mysql --user=$user " . ($pass ? "--password=$pass " : '') . " -e 'create database $dbname character set utf8 collate utf8_general_ci'";
        exec($str, $output, $return);

        if ($return) die("Database was not created\n");
    }

    print "Creating schema...\n";
    restore(__DIR__ . '/schema.sql', $dbname, $user, $pass);

    print "Alter schema...\n";
    restore(__DIR__ . '/alter.sql', $dbname, $user, $pass);

    if ($data) {
        print "Add tests data...\n";
        $file = $confInst == 'main' ? '/data.sql' : '/data.sql';
        restore(__DIR__ . $file, $dbname, $user, $pass);
    }

    print "Done\n";
}

function dropDB($dbname, $user, $pass) {
    print "Droping database $dbname...\n";

    $str = "mysql --user=$user " . ($pass ? "--password=$pass" : '') . " -e 'drop database if exists $dbname'";
    exec($str, $output, $return);

    if ($return) die("Database was not dropped\n");
}

function restore($file, $dbname, $user, $pass) {
    exec("mysql " . ($pass ? "-p$pass " : '') . "-u $user -D $dbname < $file", $output, $return);

    if ($return) die("Insert SQL file was not imported\n");
}

function help() {
    print <<<HELP

Generate SQL from schema.xml and create database.

Options:
    --help      - show this help
    --force     - recreate database if database exists
    --data      - insert test data
    --test      - create test database
    --update    - update database (no recreate)


HELP;

    exit();
}

?>
