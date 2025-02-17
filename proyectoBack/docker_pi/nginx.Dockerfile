FROM nginx:latest
COPY docker_pi/nginx/nginx.conf /etc/nginx/conf.d/default.conf
