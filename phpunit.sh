#!/usr/bin/env bash

XDEBUG_PORT=9003
LISTENING=0
if [[ "$OSTYPE" == "linux-gnu"* ]]; then
    LISTENING=$(ss -l | grep ${XDEBUG_PORT} | wc -l)
elif [[ "$OSTYPE" == "darwin"* ]]; then
    LISTENING=$(netstat -ln | grep ${XDEBUG_PORT} | wc -l)
fi
XDEBUG_STR=""
if [[ "1" = "$LISTENING" ]]; then
    XDEBUG_STR="--env XDEBUG_TRIGGER=1 "
fi
docker-compose exec ${XDEBUG_STR} php phpunit $@
