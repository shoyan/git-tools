<?php
/**
 * 指定されたコミットから変更されたファイル一覧を作成します 
 *
 * SYNOPSIS
 * php show-change-file.php [commit]
 *
 * EXAMPLE
 * php show-change-file.php 36316
 */

$command = "git log --name-status " . $argv[1] . "^..";
$content = shell_exec($command);

$filename = 'show-change-file.txt';

if (!$handle = fopen($filename, 'w+')) {
    echo "Cannot open file ($filename)";
    exit;
}

if (fwrite($handle, $content) === FALSE) {
    echo "Cannot write to file ($filename)";
    exit;
}


fclose($handle);

$stack = array();
$lines = file('show-change-file.txt');

foreach ($lines as $line_num => $string) {

    $pattern = '/commit .+/';
    if (preg_match($pattern, $string)) {
        $string = '';
    }

    $pattern = '/Author:.+/i';
    if (preg_match($pattern, $string)) {
        $string = '';
    }

    $pattern = '/Date:.+/i';
    if (preg_match($pattern, $string)) {
        $string = '';
    }

    $pattern = '/    .+/i';
    if (preg_match($pattern, $string)) {
        $string = '';
    }

    $pattern = '/Merge:.+/i';
    if (preg_match($pattern, $string)) {
        $string = '';
    }

    if (!empty($string)) {
        $stack[] = $string;
    }
}
sort($stack);
$stack = array_unique($stack);
foreach ($stack as $line) {
    echo $line;
}

unlink('show-change-file.txt');

?>
