build:
	# install required packages
	apk add --no-cache ca-certificates curl tar xz openssl wget
	# install PHP and required extensions
	apk add --no-cache php8
	apk add php8-curl php8-xml php8-dom php8-mbstring php8-tokenizer
	# get psalm.phar file
	cd /toolbox
	wget https://github.com/vimeo/psalm/releases/download/4.18.1/psalm.phar
	chmod +x psalm.phar
	psalm.phar --version
	# setup macro
	cp -r ../../. /app
	cd /app
	chmod +x composer-setup.sh
	./composer-setup.sh
	php composer.phar install --no-interaction --no-dev --no-progress --optimize-autoloader
	chmod +x bin/analyze
