#!/bin/sh

until nc -z -v -w30 ${MYSQL_HOST} ${MYSQL_PORT}
do
  echo "Waiting for database connection..."
  sleep 5
done

symfony serve --port=80