<?php
session_start();

function sanitize_user_input_text($str){        
    return str_replace(["'","\"", ";", "*", "=", "|", "(", ")"], "", $str);
}

function isAdmin(){
    if ($_SESSION['user']['access_level']==1) {
		return true;
	}
    return false;	
}

function isUser(){
    if ($_SESSION['user']['access_level']==2) {
		return true;
	}
    return false;	
}

function check_login(){
    if (!isLoggedIn()) {
        header('location: login.php?'.$_SERVER['QUERY_STRING']);
    }
    else{
        $user = $_SESSION['user'];
        return $user;
    }
}

function isLoggedIn(){
    if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
		return true;
	}
    return false;
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

function logout(){
    session_destroy();
    unset($_SESSION['user']);
    unset($_SESSION['admin']);
}

function isActive($page, $class='active'){
    if(isset($_GET['page'])){
        if($_GET['page']==$page){
            echo $class;
        }
    }
}

?>