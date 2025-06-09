mysqldump -u your_user -p --no-data --skip-add-drop-table your_database | sed 's/^CREATE TABLE /CREATE TABLE IF NOT EXISTS /' > install.sql

