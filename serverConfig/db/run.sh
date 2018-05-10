#!/usr/bin/env bash

sudo service cron start

mysqld --innodb-flush-method=littlesync --innodb-use-native-aio=OFF --log_bin=ON
