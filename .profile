# add vendor binaries to the path
export PATH=$PATH:$HOME/vendor/bin


# set a default LANG if it does not exist in the environment
export LANG=${LANG:-es_MX.UTF-8}

web: vendor/bin/heroku-php-apache2 /public