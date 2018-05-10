#!/bin/sh

#########################################
# Make sure the backups directory exists
#########################################
mkdir -p /app/localStorage/;
mkdir -p /app/localStorage/dbBackups/;





###################################
# Backup Database
###################################

# Dump the database
mysqldump -usite -psecret site > /app/localStorage/dbBackups/site_latest_new.sql;

# Delete the previous DB dump
rm -f /app/localStorage/dbBackups/site_previous.sql;

# Rename the latest DB dump to previous DB dump
if [ -f "/app/localStorage/dbBackups/site_latest.sql" ] ; then
    mv /app/localStorage/dbBackups/site_latest.sql /app/localStorage/dbBackups/site_previous.sql;
fi

# Rename the new DB dump to latest DB dump
mv /app/localStorage/dbBackups/site_latest_new.sql /app/localStorage/dbBackups/site_latest.sql;
