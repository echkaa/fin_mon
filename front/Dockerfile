FROM node:16

WORKDIR /var/www/kava_project_front

RUN npm install npm@latest -g

COPY . .

RUN npm install

EXPOSE 3000

# start app
CMD ["npm", "start"]
