<?php
$page = $_GET['page'] ?? 'home';
require __DIR__.'/pages/'.$page.'.php';   // tiap halaman include header & footer sendiri
