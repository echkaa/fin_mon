FROM node:16-alpine AS deps

WORKDIR /app

COPY source/package*.json* ./

RUN \
    if [ -f package-lock.json ]; then npm i; \
    else echo "Lockfile not found." && exit 1; \
    fi


FROM node:16-alpine

WORKDIR /var/www/kava_project_front
VOLUME /var/www/kava_project_front

COPY --from=deps /app/node_modules ./node_modules
COPY source ./

RUN npm run build

CMD ["npm", "run", "start"]
