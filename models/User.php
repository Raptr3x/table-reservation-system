<?php
class User
{

    private $database_con;
    public $user_id;

    public function __construct($database_connection)
    {
        $this->database_con = $database_connection;
        if (isset($_SESSION['user_data'])) {
            $this->user_id = $_SESSION['user_data']['userID'];
        }
    }

    public function login($email, $password)
    {
        $login_data = $this->get_login_data($email);
        $this->user_id = $login_data['userID'];

        if ($login_data) {

            if (
                password_verify($_POST['password'], $login_data['password'])
                && $this->load_user_data_to_session()
            ) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function load_user_data_to_session()
    {
        $user_data = $this->database_con->select('users', '*', 'userID = ?', array($this->user_id));
        if ($user_data) {
            $_SESSION['user_data'] = $user_data[0];
            return true;
        }
        return false;
    }

    private function get_login_data($email)
    {
        $resp = $this->database_con->select('users', '*', 'email = ?', array($email));
        if ($resp) {
            return $resp[0];
        }
        return false;
    }

    private function get_active_status()
    {
        $resp = $this->database_con->select('users', 'status', 'userID = ?', array($this->user_id));
        if ($resp) {
            return $resp[0]['deleted'];
        }
        return false;
    }


    public function update_account_data($new_data)
    {
        return $this->database_con->updateMultipleColumns(
            'users',
            $new_data,
            'userID=?',
            array($this->user_id)
        );
    }

    public function create_new_account()
    {
        return $this->database_con->insert('users', array(
            'name' => $_POST['name'],
            'lastname' => $_POST['last_name'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        )
        );
    }

}

?>