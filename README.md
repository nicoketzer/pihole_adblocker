# PIHOLE Adblocker - Personal Blocking Page

## 1. Setup

### Install all Packets

#### Install Pi-Hole itself
apt-get update
apt-get upgrade
apt-get install curl
curl -sSL https://install.pi-hole.net | bash
#### Create all extra Dirs
mkdir /var/www/html/pihole
#### Copy Files in from Repo in Lokal System
#### Restart Pihole+Apache2+Nginx
systemctl restart pihole-FTL apache2 nginx
