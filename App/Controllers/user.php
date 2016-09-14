<?php

namespace App\Controllers;

use App\Models;

class User extends Controller
{
    public function form()
    {
        session_start();

        if (isset($_SESSION['user_id'])) {
            $this->response->setOutput($this->load->view('/chat_form.tpl'));
        } else {
            $this->response->setOutput($this->load->view('/login.tpl'));
        }
    }

    public function register()
    {
        session_start();

        $db = new \App\Models\User($this->registry);

        if (isset($_SESSION['user_id'])) {
            $this->response->setOutput($this->load->view('/chat_form.tpl'));

        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $error = array();

            if (!(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['homepage']) && isset($_POST['password']))) {
                return;
            }

            if (!preg_match("/[a-zA-Z0-9]+/", $_POST['username'])) {
                $error['username'] = true;
            }

            $user_query = $db->findUser($_POST['username']);

            if ($user_query->num_rows) {
                $error['username_exists'] = true;
            }

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error['email'] = true;
            }

            if ($_POST['homepage'] != '' && !filter_var($_POST['homepage'], FILTER_VALIDATE_URL)) {
                $error['homepage'] = true;
            }

            if ($_POST['password'] == '') {
                $error['password'] = true;
            }

            if ($error) {
                $data['username'] = $_POST['username'];
                $data['email'] = $_POST['email'];
                $data['homepage'] = $_POST['homepage'];
                $data['error'] = $error;

                $this->response->setOutput($this->load->view('/register.tpl', $data));
            } else {
                $result = $db->register($_POST['username'], $_POST['password'], $_POST['email'], $_POST['homepage']);

                if($result){
                    $_SESSION['user_id'] = $result;

                    $this->response->setOutput($this->load->view('/chat_form.tpl'));
                };
            }

        } else {
            $data['username'] = "";
            $data['email'] = "";
            $data['homepage'] = "";
            $data['error'] = "";

            $this->response->setOutput($this->load->view('/register.tpl', $data));
        }
    }

    public function login()
    {
        $db = new \App\Models\User($this->registry);

        session_start();

        if (isset($_SESSION['user_id'])) {
            $this->response->redirect('index.php');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->response->setOutput($this->load->view('/login.tpl'));
        } else {
            $user_query = $db->getUser($_POST['username'], $_POST['password']);

            if ($user_query->num_rows) {
                $_SESSION['user_id'] = $user_query->row['user_id'];

                echo json_encode(array('status' => true));
            } else {
                echo json_encode(array('status' => false));
            }
        }
    }

    public function logout()
    {
        session_start();
        
        unset($_SESSION['user_id']);
    }

    public function saveMessage()
    {
        session_start();

        if (isset($_SESSION['user_id'])) {
            if (!isset($_POST['message']) || !isset($_FILES['message_file']['name'])) {
                return;
            }

            if (!$_POST['message']) {
                $error['message'] = true;
            }

            if ($_FILES['message_file']['name'] && $_FILES['message_file']['size'] > 102400) {
                $error['message_file'] = true;
            }

            if(isset($error)) {
                $data['error'] = $error;
                $data['message'] = $_POST['message'];

                echo json_encode(array('status' => false, 'content' => $this->load->view('/chat_form.tpl', $data)));
            } else {
                if ($_FILES['message_file']['name']) {
                    $content = file_get_contents($_FILES['message_file']['tmp_name']);

                    $text = mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'auto'));
                }

                $db = new \App\Models\User($this->registry);

                $message_content = array(
                    'message'   => $_POST['message'],
                    'txt_file'  => isset($text) ? $text : '',
                    'name_file' => $_FILES['message_file']['name'] ? $_FILES['message_file']['name'] : '',
                );

                $message_id = $db->saveMessage($message_content);
                
                if ($message_id) {
                    echo json_encode(array('status' => true, 'message_id' => $message_id));
                } else {
                    echo json_encode(array('status' => false));
                }
            }
        } else {
            $this->response->setOutput($this->load->view('/login.tpl'));
        }
    }

    public function loadmessages()
    {
        if (isset($_POST['last_id'])) {
            $db = new \App\Models\User($this->registry);

            $data['messages'] = $db->getMessages((int)$_POST['last_id']);

            if($data['messages']){
                echo json_encode(array('status' => true,
                                      'last_id' => end($data['messages'])['id'],
                                      'content' => $this->load->view('/messages.tpl', $data),
                                      )
                );   
            } else {
                echo json_encode(array('status' => false));
            }
        }
    }

    public function showfile()
    {
        if (isset($_POST['id'])) {
            $db = new \App\Models\User($this->registry);

            $content = $db->getFile((int)$_POST['id']);
            
            echo json_encode(array('status' => true,
                                   'file_name' => $content['name_file'],
                                   'txt_file' => htmlentities($content['txt_file']),
                                  )
            );
        }
    }
}