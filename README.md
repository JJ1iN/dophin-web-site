# Dolphin Board

This site is basic web board site.

## Server Settings
Based [Oracle VM Instance](https://www.oracle.com/kr/cloud/compute/virtual-machines/), Ubuntu-20.04

### Access
'''
ssh -v -i {_Secret_Key_Path_} ubuntu@144.24.77.217
'''

### Package Install
Apache2, PHP, MySQL
'''
sudo apt-get update
sudo apt-get install -y mysql-server
sudo apt-get install -y apache2
sudo apt-get install -y php php-mysql
sudo service apache2 start
'''

### Iptables Settings in Linux(Firewall) (Port 80)
'''
sudo iptables -I INPUT 1 -p tcp --dport 80 -j ACCEPT
sudo iptables -I INPUT 1 -p tcp --dport 80 -j DROP
'''

### MySQL
'''
sudo mysql -u root
'''

