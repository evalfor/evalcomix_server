QUICK INSTALLATION GUIDE
------------------------

System requirements
-------------------
	- PHP 5.0+
	- PostgreSQL 8+ or MySQL 5+
	- A web server for PHP 5.0+ (Apache 2 is strongly recommended)


Installation
------------

		1) Copy the content of EvalCOMIX/ directory in your web server documents directory
		2) Make sure that the web server can write in: ./evalcomix/client/temp.
		3) Create a new, empty database (PostgreSql o MySQL) with UTF-8 codification.
		4) Performance the suitable file of SQL orders. They are in:
			- ./evalcomix/db/db_mysql.sql
			- ./evalcomix/db/db_postgres.sql
		5) Rename ./evalcomix/configuration/conf.php.sample to ./evalcomix/configuration/conf.php
		6) Rename ./evalcomix/configuration/host.php.sample to ./evalcomix/configuration/host.php
		7) Edit ./evalcomix/configuration/conf.php with values of database (host name, user, password and database name)
		8) Edit ./evalcomix/configuration/host.php with name of the HOST.
		
		
		
----------------------------------------------------------------------------------------------------
SPANISH
----------------------------------------------------------------------------------------------------
		
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

