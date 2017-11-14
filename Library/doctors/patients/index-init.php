<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//set page title
$pageTitle = "Patients";

$where = "u.status='1' AND u.active='1'";
$relTable = "users as u LEFT JOIN states as st ON u.state_id=st.id LEFT JOIN cities as ct ON u.city_id=ct.id";
$relFields = "u.*,st.name as state,ct.name as city";
$result = $globalManager->runSelectQuery($relTable, $relFields, $where);