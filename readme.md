tested on:

Apache/2.2.21 (Win32);
PHP/5.3.8;
MySQL Community Server (GPL) 5.5.25a;
Yii Framework/1.1.10

PDO support	enabled
PDO drivers	mysql, odbc, sqlite, sqlite2

PDO Driver for MySQL	enabled
Client API version	mysqlnd 5.0.8-dev - 20102224 - $Revision: 310735 $

-----------------------------------

install:
0. Check whether Yii requirements are fulfulled at http://localhost/.../requirements/
1. Create database
2. Import database structure from demos/blog/protected/data/schema.mysql.sql
3. Configure access to database in demos/blog/protected/config/main.php

Username / password pairs:
demo / demo
user1 / demo
user2 / demo

4. enable / disable CHAT WIDGET in /protected/views/layouts/main.php line 55
   - example for enabled chat, line 55: <?php $this->widget('ChatWidget', array('data'=>'')); ?>
   - example for disabled chat, line 55: <?php // $this->widget('ChatWidget', array('data'=>'')); ?>

Chat tables in DB are created automatically when a) chat widget is called as described above and 2) front page is loaded
