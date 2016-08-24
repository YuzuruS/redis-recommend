#!/bin/bash
# install phpredis extension.

set -e



major_version=`php -v | head -n 1 | cut -c 5`
if [ $major_version == "7" ]
then
  git clone --branch=php7 https://github.com/phpredis/phpredis
else
  git clone https://github.com/phpredis/phpredis
fi

cd phpredis
phpize
./configure
make
sudo make install

echo "extension=redis.so" > redis.ini
phpenv config-add redis.ini

