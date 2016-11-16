#!/bin/bash

# Migrations Data
php app/console doctrine:migrations:diff
echo -e "Data was diff successfully."

# Migrations Migrate
php app/console doctrine:migrations:migrate -n
echo -e "Data was migrate successfully."