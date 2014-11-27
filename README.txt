GUÍA DE INSTALACIÓN RÁPIDA
--------------------------

Requerimientos del sistema:
---------------------------
	- PHP 5.0+
	- PostgreSQL 8+ o MySQL 5
	- Cualquier servidor que soporte la versión requerida de PHP (se recomienda Apache 2+)


Instalación:
------------
		1)       Copie el contenido de la carpeta Evalcomix/ donde pueda
ser accedido por el servidor Web.
		2)       Asegúrese de que el servidor Web tiene permiso de
escritura en los directorios:
				-  ./evalcomix/client/temp
		3)       Cree una base de datos (PostgreSql o MySQL) para almacenar las 
tablas (codificación de caracteres: UTF-8)
		4)       Ejecute, en la base de datos creada en el paso anterior, las órdenes SQL que se encuentran en el fichero ./evalcomix/db/db_mysql.sql o
./evalcomix/db/db_postgres.sql" según corresponda.
		5)      Modifique el nombre de /configuration/conf.php.sample por /configuration/conf.php 
		6)      Modifique el nombre de /configuration/host.php.sample por /configuration/host.php
		7)		Edite el fichero /configuration/conf.php con los valores
  usados en la creación de la base de datos (nombre del servidor, usuario,
  contraseña y nombre de la base de datos)
		8)       Edite el fichero /configurationn/host.php con el nombre del
  servidor.

