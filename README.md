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
paru -S xampp || yay -S xampp
```

```
sudo /opt/lampp/xampp startapache
sudo /opt/lampp/xampp startmysql
```
database and other setup 
```
mysql -u root < bank.sql
rm bank.sql
sudo mv -t /opt/lampp/htdocs/ ./*
```
now you just have to run the site
and on the victim machine you have to add your ip to the etc/host
it is located in ``` C:\Windows\System32\drivers\etc\hosts``` 
you have to write the ip of the host machine an example:
```
# /etc/hosts
10.0.21.17 www.bank.com bank.com
```
