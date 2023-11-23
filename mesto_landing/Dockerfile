FROM node:lts AS runtime
WORKDIR /landing

COPY . .

RUN npm install
RUN npm run build

ENV HOST=0.0.0.0
ENV PORT=3421
EXPOSE 3421
CMD node ./dist/server/entry.mjs