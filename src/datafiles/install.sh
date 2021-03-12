#!/bin/sh

# sudo bash -c 'php -v'
# sudo bash -c 'apt-get update'
# sudo bash -c 'apt -y install software-properties-common'
# sudo bash -c 'add-apt-repository ppa:ondrej/php'
# sudo bash -c 'apt-get update'

# sudo bash -c 'apt-get -y install php'

# sudo groupadd docker
# sudo usermod -aG docker $USER
# sudo chmod 666 /var/run/docker.sock

if ! grep -q "127.0.0.1    xterminator.local" /etc/hosts; then
	sudo bash -c 'echo "" >> /etc/hosts'
	sudo bash -c 'echo "# Hosts Xterminator" >> /etc/hosts'
	sudo bash -c 'echo "127.0.0.1    xterminator.local" >> /etc/hosts'
	sudo bash -c 'echo "127.0.0.1    xterminator-api.local" >> /etc/hosts'
fi

sudo service networking restart

sudo cp /var/www/html/xterminator/src/datafiles/xterminator.service /etc/systemd/system/xterminator.service
sudo systemctl enable xterminator
sudo systemctl start xterminator
sudo systemctl daemon-reload
sudo systemctl restart xterminator

sudo chmod 777 /var/www/html/xterminator/src/datafiles/server.sh
sudo chmod 777 /etc/systemd/system/xterminator.service

google-chrome http://xterminator.local:28000/

echo "------------------------------------------------"
echo "-                                              -"
echo "-                                              -"
echo "- ***** Instalação efetuada com sucesso! ***** -"
echo "-                                              -"
echo "-                                              -"
echo "------------------------------------------------"
