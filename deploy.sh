#!/bin/bash

DEPLOY_PATH="$ENV_PATH/php/phplib"

OUTPUT_DIR="output"
PRODUCT="phpfetcher"
OUTPUT_FILE="$PRODUCT.tar.gz"

mkdir -p $OUTPUT_DIR
rm -rf $OUTPUT_DIR/*
cp -rf Phpfetcher phpfetcher.php $OUTPUT_DIR/

cd $OUTPUT_DIR
find ./ -name .git -exec rm -rf {} \;
tar zcvf $OUTPUT_FILE ./*

rm -rf Phpfetcher phpfetcher.php

cp $OUTPUT_FILE $DEPLOY_PATH/
cd $DEPLOY_PATH
tar zxvf $OUTPUT_FILE
