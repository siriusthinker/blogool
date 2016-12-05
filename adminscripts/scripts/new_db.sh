#!/bin/sh

MYSQL_USERNAME=root
MYSQL_PASSWORD=TLPxtdZqboRh

NEW_DB_NAME=blogool
NEW_DB_USERNAME=${NEW_DB_NAME}
NEW_DB_PASSWORD=TLPxtdZqboRh

mysql -u ${MYSQL_USERNAME} --password="${MYSQL_PASSWORD}" <<ENDOFSQL 
-- Create the database
create database ${NEW_DB_NAME};
--
-- grant permission to login from localhost
grant usage on *.* to '${NEW_DB_USERNAME}'@'localhost' identified by '${NEW_DB_PASSWORD}';
exit
ENDOFSQL
