QUICK INSTALLATION GUIDE
------------------------

System requirements
-------------------
	- PHP 7.2.5 or later 
	- PostgreSQL 8+ or MySQL 5+
	- A web server for PHP version (Apache 2 is strongly recommended)


Installation
------------

		1) Copy the content of EvalCOMIX/ directory in your web server documents directory
		2) Make sure that the web server can write in: ./evalcomix/client/temp.
		3) Create a new, empty database (PostgreSql o MySQL) with UTF-8 codification.
		4) Go to the URL for your EvalCOMIX-FLOASS Server in a browser to start the installation wizard
		

Upgrading:
----------

Before upgrading, backup data:
- Source code of EvalCOMIX-FLOASS Server
- Database.

We advise that you test the upgrade first on a COPY of your production site, to make sure it works as you expect.


1) Move your old EvalCOMIX-FLOASS Server software program files to another location.
   Do NOT copy new files over the old files.
   
2) Unzip or unpack the upgrade file so that all the new EvalCOMIX-FLOASS Server software program files 
   are in the location the old files used to be in on the server.
   
3) Go to the URL for your EvalCOMIX-FLOASS Server in a browser. The wizard will ask you for the
    database connection data. They should be the same as the previous version of EvalCOMIX-FLOASS Server.
    EvalCOMIX-FLOASS Server will tune the database if the upgrade requires it. It will also ask you
    creating a new user.
   
4) Once the update is complete, access the control panel with the new user's credentials
    and add the LMS (Learning Management System) that will have permission to request the resources from
    this instance of EvalCOMIX-FLOASS Server.	


		
----------------------------------------------------------------------------------------------------
SPANISH
----------------------------------------------------------------------------------------------------
		
GUÍA DE INSTALACIÓN RÁPIDA
--------------------------

Requerimientos del sistema:
---------------------------
	- PHP 7.2.5 o superior
	- PostgreSQL 8+ o MySQL 5+
	- Cualquier servidor que soporte la versión requerida de PHP (se recomienda Apache 2+)


Instalación:
------------
		1) Copie el contenido de la carpeta Evalcomix/ donde pueda
ser accedido por el servidor Web.
		2) Asegúrese de que el servidor Web tiene permiso de
escritura en el directorio:
			-  ./evalcomix/client/temp
		3) Cree una base de datos vacía (PostgreSql o MySQL) para almacenar las 
tablas (codificación de caracteres: UTF-8) y un usuario con contraseña con los permisos adecuados para la
base de datos recién creada.
        	4) Acceda a través del navegador a la URL de EvalCOMIX-FLOASS Server para iniciar el asistente de instalación.


		
Actualización:
--------------

Antes de actualizar, haga un respaldo de los datos:
- Código fuente de EvalCOMIX-FLOASS Server
- Base de datos.

Se recomienda encarecidamente que pruebe la actualización en una COPIA de su sitio en producción
para asegurarse de que funciona como espera.


1) Mueva sus archivos antiguos de EvalCOMIX-FLOASS Server hacia otra localización.
   NO COPIE y PEGUE los archivos nuevos encima de los antiguos.
   
2) Descomprima el archivo de instalación, de forma que todos los archivos de EvalCOMIX-FLOASS Server
   estén ahora en el mismo sitio donde ANTES estaban los archivos de la versión anterior de EvalCOMIX-FLOASS Server.
   
3) Acceda a través del navegador a la URL de EvalCOMIX-FLOASS Server. El asistente le solicitará los 
   datos de conexión de la base de datos. Deberán ser los mismos que los de la versión anterior de EvalCOMIX-FLOASS Server.
   EvalCOMIX-FLOASS Server ajustará la base de datos si así lo requiere la actualización. También le solicitará
   la creación de un nuevo usuario.
   
4) Una vez completada la actualización, acceda al panel de control con las credenciales del nuevo usuario
   y añada los LMS (Learning Management System) que tendrán permiso para solicitar los recursos de
   esta instancia de EvalCOMIX-FLOASS Server.
		

