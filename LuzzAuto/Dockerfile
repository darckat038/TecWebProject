# Usa l'immagine ufficiale di PHP con Apache
FROM php:8.2.26-apache

# Copia i file del progetto nella cartella di Apache
COPY . /var/www/html/

# Abilita il modulo di riscrittura di Apache
RUN a2enmod rewrite

# Espone la porta 80 (HTTP)
EXPOSE 80
