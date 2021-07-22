#!/bin/sh

# Iterate over environment variables and replace in file
env | while IFS= read -r line; do
  value=${line#*=}
  key="%-${line%%=*}-%"

  sed -i "s#$key#$value#g" /var/www/html/System/Config.php
done

# Start apache server
apache2-foreground