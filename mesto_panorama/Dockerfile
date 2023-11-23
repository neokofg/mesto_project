FROM golang:1.21 as builder
WORKDIR /panorama
COPY go.mod ./
COPY go.sum ./
RUN go mod download
COPY . .
RUN CGO_ENABLED=0 GOOS=linux go build -v -a -installsuffix cgo -o app .
FROM scratch
COPY --from=builder /panorama/app .
EXPOSE 8080
ENTRYPOINT ["./cmd/panorama/main"]