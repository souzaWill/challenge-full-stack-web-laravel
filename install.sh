#composer install
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
#set env file
cp .env.example .env

#up containers
./vendor/bin/sail up -d --build

#key generate
./vendor/bin/sail artisan key:generate

#set vars
./vendor/bin/sail artisan optimize

#start database
./vendor/bin/sail artisan migrate --seed --force

