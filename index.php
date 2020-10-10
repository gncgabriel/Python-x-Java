<?php
set_time_limit(0);
require_once __DIR__.'/search_repositories_github/search.php';

$token = "TOKEN DE ACESSO";

if (isset($argv[1])) {
    $token = $argv[1];
} else if (isset($_GET['token'])) {
    $token = $_GET['token'];
}


searchRepositories($token, __DIR__);