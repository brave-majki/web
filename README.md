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
you will have to start the apache services every single time
```
sudo /opt/lampp/xampp startapache
sudo /opt/lampp/xampp startmysql
```
you can put things in a alias and do something like this:

```
web='sudo /opt/lampp/xampp startapache && sudo /opt/lampp/xampp startmysql'
```

Windows install xampp for windows
```
https://www.apachefriends.org/download.html
```
open ```C:\xampp\htdocs```
and paste all the files into htdocs then open xampp pannel
start mysql and apache

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
