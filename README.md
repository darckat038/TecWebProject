# Progetto TecWeb 2024/2025 - LuzzAuto
Progetto del corso di Tecnologie Web della laurea in Informatica presso l'Università degli studi di Padova
## Il gruppo è composto da:
- Artusi Emanuele
- Bellon Filippo
- Diviesti Filippo
- Righetto Filippo
### Link utili:
- [Template esempio PIU' COMPLETO](https://themes.getbootstrap.com/preview/?theme_id=1719)
- [Template esempio Carvilla](https://demo.themesine.com/carvilla/)
- [WCAG22 Regole di accessibilità](https://www.w3.org/WAI/WCAG22/quickref/)
- 
### Strumenti utili
- [Checker contrasto immagine testo](https://imagecontrastchecker.com/)

### Info Utili Server
- Versione PHP Server Tecweb: 8.2.26
- Versione SQL Server: MariaDB 10.11.6

### Creazione del server in locale con docker
Nella cartella LuzzAuto:
Per eliminare i volumi associati se avete già un container errato:
```cmd
docker-compose down -v
```
```cmd
docker-compose build
```
```cmd
docker-compose up -d
```
