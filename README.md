basic install
```
sudo apt update -y ; sudo apt upgrade -y
sudo apt install xampp
sudo /opt/lampp/xampp startapache
sudo /opt/lampp/xampp startmysql
```
database
```
mysql -u root < bank.sql
rm bank.sql
```
now you just have to run the site
