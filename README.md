# blog_system
This is an open source blog system, with SEO and social media management menus.  

If you would like to use this blog system, you should upload this files into a web hosting, 
and make a database. 
The config.json file allows you to manage the db connection.
dbType: The type of the database server, for example MySql. 
host: The host. 
dbUser: The database username. 
dbPass: The database password. 
dbName: The name of the database. 
charset: The charset of you databases and tables. 

In the admin folder, two files use this configuration json:
models/Conn.php
models/StaticConn.php

If the config.js is misconfigurated, you can't connect to the database, and 
you'll get a mysql error message. 

At the first start, the system makes all of the neccessary tables, in some coses with
default values. You don't have to upload sql files manually to the database. 

This blog system works correctly not just webhosings, but also wamp server. 
