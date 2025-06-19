# Sistema Web de Control de Inventarios
Este sistema web es una aplicación web desarrollada para administrar el inventario de un almacén de la empresa solicitada. Cuenta con 5 tipos de usuarios: Administrador, Usuario, almacenista, directivo y programador. Cada usuario tiene sus propias funciones y privilegios para realizar diferentes tareas en el sistema. 

## Funcionalidades
- Registro de usuarios.
- Registro de cuenta.
- Registro de regiones.
- Registro de productos.
- Registro de entrada de productos.
- Registro de Inventario.
- Registro de Borradores de requisiciones.
- Registro de requisiciones.
- Registro de salida de requisiciones.
- Envío de correos electrónicos de notificaciones de requisiciones.
- Generación de archivos PDF.
- Generación de archivos Excel.
- Visualización de gráficos de requisiciones y entradas por dia, por usuario, por autorización.
- Respaldo y restauración de bases de datos.

## Lenguajes de programación y Librerías usadas: 
- PHP
- MySQL
- HTML
- CSS
- JavaScript
- Bootstrap
- SweetAlert
- AJAX
- Git
- XAMPP
- Composer
- PHPMailer
- PhpSpreadsheet
- TCPDF

## Instalación Local
1. Descargar el proyecto desde el repositorio.
2. Usa XAMPP, prender los servicios de XAMPP (Apache y MySQL).
3. Crea una base de datos en MySQL con el nombre "grupova9_Pryse" o otro nombre. (http://localhost/phpmyadmin)
4. Ejecutar el archivo "Backup.sql" para crear las tablas necesarias.
5. Configurar el archivo "Conexion.php" con los datos de la base de datos.
6. Mete el proyecto en la carpeta "htdocs" de XAMPP.
7. Acceder al proyecto desde un navegador web. (http://localhost/almacen.grupopryse.mx)

## Instalar en Servidor en linea
1. Crear una base de datos en MySQL con el nombre "grupova9_Pryse".
2. Ejecutar el archivo "Backup.sql" para crear las tablas necesarias.
3. Configurar el archivo "Conexion.php" con los datos de la base de datos.
4. Subir el proyecto a un servidor en línea.