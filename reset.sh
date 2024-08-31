#!/bin/bash


echo "Buscando Atualizações..."

git pull

sleep 5

php artisan migrate:fresh --seed

echo "Feito!"



