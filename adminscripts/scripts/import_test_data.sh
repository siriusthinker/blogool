#!/bin/sh
#
# import the database in the order expected
# this assumes that the database schema is already created
# define the variable, this is expected to be from the cli argument
DB_NAME=$1
DB_USER=$2
DB_PASS=$3
#
# verify the expected arguments are non-empty
if [[ -z $DB_NAME ]]
then
	echo database name is empty
	exit 0
fi
#
if [[ -z $DB_USER ]]
then
	echo username is empty
	exit 0
fi
#
if [[ -z $DB_PASS ]]
then
	echo password is empty
	exit 0
fi
#
# navigate to the script directory
cd "`dirname "$0"`"
#
#
# start importing the schema and control data
#
mysql -u $DB_USER --password=$DB_PASS $DB_NAME < ../../database/test_data/users.sql
mysql -u $DB_USER --password=$DB_PASS $DB_NAME < ../../database/test_data/posts2.sql

