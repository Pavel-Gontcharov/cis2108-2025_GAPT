<?php

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/nav_bar_menu.php';

// Global variable for the title in the <head>.
$twig->addGlobal('title', "Gallery");

$db = new Db();
$gallery = $db->select("SELECT * FROM gallery");

//Render view
echo $twig->render('gallery.html', ['gallery' => $gallery, 'categories' => $categories]);
