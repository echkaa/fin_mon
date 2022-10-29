FROM node:16-alpine AS deps

WORKDIR /node_app

COPY ./source/package*.json* ./

RUN \
    if [ -f package-lock.json ]; then npm i; \
    else echo "Lockfile not found." && exit 1; \
    fi


FROM node:16-alpine

WORKDIR /var/www/kava_project_node

COPY --from=deps /node_app/node_modules ./node_modules
COPY ./source ./

CMD [ "node", "./src/server.js" ]
