<?php 
require_once 'config/connection.php';

$action = (isset($_REQUEST['action']) && !empty($_REQUEST['action']))?trim($_REQUEST['action']):"user_login";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = file_get_contents("php://input");
    if($data != ''){
        $data = (array) json_decode($data);
        $action = (isset($data['action']) && !empty($data['action']))?trim($data['action']):"user_login";
    }
}

switch ($action){
    case 'user_register':
        $return_data = user_register($data);
        break;
    case 'user_login':
        $return_data = user_login($_REQUEST);
        break;
    case 'user_dashboard':
        $return_data = user_dashboard($_REQUEST);
        break;
    case 'user_management':
        $return_data = user_management($_REQUEST);
        break;
    case 'user_add':
        $return_data = user_register($data);
        break;
    case 'user_get':
        $return_data = user_get($_REQUEST);
        break;
    case 'user_edit':
        $return_data = user_edit($data);
        break;
    case 'user_delete':
        $return_data = user_delete($data);
        break;
    case 'bulk_user_insert':
        $return_data = bulk_user_insert();
        break;
    default :
        $return_data['status'] = 0;
        $return_data['message'] = "No action defined!!!";
        break;
}

echo json_encode($return_data);
exit();
?>