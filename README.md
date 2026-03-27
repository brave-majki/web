basic install ubuntu based
```
sudo apt update -y ; sudo apt upgrade -y
sudo apt install xampp
```
basic install arch(btw) based
```
sudo pacman -Syu # optional if it breaks your system
```
```
paru -S xampp
```
    or
```
yay -S xampp
```

```
sudo /opt/lampp/xampp startapache
sudo /opt/lampp/xampp startmysql
```
database
```
mysql -u root < bank.sql
rm bank.sql
```
now you just have to run the site
