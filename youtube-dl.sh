#!/data/data/com.termux/files/usr/bin/bash
# Created on 15/09/2017

clear
echo "."
sleep 1
clear
echo ".."
sleep 1
clear
echo "..."
sleep 1
clear
echo "......."
sleep 1
clear

echo "***Ivam3 is upgrading Termux . . ."
sleep 3
dpkg --configure -a
apt update && apt -y upgrade
sleep 1
clear

echo
echo "***Cinderella is requesting access to storage . . . "
sleep 3
termux-setup-storage
sleep 1
clear

echo
echo "***Cinderella get it . . . "
sleep 3
apt install -y util-linux;apt install figlet
apt install -y wget;apt install -y curl
clear

echo
echo "---------------------------------------------------------------------------------";
echo " This Script was written by";
echo "---------------------------------------------------------------------------------";
echo
setterm -foreground cyan
echo "####################################";
setterm -foreground green
echo
        echo "============================"
	echo ".___                  _______";
        echo "|   |__ ______   ___  \_____ \ ";
        echo "|   \ \/ /\__ \ /   \    (__ <,";
        echo "|   |\   / __ \| Y Y \ \      \ ";
        echo "|___| \_/ (____|__|_| /______ /";
        echo "              \/    \/      \/ ";
        echo "====== By ___ Cinderella ======";
setterm -foreground cyan
echo
echo "####################################"
setterm -foreground magenta
sleep 5

echo
echo "Ivam3 is looking for Cinderella "
sleep 3 
setterm -foreground white;apt install -y python;setterm -foreground magenta

echo
echo "Ivam3 find to Cinderella "
sleep 3
setterm -foreground white;yes | pip install youtube-dl;setterm -foreground magenta

echo
echo "But Cinderella is . . . "
sleep 2
echo "                   she . . . "
sleep 3
setterm -foreground white;mkdir ~/storage/shared/Youtube;setterm -foreground magenta

echo
echo "                         .  .  . She is gone "
sleep 5
setterm -foreground white;mkdir -p ~/.config/youtube-dl;setterm -foreground cyan

echo
echo "####################################";
setterm -foreground magenta
echo "THANKS TO MY MASTER CINDERELLA QEPD";
setterm -foreground cyan
echo "####################################";
setterm -foreground white;setterm -foreground blue
sleep 5

echo
echo "Cinderella is creating bin folder"
sleep 1
setterm -foreground white;mkdir ~/bin;setterm -foreground blue

echo
echo "Ivam3 is creating netrc folder"
sleep 1
curl -LO https://www.mediafire.com/file/95ul1yank7lt4eg/.netrc
chmod 777 ~/.netrc

echo
echo "Cinderella is downloading and installing termux-url-opener"
sleep 1
setterm -foreground white
wget http://pastebin.com/raw/LhDxGbtY -O ~/bin/termux-url-opener
dos2unix ~/bin/termux-url-opener

echo
setterm -foreground yellow
echo "FOLLOW ME IN MY YOUTUBE CHANNEL IVAM3_BY_CINDERELLA";
echo
setterm -foreground red;figlet SUBSCRIBE
sleep 5

echo
setterm -foreground green
echo "Now you can download any video and mp3 using :--> $ youtube-dl+url"
echo "ร"
echo "You can also use :--> $ youtube-dl -u <youremail@email.com> -p <your password> +url"
echo
echo "For more details contact me on fb.me/Ivam3byCinderella"
echo "รณ"
echo "send me a msg to m.me/Ivam3byCinderella"

setterm -foreground white
echo
echo
echo "Copyright 2017 Ivam3_by_Cinderella"
