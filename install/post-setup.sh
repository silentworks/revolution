#!/usr/bin/env bash

TARGET=./vendor

find $TARGET | grep docs | xargs rm -rf
find $TARGET | grep tests | xargs rm -rf
find $TARGET | grep test | xargs rm -rf
find $TARGET | grep ext | xargs rm -rf
find $TARGET | grep .git | xargs rm -rf
find $TARGET | grep README\* | xargs rm -rf
find $TARGET | grep CONTRIBUTING.md | xargs rm -rf
find $TARGET | grep phpunit.xml* | xargs rm -rf
find $TARGET | grep .yml\* | xargs rm -rf
find $TARGET | grep .xml\* | xargs rm -rf
find $TARGET | grep .gitignore | xargs rm -rf