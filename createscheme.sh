mysqldump -u your_user -p --no-data your_database_name \
  | sed 's/^CREATE TABLE /CREATE TABLE IF NOT EXISTS /' > install.sql

