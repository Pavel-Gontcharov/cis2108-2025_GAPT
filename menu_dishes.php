<?php

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/nav_bar_menu.php';

session_start();

if (isset($_GET['categoryID'])) {
    $db = new Db();
    $category_id = $db->quote($_GET['categoryID']);

    // Select dishes with the given category id.
    $dishes = $db->select("SELECT d.*, c.category_name FROM dishes d INNER JOIN categories c ON d.category_id=c.category_id WHERE c.category_id=" . $category_id);

    if (isset($_SESSION['favouritesId'])) {
        foreach ($dishes as &$dish) { 
            $dish['is_favourite'] = in_array($dish['dish_id'], $_SESSION['favouritesId']);
        }
        unset($dish);  
    } else {
        foreach ($dishes as &$dish) {  
            $dish['is_favourite'] = false;  
        }
        unset($dish);  
    }

    if (count($dishes) > 0) {
        $twig->addGlobal('title', $dishes[0]['category_name']);
        echo $twig->render('menu_dishes.html', ['dishes' => $dishes, 'categories' => $categories]);
    } else {
        $twig->addGlobal('title', "404");
        echo $twig->render('404.html', ['categories' => $categories]);
    }
} else {
    $twig->addGlobal('title', "404");
    echo $twig->render('404.html', ['categories' => $categories]);
}

