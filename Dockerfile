FROM ubuntu:20.04

WORKDIR /srv/app

# Install OS dependencies
RUN apt-get update && \
	DEBIAN_FRONTEND=noninteractive apt-get install -y software-properties-common git zip unzip && \
	add-apt-repository ppa:ondrej/php && \
	apt-get install -y php8.0 php8.0-mbstring php8.0-zip php8.0-dom php8.0-sqlite

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir=/usr/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
