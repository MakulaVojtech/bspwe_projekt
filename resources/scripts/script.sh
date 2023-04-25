#!/bin/bash

# Zkontroluj, zda byl zadán argument
if [ -z "$1" ]
then
    echo "Musíte zadat název domény jako argument."
    exit 1
fi

# Název domény
domain="$1"

# Cesta k adresáři webového obsahu
webroot="/opt/lampp/htdocs/$domain"

# Vytvoření adresáře pro doménu
mkdir -p "$webroot"

# Náhodné heslo pro FTP uživatele
# $(openssl rand -base64 6)
ftp_password="123"

# Vytvoření FTP uživatele
useradd -d $webroot -s /bin/bash $domain
chown -R $domain $webroot
chmod -R 755 $webroot
echo "$domain:$ftp_password" | chpasswd

# Přidání záznamu domény do hosts souboru
echo "127.0.0.1 $domain" >> /etc/hosts

# Vytvoření virtuálního hosta v Apache
cat << EOF >> /opt/lampp/etc/extra/httpd-vhosts.conf
<VirtualHost *:80>
    ServerName $domain
    DocumentRoot $webroot
    <Directory $webroot>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF

sudo /opt/lampp/lampp restartapache

echo "Jméno: $domain" > soubor.txt
echo "Adresa: $ftp_password" >> soubor.txt


#DATABAZE*******************************************

# Nastavení přihlašovacích údajů pro MySQL
MYSQL_USER="root"
MYSQL_PASSWORD="password"

# Nastavení názvu nové databáze a uživatele
NEW_DB_NAME=$domain"_db"
NEW_DB_USER=$domain
NEW_DB_PASSWORD=$ftp_password

/opt/lampp/bin/mysql -u $MYSQL_USER -p$MYSQL_PASSWORD << EOF

# Vytvoření nové databáze
CREATE DATABASE $NEW_DB_NAME;

# Vytvoření nového uživatele a přidání přístupových práv k nové databázi
CREATE USER '$NEW_DB_USER'@'localhost' IDENTIFIED BY '$NEW_DB_PASSWORD';
GRANT ALL PRIVILEGES ON $NEW_DB_NAME.* TO '$NEW_DB_USER'@'localhost';

EOF

echo "db_user: $NEW_DB_USER" >> soubor.txt
echo "db_pass: $NEW_DB_PASSWORD" >> soubor.txt
echo "db_name: $NEW_DB_NAME" >> soubor.txt

echo $domain
echo $ftp_password
echo $NEW_DB_NAME
echo $NEW_DB_USER
echo $NEW_DB_PASSWORD
