<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

if(isset($_REQUEST['id']) && $_REQUEST['id'] !== ""){
    $pageTitle = "Edit Page";
}else{
    $pageTitle = "Add Page";
}
$error = array();

if(isset($_POST) && isset($_POST['add-page']) && trim($_POST['add-page'])=='submit') {
    if(isset($_POST['title']) && trim($_POST['title'])=='') {
        $error = 'Page title is required';
    }else{
        $title = trim($_POST['title']);
    }
    if(isset($_POST['content']) && trim($_POST['content'])=='') {
        $error = 'Page content is required';
    }else{
        $content = trim($_POST['content']);
    }

    if(empty($error)){
        $slug = UtilityManager::Slug($_POST['title']);
        //check for duplicate slug
        $checkSlug = $globalManager->runSelectQuery("pages", "IFNULL(COUNT(id),0) as total", "slug='".$slug."'");
        if($checkSlug[0]['total'] > 0){
            $slug = $slug.rand();
        }
        if(isset($_POST['pid']) && trim($_POST['pid'])!=='') {
            $pageId = $_POST['pid'];
            $where = "id='".$pageId."'";
            $pageArray = array(
                'title' => $_POST['title'],
                'slug' => $slug,
                'content' => $_POST['content'],
                'modified' => date("Y-m-d H:i:s")
            );
            $savePage = $globalManager->runUpdateQuery('pages',$pageArray,$where);
            $_SESSION['message'] ="Page has been updated successfully.";
            redirect(ADMIN_SITE_URL."pages.php");
        }else{
            //add new page
            $pageArray = array(
                'title' => $_POST['title'],
                'slug' => $slug,
                'content' => $_POST['content'],
                'status' => '1',
                'modified' => date("Y-m-d H:i:s"),
                'created' => date("Y-m-d H:i:s")
            );
            $addPage = $globalManager->runInsertQuery('pages',$pageArray);
            if($addPage){
                $_SESSION['message'] = "Page has been added.";
                redirect(ADMIN_SITE_URL."pages.php");
            }

        }
        
    }
}

if(isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
    $table = "pages";
    $field = "*";
    $where = "id = '".$_GET['id']."'";
    $result = $globalManager->runSelectQuery($table,$field,$where);
    if(is_array($result) && count($result)>0) {
        $result[0] = array_map("utf8_encode", $result[0]);
        $title = $result[0]['title'];
        $slug = $result[0]['slug'];
        $content = $result[0]['content'];
    }else{
        $_SESSION['errmsg'] = "Invalid page selected! Please select valid page to update";
        redirect(ADMIN_SITE_URL."pages.php");
    }
}
