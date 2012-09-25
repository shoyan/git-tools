<?php
/**
 * 指定されたコミットから変更されたファイル一覧を作成します 
 *
 * [注意点]
 * 見たいコミットの1個前を指定してください
 * 例えば以下のような履歴があったとします。
 *
 * commit02
 * commit01
 * commit00
 *
 * commit01からの変更が見たい場合は、commit00を指定してください
 * commit01を指定すると、commit02からの変更しか見れません。
 * これは git logが指定された次のコミットから表示するようになっているからです。
 *
 * SYNOPSIS
 * php git-log-change-file.php [commit]
 * php git-log-change-file.php [tagname]
 *
 * EXAMPLE
 * php git-log-change-file.php 36316..
 * php git-log-change-file.php v1.0..
 */

$command = "git log --name-status " . $argv[1] . "..";
$content = shell_exec($command);

$filename = 'git-log-change-file.txt';

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
$lines = file('git-log-change-file.txt');

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

unlink('git-log-change-file.txt');

?>
