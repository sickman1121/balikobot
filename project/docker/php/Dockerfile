FROM php:8.3.14-fpm-alpine3.20

WORKDIR /var/www

COPY --from=mlocati/php-extension-installer:2.6.4 /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=sha512man/whalesome:v2.1.1 /opt/whalesome /opt/whalesome

RUN mv /opt/whalesome/bin/* /usr/local/bin \
    && whls install php/fpm

RUN echo "Installing composer" \
    && install-php-extensions \
      @composer-2.8.3

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
