FROM alpine:3.14

RUN echo "https://dl-cdn.alpinelinux.org/alpine/v3.14/main" >/etc/apk/repositories
RUN echo "https://dl-cdn.alpinelinux.org/alpine/v3.14/community" >>/etc/apk/repositories
RUN apk update
RUN apk add bash curl git grep make

RUN mkdir /app /code /macrocode /marvin /artifacts /macroartifacts /config /secret /toolbox

COPY . /macrocode

WORKDIR /macrocode

RUN cd .deepsource/analyzer && make build
