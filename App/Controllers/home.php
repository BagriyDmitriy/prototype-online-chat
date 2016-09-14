<?php

namespace App\Controllers;

class Home extends Controller
{
    public function index()
    {
        session_start();

        if (isset($_SESSION['user_id'])) {
            $data = array('user_id' => $_SESSION['user_id']);
        }

        $db = new \App\Models\User($this->registry);

        $data['messages'] = $db->getLastMessages();

        $this->response->setOutput($this->load->view('/home.tpl', $data));
    }

}