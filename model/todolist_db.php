<?php

    function get_todoitems_by_category($category_id) {
        global $db;
        if ($category_id) {
            $query = 'SELECT T.Title, T.Decsription, C.categoryID FROM todolist T LEFT JOIN 
            categories C WHERE T. categoryID = :category_id ORDER BY T.Title';
        } else {
            $query = 'SELECT T.Title, T.Decsription, C.categoryID FROM todolist T LEFT JOIN 
            categories C ON T.categoryID = C.categoryID ORDER BY C.categoryID';
        }
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $todoitems =  $statement->fetchALL();
        $statement->closeCursor();
        return $todoitems;
    }
    function delete_todoitem($item_num) {
        global $db;
        $query = 'DELETE FROM todoitems WHERE ItemNum = :item_num';
        $statement = $db->prepare($query);
        $statement->bindValue(':item_num', $item_num);
        $statement->execute();
        $statement->closeCursor();
    }
    function add_todoitem($category_id, $title, $description) {
        global $db;
        $query = 'INSERT INTO todoitems (title, description, categoryID) VALUES (:descr, :title, :categoryID)';
        $statement = $db->prepare($query);
        $statement->bindValue(':descr', $description);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':categoryID', $category_id);
        $statement->execute();
        $statement->closeCursor();
     
    }