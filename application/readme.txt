1. CURL install
To test this application you have to install CURL.
By default this vagrant box goes without curl

http://askubuntu.com/questions/9293/how-do-i-install-curl-in-php5

Go inside vagrant and run:
sudo apt-get update
sudo apt-get install php5-curl
sudo service apache2 restart
sudo service php5-fpm restart

2. DB set up

Go inside vagrant by ssh and run:
cd /var/www
bash app/shell/init.sh

3. Unit tests

If you want to run unit tests go inside vagrant by ssh and run:
cd /var/www
vendor/bin/phpunit









