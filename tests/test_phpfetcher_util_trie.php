<?php
require_once('bootstrap.php');

use Phpfetcher\Util\Trie;

$test_include_path = dirname(__FILE__).'/../';
set_include_path(get_include_path().PATH_SEPARATOR.$test_include_path);


function print_trie(&$trie)
{
    echo "has ftp:".var_export($trie->has("ftp"), true)."\n";
    echo "has http:".var_export($trie->has("http"), true)."\n";
    echo "has https:".var_export($trie->has("https"), true)."\n";
    echo "\n";
}

$arrSchemes = [
    "http",
    "https",
    "ftp",
];
$trie = new Trie($arrSchemes);
print_trie($trie);

echo "delete 'abc'\n";
$trie->delete("abc");
print_trie($trie);

echo "delete 'ftp'\n";
$trie->delete("ftp");
print_trie($trie);

echo "delete 'http'\n";
$trie->delete("http");
print_trie($trie);

echo "insert 'ftp'\n";
$trie->insert("ftp");
print_trie($trie);

echo "delete 'https'\n";
$trie->delete("https");
print_trie($trie);

echo "insert 'http'\n";
$trie->insert("http");
print_trie($trie);
