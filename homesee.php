<?php

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/nav_bar_menusee.php';

// Global variable for the title in the <head>.
$twig->addGlobal('title', "Home");

//Render view
echo $twig->render('homesee.html', ['categories' => $categories]);