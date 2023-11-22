FROM node:lts AS runtime
WORKDIR /business

COPY . .

RUN npm ci
RUN npm run build

ENV HOST=0.0.0.0
ENV PORT=4321
EXPOSE 4321
CMD ["node","build/index.js"]