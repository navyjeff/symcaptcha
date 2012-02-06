<?php

  //create or open the database
  $database = new SQLiteDatabase('symcaptcha.sq3', 0666, $error);

  $query = 'CREATE TABLE Movies ' .
         '(Title TEXT, Director TEXT, Year INTEGER)';
phpinfo()

?>