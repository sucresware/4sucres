# Installation de 4sucres (serveur de production)

Guide testé et fonctionnel sur Ubuntu 20.10

## Installation des paquets

```bash
sudo apt update && apt upgrade
sudo apt install \
    curl git wget zip unzip htop sl \
    apache2 php8.0 libapache2-mod-php \
    php8.0-bcmath php8.0-cli php8.0-common php8.0-curl php8.0-fpm php8.0-gd php8.0-gmp php8.0-intl php8.0-mbstring php8.0-mysql php8.0-opcache php8.0-pgsql php8.0-readline php8.0-xml php8.0-zip php8.0-imagick php8.0-redis \
    redis supervisor \
    -y
```

## Installation de Composer

```bash
sudo wget https://getcomposer.org/download/2.0.0/composer.phar
sudo chmod +x composer.phar
sudo mv composer.phar /usr/bin/composer
sudo composer self-update
```

## Installation de NodeJS, yarn et npm

```bash
sudo curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
sudo apt update
sudo apt install yarn npm -y
```

## Installation de MySQL

⚠️ Remplacer `MYSQL_PASSWORD` par le mot de passe MySQL de l'utilisateur 4sucres

```bash
sudo apt install mysql-server -y
sudo mysql_secure_installation
sudo mysql --execute="create database 4sucres;"
sudo mysql --execute="create user '4sucres'@'localhost' identified by 'MYSQL_PASSWORD';"
sudo mysql --execute="grant all privileges on 4sucres.* to 4sucres@localhost;"
sudo mysql --execute="flush privileges;"
```

## Configuration d'Apache

```bash
cd /etc/apache2/sites-available
sudo nano 4sucres.conf
```

```apache
<VirtualHost *:80>
  ServerAdmin contact@4sucres.org
  ServerName 4sucres.org
  ServerAlias www.4sucres.org

  DocumentRoot /var/www/4sucres/current/public

  <Directory /var/www/4sucres/current>
          AllowOverride All
  </Directory>

  ErrorLog /var/log/apache2/4sucres/error.log
  CustomLog /var/log/apache2/4sucres/access.log combined
</VirtualHost>
```

```bash
sudo mkdir /var/log/apache2/4sucres
sudo a2enmod rewrite
sudo a2ensite 4sucres
sudo a2dissite 000-default
sudo apachectl restart
```

⚠️ Si vous utilisez Cloudflare, vous pouvez installer et configurer `mod_remoteip` : [Installing mod_remoteip with Apache](https://support.cloudflare.com/hc/en-us/articles/360029696071)

## Installation de 4sucres

```bash
mkdir /var/www/4sucres
git clone https://github.com/4sucres/board /var/www/4sucres/current
cd /var/www/4sucres/current
cp .env.example .env
composer install --no-dev
yarn
yarn prod
php artisan key:generate
```

⚠️ Configurer le fichier .env

```bash
nano .env
```

- Le `CACHE_DRIVER` doit obligatoirement être `redis` ou `memcached` (support des tags)
- Ne pas oublier de définir `APP_URL`

```bash
php artisan migrate --seed
php artisan storage:link
chmod 777 -R storage bootstrap/cache
php artisan cache:rebuild emoji
```

Il est également possible de mettre en cache la configuration et les routes pour réduire le temps de chargement. Cette commande est déconseillée au sein d'un environnement de développement.

## Configuration de Supervisor

```bash
cd /etc/supervisor/conf.d/
nano 4sucres-worker.conf
```

```ini
[program:4sucres-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/4sucres/current/artisan queue:work --tries=3
autostart=true
autorestart=true
user=root
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/4sucres/storage/logs/worker.log
```

```bash
supervisorctl reread
supervisorctl update
supervisorctl start 4sucres-worker:*
```

## Ajout de la crontab

```bash
sudo crontab -e
```

```
* * * * * cd /var/www/4sucres/current && php artisan schedule:run >> /dev/null 2>&1
```
