<?php

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/nav_bar_menu.php';

// Global variable for the title in the <head>.
$twig->addGlobal('title', "About");

//Render view
echo $twig->render('about.html', ['categories' => $categories]);
