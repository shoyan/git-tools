#!/bin/sh

#
# 指定されたコミットから変更されたファイル一覧を作成します 
#
# SYNOPSIS
# show-change-file.sh [commit]
#
# EXAMPLE
# show-change-file.sh 36316
#
git log $1^..HEAD --name-status | grep -E "^[^ ]+$" | sort | uniq
