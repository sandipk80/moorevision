<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
if(isset($_REQUEST['id']) && $_REQUEST['id'] !== ""){
    $pageTitle = "Edit Category";
}else{
    $pageTitle = "Add Category";
}
$error = array();

if(isset($_POST) && isset($_POST['add-category']) && trim($_POST['add-category'])=='submit') {
    if(isset($_POST['name']) && trim($_POST['name'])=='') {
        $error[] = 'Category name is required';
    }else{
        $catName = trim($_POST['name']);
    }
    
    if(empty($error)){
        if(isset($_POST['cid']) && trim($_POST['cid'])!=='') {
            $catId = $_POST['cid'];
            $where = "id='".$catId."'";
            $catArray = array(
                'name' => $_POST['name']
            );
            $addCategory = $globalManager->runUpdateQuery('categories',$catArray,$where);
            $_SESSION['message'] ="Category has been updated successfully.";
        }else{
            //add new category
            $catArray = array(
                'name' => $_POST['name'],
                'status' => '1'
            );

            $addCategory = $globalManager->runInsertQuery('categories',$catArray);
            if($addCategory){
                $_SESSION['message'] = "New category has been added successfully.";
                
            }

        }
        redirect(ADMIN_SITE_URL."categories.php");
    }
}

if(isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
    $table = "categories";
    $field = "*";
    $where = "id = '".$_GET['id']."'";
    $result = $globalManager->runSelectQuery($table,$field,$where);

    if(is_array($result) && count($result)>0) {
        $result[0] = array_map("utf8_encode", $result[0]);
        $catName = $result[0]['name'];
    }else{
        $_SESSION['errmsg'] = "Invalid category selected! Please select valid category to update";
        redirect(ADMIN_SITE_URL."categories.php");
    }
}
