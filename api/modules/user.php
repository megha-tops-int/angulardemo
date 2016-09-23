<?php
class User extends Database{
    public $table_name = 'users';
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * Check email exist
     * @param String type $email
     * @return boolean
     */
    public function hasEmail($email){
        $query = "Select id from ".$this->table_name." WHERE email = '".$email."'";
        $res = mysqli_query($this->connecting_link,$query) or die(mysqli_error($this->connecting_link));
        if(mysqli_num_rows($res) > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
     * 
     * @param String type $name
     * @param String type $email
     * @param String type $password
     * @param Integer type $user_type - Default 1
     * @param Integer type $status - Default 1
     * @return Integer type
     */
    public function addUser($name,$email,$password,$user_type = 1,$status = 1){
        $password = md5($password);
        $query = "INSERT INTO  ".$this->table_name
                . "(name,email,password,user_type,status,created_at,updated_at) values "
                . "('".$name."','".$email."','".$password."','".$user_type."','".$status."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."') ";
        $res = mysqli_query($this->connecting_link,$query) or die(mysqli_error($this->connecting_link));
        return mysqli_insert_id($this->connecting_link);
    }
    
    /**
     * 
     * @param String type $email
     * @param String type $password
     * @return Mixed type - Error or Success Message, Status - 0 Error , 1 Success , User ID - If Success , User Name - If Success, User Type - If Success
     */
    public function checkUserCredentialsForLogin($email,$password){
        $query = " SELECT id,status,name,user_type  FROM ".$this->table_name ." WHERE user_type = '2' and email = '".$email."' and password = '".md5($password)."' ";
        $res= mysqli_query($this->connecting_link,$query) or die(mysqli_error($this->connecting_link));
        $return_data = array();
        if(mysqli_num_rows($res) > 0){
            $users = mysqli_fetch_assoc($res);
            if($users['status'] == 1){
                $return_data['status'] = 1;
                $return_data['message'] = 'success';
                $return_data['user_id'] = $users['id'];
                $return_data['user_name'] = $users['name'];
                $return_data['user_type'] = $users['user_type'];
            }else{
                $return_data['status'] = 0;
                $return_data['message'] = 'Please contact administrator. Your account has been block.';
            }
        }else{
            $return_data['status'] = 0;
            $return_data['message'] = 'You have enter wrong credential. Please try again.';
        }
        return $return_data;
    }
    
    /***
     * Get User count
     * @return Integer type $return_data
     */
    public function getActiveClientUserCount(){
        $query = " SELECT count(id) as count  FROM ".$this->table_name ." WHERE user_type='1' and status = '1' ";
        $res= mysqli_query($this->connecting_link,$query) or die(mysqli_error($this->connecting_link));
        $return_data = 0;
        if(mysqli_num_rows($res) > 0){
            $users = mysqli_fetch_assoc($res);
            $return_data = $users['count'];
        }
        return $return_data;
    }
    
    /***
     * Get User count
     * @return Integer type $return_data
     */
    public function getUserCount(){
        $query = " SELECT count(id) as count  FROM ".$this->table_name ." WHERE 1=1 ";
        $res= mysqli_query($this->connecting_link,$query) or die(mysqli_error($this->connecting_link));
        $return_data = 0;
        if(mysqli_num_rows($res) > 0){
            $users = mysqli_fetch_assoc($res);
            $return_data = $users['count'];
        }
        return $return_data;
    }
    
     /***
     * Get User listing
     * @return Mixed type $return_data - Array : id,name,email,status
     */
    public function getUserListing($current_page,$per_page){
        $query = " SELECT id,name,email,status,user_type  FROM ".$this->table_name ." WHERE 1=1 limit 0,".$per_page." ";
        $res= mysqli_query($this->connecting_link,$query) or die(mysqli_error($this->connecting_link));
        $return_data = array();
        if(mysqli_num_rows($res) > 0){
            while($user = mysqli_fetch_assoc($res)){
                $return_data[] = $user;
            }
        }
        return $return_data;
    }
    
     /***
     * Get User listing
     * @param Integer $id
     * @return Mixed type $return_data - Array : id,name,email,status
     */
    public function getUser($id){
        $query = " SELECT id,name,email,status,user_type  FROM ".$this->table_name ." WHERE id = '".$id."'  ";
        $res= mysqli_query($this->connecting_link,$query) or die(mysqli_error($this->connecting_link));
        $return_data = array();
        if(mysqli_num_rows($res) > 0){
            $return_data = mysqli_fetch_assoc($res);
        }
        return $return_data;
    }
    
    /**
     * 
     * @param String type $name
     * @param Integer type $user_type - Default 1
     * @param Integer type $status - Default 1
     * @return Integer type
     */
    public function editUser($id,$name,$user_type = 1,$status = 1){
        $query = "update  ".$this->table_name." SET "
                . " name = '".$name."', user_type = '".$user_type."', status = '".$status."', updated_at = '".date("Y-m-d H:i:s")."' where id = '".$id."' ";
        mysqli_query($this->connecting_link,$query) or die(mysqli_error($this->connecting_link));
        return mysqli_affected_rows($this->connecting_link);
    }
    
    /**
     * 
     * @param String type $name
     * @return Integer type
     */
    public function deleteUser($id){
        $query = "delete from  ".$this->table_name."  where id = '".$id."' ";
        mysqli_query($this->connecting_link,$query) or die(mysqli_error($this->connecting_link));
        return mysqli_affected_rows($this->connecting_link);
    }
}
?>