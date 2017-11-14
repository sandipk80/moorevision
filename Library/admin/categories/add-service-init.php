<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
if(isset($_REQUEST['id']) && $_REQUEST['id'] !== ""){
    $pageTitle = "Edit Service";
}else{
    $pageTitle = "Add Service";
}
$error = array();
if(isset($_GET['cid']) && trim($_GET['cid'])!==""){
    $categoryId = trim($_GET['cid']);
}
if(isset($_POST) && isset($_POST['add-service']) && trim($_POST['add-service'])=='submit') {
    if(isset($_POST['name']) && trim($_POST['name'])=='') {
        $error[] = 'Service name is required';
    }else{
        $name = trim($_POST['name']);
    }

    if(isset($_POST['category_id']) && trim($_POST['category_id'])=='') {
        $error[] = 'Category is required';
    }else{
        $categoryId = trim($_POST['category_id']);
    }
    
    if(empty($error)){
        if(isset($_POST['sid']) && trim($_POST['sid'])!=='') {
            $serviceId = $_POST['sid'];
            $where = "id='".$serviceId."'";
            $serviceArray = array(
                'name' => $_POST['name'],
                'category_id' => $_POST['category_id']
            );
            $saveService = $globalManager->runUpdateQuery('services',$serviceArray,$where);
            $_SESSION['message'] ="Service has been updated successfully.";
        }else{
            //add new service
            $serviceArray = array(
                'name' => $_POST['name'],
                'category_id' => $_POST['category_id'],
                'status' => '1'
            );

            $addService = $globalManager->runInsertQuery('services',$serviceArray);
            if($addCategory){
                $_SESSION['message'] = "New service has been added successfully.";
                
            }

        }
        redirect(ADMIN_SITE_URL."services.php?cid=".$_POST['category_id']);
    }
}

if(isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
    $table = "services";
    $field = "*";
    $where = "id = '".$_GET['id']."'";
    $result = $globalManager->runSelectQuery($table,$field,$where);

    if(is_array($result) && count($result)>0) {
        $result[0] = array_map("utf8_encode", $result[0]);
        $name = $result[0]['name'];
        $categoryId = $result[0]['category_id'];
    }else{
        $_SESSION['errmsg'] = "Invalid service selected! Please select valid service to update";
        redirect(PHP_SELF);
    }
}

//find out the list of categories
$arrCategories = $globalManager->runSelectQuery("categories", "id,name", "status='1'");
