#!/bin/sh

# Iterate over environment variables and replace in file
env | while IFS= read -r line; do
  value=${line#*=}
  key="%-${line%%=*}-%"

  sed -i "s#$key#$value#g" /usr/share/nginx/html/main*js
done

# Start nginx server
nginx -g "daemon off;"