FROM nginx:latest

ADD ./nginx/default.conf /etc/nginx/config.d/default.conf

COPY public /var/www/public
