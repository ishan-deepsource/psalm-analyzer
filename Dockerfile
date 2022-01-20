FROM alpine:3.14

RUN apk update && apk add --no-cache make && rm -rf /var/cache/apk/*

RUN mkdir -p /app /toolbox /macro

COPY . /macro

WORKDIR /macro

RUN cd /macro/.deepsource/analyzer && make build
