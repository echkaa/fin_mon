FROM node:16-alpine

ENV NODE_ENV=production

WORKDIR /var/www/kava_project_node

COPY ["./source/package.json", "./source/package-lock.json*", "./"]

RUN npm install --production

COPY ./source ./

RUN ls ./src -l

CMD [ "node", "./src/server.js" ]
