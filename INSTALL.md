# Installation de 4sucres (serveur de production)

Guide testé et fonctionnel sur Ubuntu 18.04

## Installation des paquets

```bash
apt update && apt upgrade
apt install \
    curl git wget zip unzip htop sl \
    apache2 php7.2 libapache2-mod-php \
    php7.2-bcmath php7.2-cli php7.2-common php7.2-curl php7.2-fpm php7.2-gd php7.2-gmp php7.2-intl php7.2-json php7.2-mbstring php7.2-mysql php7.2-opcache php7.2-pgsql php7.2-readline php7.2-xml php7.2-zip php7.2-imagick \
    redis supervisor \
    -y
```

## Installation de Composer

```bash
wget https://getcomposer.org/download/1.9.0/composer.phar
mv composer.phar /usr/bin/composer
composer self-update
composer global require hirak/prestissimo
```

## Installation de NodeJS, yarn et npm

```bash
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
apt update
apt install yarn npm -y
```

## Installation de MySQL

⚠️ Remplacer `MYSQL_PASSWORD` par le mot de passe MySQL de l'utilisateur 4sucres

```bash
apt install mysql-server -y
mysql_secure_installation
mysql --execute="create database 4sucres;"
mysql --execute="create user '4sucres'@'localhost' identified by 'MYSQL_PASSWORD';"
mysql --execute="grant all privileges on 4sucres.* to 4sucres@localhost;"
mysql --execute="flush privileges;"
```

## Configuration d'Apache

```bash
cd /etc/apache2/sites-available
nano 4sucres.conf
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
mkdir /var/log/apache2/4sucres
a2enmod rewrite
a2ensite 4sucres
a2dissite 000-default
apachectl restart
```

## Installation de 4sucres

```bash
mkdir /var/www/4sucres
git clone https://github.com/4sucres/board /var/www/4sucres/current
cd /var/www/4sucres/current
cp .env.example .env
composer install
yarn
yarn prod
php artisan key:generate
```

⚠️ Configurer le fichier .env

```bash
nano .env
```

- Le `CACHE_DRIVER` doit obligatoirement être `redis` ou `memcached` (support des tags)
- Ne pas oublier de définir `APP_URL` (utilisé au sein de l'application)

```bash
php artisan migrate --seed
php artisan storage:link
chmod 777 -R storage bootstrap/cache
php artisan cache:rebuild emoji
```

Il est également possible de mettre en cache la configuration et les routes pour réduire le temps de chargement. Cette commande est déconseillée au sein d'un environnement de développement.

```bash
php artisan optimize
```

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
crontab -e
```

```
* * * * * cd /var/www/4sucres/current && php artisan schedule:run >> /dev/null 2>&1
```
