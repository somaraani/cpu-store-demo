### STAGE 1: Build ###
FROM node:12.22-alpine AS build
WORKDIR /usr/src/app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

### STAGE 2: Run ###
FROM nginx:1.17.1-alpine

# Copy entry script
COPY deployment/entrypoint.sh /entrypoint.sh

# Copy built project
COPY --from=build /usr/src/app/dist/client /usr/share/nginx/html

# Run entrypoint script
RUN chmod +x /entrypoint.sh
CMD /bin/sh ./entrypoint.sh