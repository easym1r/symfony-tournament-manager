# Используем последний образ NGINX
FROM nginx:latest

# Заменяем конфиги NGINX на наши собственные
COPY ./conf.d/ /etc/nginx/conf.d/

# Устанавливаем рабочую директорию
WORKDIR /var/www