<?php
$koneksi = new PDO(
  "pgsql:host=localhost;
   port=5432;
   dbname=todo_db",
  "postgres",
  "maulana",
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
?>