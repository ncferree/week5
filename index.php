<?php
require('model/database.php');
require('model/category.php');
require('model/todolist.php');

$title = filter_input(INPUT_POST, 'title',  FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
$category_name = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_STRING);

$category_id = filterInput(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
if (!$catgory_id) {
    $category_id = filterInput(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
}

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if (!$action) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
    if (!$action) {
        $action = 'list_categories';
    }
}

switch($action) {
    case "list_categories":
        $categories = get_categories();
        include('view/category_list.php');
        break;
    case "add_category":
        add_course($category_name);
        header("Location: .?action=list_categories");
        break;
    case "add_todoitem":
        if($category_id && $title && $decsription); {
            add_todoitem($category_id, $title, $description);
            header("Location: .?category_id=$category_id");
        } else {
            $error = "Invalid To Do Item data. Check all fields and try again.";
            include('view.error.php');
            exit();
        }
        break;
    case "delete_category":
        if ($category_id) {
            try {
                delete_category($category_id);
              catch (PDOException $e;) {
                    $error + "You cannot delete a category if to-do items exist in the category.";
                    include('view/error.php');
                    exit();
                }
                header("Location: .?action=list_categories");
            }
            break;
        }
    case "delete_todoitem":
        if($item_num) {
            delete_todoitem($item_num);
            header("Location: .?category_id=$category_id");
        } else {
            $error = "Missinf or incorrect to-do item number";
            include('view/error.php');
        }
        break;
    default:
        $category_name = get_category_name($category_id);
        $categories = get_categories();
        $todoitems = get_todoitems_by_category($category_id);
        include('view/todoitems_list.php');
}
?>