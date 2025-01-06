FROM nginx:1.27.2-alpine3.20

COPY --from=sha512man/whalesome:v2.1.1 /opt/whalesome /opt/whalesome

RUN echo "Update apk repositories and packages" \
    && apk update \
    && apk upgrade \
    && apk cache clean

RUN mv /opt/whalesome/bin/* /usr/local/bin \
    && whls install nginx/fpm

ENTRYPOINT ["docker-entrypoint"]
CMD ["nginx"]