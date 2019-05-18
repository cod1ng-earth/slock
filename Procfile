release: cd api && bin/console doctrine:migrations:status && bin/console doctrine:migrations:migrate --no-interaction && bin/console hautelook:fixtures:load --append
web: cd api && vendor/bin/heroku-php-apache2 public/
