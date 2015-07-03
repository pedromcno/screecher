mysql -uroot -e "drop database if exists screecher"
mysqladmin -uroot create screecher
mysql -uroot screecher < /var/www/app/db_dump.sql
rm -rf /var/www/app/cache/*