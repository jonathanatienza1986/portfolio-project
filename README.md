# Laravel13Vue3_template
Template for Laravel 13 + Vue3
Note: Run the CLI command in a Bash Shell like git bash shell

________________________________________________________

### Install Docker Desktop
[https://docs.docker.com/desktop/setup/install/windows-install/]

________________________________________________________

### Railway.com (Sign-in Using Github)

(Dashboard)[https://railway.com/project/b190df8f-22c6-4a45-b2cb-c5621c2c6d8a?]

(Webapp)[https://cebeco2.up.railway.app]

________________________________________________________

### Socialite OAuth 2.0 Login Dashboard Settings

(linkedin-openid)[https://www.linkedin.com/developers/apps/231546114/settings]

(google)[https://console.cloud.google.com/apis/credentials?project=cebeco2]

(facebook)[https://developers.facebook.com/apps/4192158944448283]

________________________________________________________

### Clone this project
```sh
git clone --recursive https://github.com/gc120978levelup1/Laravel13Vue3_template.git
```

________________________________________________________

### Limit Node RAM Usage
in package.json
```sh
    "scripts": {
        "dev2": "vite",
        "dev": "node --max-old-space-size=1024 ./node_modules/vite/bin/vite.js",
```

________________________________________________________

### Limit WSL RAM Usage
in c:/Users/garry/.wslconfig
```sh
[wsl2]
memory=1GB
processors=1
```

________________________________________________________
### Modify PhP.ini
```sh
upload_max_filesize = 512M
post_max_size = 512M
memory_limit = 512M
```

________________________________________________________

### Modify public/.htaccess
```sh
php_value upload_max_filesize 512M
php_value post_max_size 512M
```

________________________________________________________

### Run Docker Container Servers
Run Docker Desktop first before running the command below
```sh
cd Laravel13Vue3_template
docker ps -aq | xargs docker stop | xargs docker rm
docker system prune -f
cd Serverss
cp -r -a ./.env ../
./ss up
cd ..
```

________________________________________________________

### Install Project Dependencies, Fix Env Variable and Migrate
```sh
composer install
npm install
npm run build
composer require league/flysystem-aws-s3-v3 "^3.0" --with-all-dependencies
composer require laravel/wayfinder
php artisan key:generate
php artisan storage:link
php artisan migrate
```

________________________________________________________

### Launch Development Server
```sh
composer run dev
```

### Goto web browser and open site
[http://127.0.0.1:8000]

### All Done




