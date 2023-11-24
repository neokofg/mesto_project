FROM golang:1.21 as builder
WORKDIR /panorama
COPY go.mod ./
COPY go.sum ./
RUN go mod download
COPY . .
COPY frontend/dist /panorama/frontend/dist
RUN CGO_ENABLED=0 GOOS=linux go build -v -a -installsuffix cgo -o app .
FROM scratch
COPY --from=builder /panorama/app .
COPY --from=builder /panorama/frontend/dist /panorama/frontend/dist
EXPOSE 3000
ENTRYPOINT ["./app"]