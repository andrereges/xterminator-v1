sudo cp xterminator.service /etc/systemd/system/xterminator.service

# Controla se o serviço iniciará no boot (chkconfig  on)
sudo systemctl enable xterminator.service
sudo systemctl disable xterminator.service

# Inicia ou para um serviço manualmente
sudo systemctl start xterminator
sudo systemctl stop xterminator
sudo systemctl status xterminator

# Restarting/reloading
sudo systemctl daemon-reload # Execute caso o arquivo .service foi alterado
sudo systemctl restart xterminator
sudo systemctl reload xterminator


Desistalar

sudo systemctl disable xterminator.service
sudo rm /etc/systemd/system/xterminator.service
sudo systemctl daemon-reload

****rm nano /etc/hosts

sudo service networking restart

