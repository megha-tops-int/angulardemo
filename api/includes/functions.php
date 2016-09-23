<?php

/** 
 * User Registeration
 * @param Mixed Type $post_data  - User's Name,Email and Password
 * @return Mixed Type $return_data - Error or Success Message, Status - 0 Error , 1 Success , User ID - If Success
 */

function user_register($post_data){
    $name = (isset($post_data['name']) && !empty($post_data['name']))?addslashes(strip_tags(trim($post_data['name']))):'';
    $email = (isset($post_data['email']) && !empty($post_data['email']))?addslashes(strip_tags(trim($post_data['email']))):'';
    $password = (isset($post_data['password']) && !empty($post_data['password']))? (addslashes(strip_tags(trim($post_data['password'])))):'';
    $user_type = (isset($post_data['user_type']) && !empty($post_data['user_type']))? (addslashes(strip_tags(trim($post_data['user_type'])))):1;
    $user_status = (isset($post_data['user_status']) && !empty($post_data['user_status']))? (addslashes(strip_tags(trim($post_data['user_status'])))):1;
    
    $return_data = array();
    if($name != '' && $email != '' && $password != ''){
        $user = new User();
        if(!$user->hasEmail($email)){
            $user_id = $user->addUser($name,$email,$password,$user_type,$user_status);
            if($user_id > 0){
                $return_data['status'] = 1; 
                $return_data['message'] = '';
                $return_data['user_id'] = $user_id;
            }else{
                $return_data['status'] = 0; 
                $return_data['message'] = 'Please try again later.';
            }
        }else{
            $return_data['status'] = 0; 
            $return_data['message'] = 'Email address already exists.';
        }
    }else{
       $return_data['status'] = 0; 
       $return_data['message'] = 'Please fill required data';
    }
    return $return_data;
}

/**
 * Admin User Login
 * @param Mixed type $post_data - User's Email & Password
 * @return Mixed string  Error or Success Message, Status - 0 Error , 1 Success , User ID - If Success , User Name - If Success, User Type - If Success
 */
function user_login($post_data){
    $email = (isset($post_data['email']) && !empty($post_data['email']))?addslashes(strip_tags(trim($post_data['email']))):'';
    $password = (isset($post_data['password']) && !empty($post_data['password']))? (addslashes(strip_tags(trim($post_data['password'])))):'';
    $return_data = array();
    if($email != '' && $password != ''){
        $user = new User();
        $return_data = $user->checkUserCredentialsForLogin($email,$password);
    }else{
       $return_data['status'] = 0; 
       $return_data['message'] = 'Please fill required data.';
    }
    return $return_data;
}

/**
 * Admin User Dashboard Count
 * @param Mixed type $request_data - Login User's Id
 * @return Mixed string  Error or Success Message, Status - 0 Error , 1 Success , User count - If Success
 */
function user_dashboard($request_data){
    $user_id = (isset($request_data['user_id']) && !empty($request_data['user_id']))?addslashes(strip_tags(trim($request_data['user_id']))):'';
    $return_data = array();
    if($user_id != ''){
        $user = new User();
        $user_count = $user->getActiveClientUserCount();
        $return_data['status'] = 1; 
        $return_data['message'] = '';
        $return_data['user_count'] = $user_count;
    }else{
       $return_data['status'] = 0; 
       $return_data['message'] = 'Please fill required data.';
    }
    return $return_data;
}

/***
 * User Listing with searching, sorting and paging
 * @param Mixed type $request_data - Login User's Id , Search String, Sorting Field ,Current page number , Item per Page
 */
function user_management($request_data){
    $user_id = (isset($request_data['user_id']) && !empty($request_data['user_id']))?addslashes(strip_tags(trim($request_data['user_id']))):'';
    $page_no = (isset($request_data['page_no']) && !empty($request_data['page_no']))?addslashes(strip_tags(trim($request_data['page_no']))):1;
    $item_per_page = (isset($request_data['item_per_page']) && !empty($request_data['item_per_page']))?addslashes(strip_tags(trim($request_data['item_per_page']))):10;
    $return_data = array();
    if($user_id != ''){
        $user = new User();
        $users= $user->getUserListing($page_no,$item_per_page);
        $total_count = $user->getUserCount();
        $return_data['total_count'] = $total_count;
        $return_data['status'] = 1; 
        $return_data['message'] = '';
        $return_data['users'] = $users;
    }else{
       $return_data['status'] = 0; 
       $return_data['message'] = 'Please fill required data.';
    }
    return $return_data;
}

/**
 * Get User details
 * @param Mixed type $request_data - Login User's Id,id
 * @return Mixed string  Error or Success Message, Status - 0 Error , 1 Success , User data - If Success
 */
function user_get($request_data){
    $user_id = (isset($request_data['user_id']) && !empty($request_data['user_id']))?addslashes(strip_tags(trim($request_data['user_id']))):'';
    $id = (isset($request_data['id']) && !empty($request_data['id']))?addslashes(strip_tags(trim($request_data['id']))):'';
    $return_data = array();
    if($user_id != '' && $id != ''){
        $user = new User();
        $user_data = $user->getUser($id);
        if(!empty($user_data)){
            $return_data['status'] = 1; 
            $return_data['message'] = '';
            $return_data['user'] = $user_data;
        }else{
            $return_data['status'] = 0; 
            $return_data['message'] = 'User not found.';
        }
    }else{
       $return_data['status'] = 0; 
       $return_data['message'] = 'Please fill required data.';
    }
    return $return_data;
}

/** 
 * User Edit
 * @param Mixed Type $post_data  - User's Name,Email and Password
 * @return Mixed Type $return_data - Error or Success Message, Status - 0 Error , 1 Success 
 */
function user_edit($post_data){
    $id = (isset($post_data['id']) && !empty($post_data['id']))?addslashes(strip_tags(trim($post_data['id']))):'';
    $name = (isset($post_data['name']) && !empty($post_data['name']))?addslashes(strip_tags(trim($post_data['name']))):'';
    $user_type = (isset($post_data['user_type']) && !empty($post_data['user_type']))? (addslashes(strip_tags(trim($post_data['user_type'])))):1;
    $user_status = (isset($post_data['status']) && !empty($post_data['status']))? (addslashes(strip_tags(trim($post_data['status'])))):1;
    
    $return_data = array();
    if($name != '' && $id != ''){
        $user = new User();
        $user->editUser($id,$name,$user_type,$user_status);
        $return_data['status'] = 1; 
        $return_data['message'] = '';
    }else{
       $return_data['status'] = 0; 
       $return_data['message'] = 'Please fill required data';
    }
    return $return_data;
}

/** 
 * User Delete
 * @param Mixed Type $post_data  - User's Name,Email and Password
 * @return Mixed Type $return_data - Error or Success Message, Status - 0 Error , 1 Success 
 */
function user_delete($post_data){
    $id = (isset($post_data['id']) && !empty($post_data['id']))?addslashes(strip_tags(trim($post_data['id']))):'';
    
    $return_data = array();
    if($id != ''){
        $user = new User();
        $user->deleteUser($id);
        $return_data['status'] = 1; 
        $return_data['message'] = '';
    }else{
       $return_data['status'] = 0; 
       $return_data['message'] = 'Please fill required data';
    }
    return $return_data;
}

function bulk_user_insert(){
    echo "<pre>";
    for($i = 0;$i<=5;$i++){
        $data = [
            "name"=>"megha",
            "password"=>"123123",
            "email"=>"meghashah".$i."@tops-int.com",
            "confirmPassword"=>"123123"
            ];
        $return_data = user_register($data);
        print_r($return_data);
        echo "<br/><hr/>";
    }
}