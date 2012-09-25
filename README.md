git-tools
=========

git tools

指定されたコミットから変更されたファイル一覧を作成します 

[注意点]
見たいコミットの1個前を指定してください

例えば以下のような履歴があったとします。


commit02

commit01

commit00

commit01からの変更が見たい場合は、commit00を指定してください

commit01を指定すると、commit02からの変更しか見れません。

これは git logが指定された次のコミットから表示するようになっているからです。

SYNOPSIS

php show-change-file.php [commit]

php show-change-file.php [tagname]


EXAMPLE

php show-change-file.php 36316..

php show-change-file.php v1.0..
