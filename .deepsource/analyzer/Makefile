build:
	cp -r ../../. /app
	# install required packages
	apk add --no-cache ca-certificates curl tar xz openssl wget
	# install PHP and required extensions
	apk add --no-cache php8
	apk add php8-curl php8-xml php8-dom php8-mbstring php8-tokenizer php8-openssl php8-phar
	ln -s /usr/bin/php8 /usr/bin/php
	# get psalm.phar file
	cd /toolbox && wget https://github.com/vimeo/psalm/releases/download/4.18.1/psalm.phar && chmod +x psalm.phar
	# setup macro
	cd /app && curl -s https://getcomposer.org/installer | php8 -- && php8 composer.phar install --no-interaction --no-dev --no-progress --optimize-autoloader && chmod +x bin/analyze
