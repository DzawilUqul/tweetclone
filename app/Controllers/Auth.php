<?php

namespace App\Controllers;

use \App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {        
        return view('auth_login');
    }

    public function register()
    {
        return view('auth_register');
    }

    public function addUser()
    {
        $userModel = new UserModel();

        if($this->validate($userModel->rules)){
            $result = $userModel->addUser($this->request->getPost());
            $sess = session();
            $sess->set('currentuser', ['username' => $result[0], 'userid'   => $result[1]]);
            return redirect()->to('/');
        } else {
            $data['validation'] = $this->validator;
            $data['input'] = $this->request->getPost();
            return view('auth_register', $data);
        }
    }

    public function login()
    {   
        $sess = session();
        $userMdl = new UserModel();
        
        if($this->validate($userMdl->loginRules)){
            $result = $userMdl->login(
                    $this->request->getPost('username'), 
                    $this->request->getPost('password')
                );
            if($result){
                $sess->set('currentuser', 
                    ['username' => $result[0], 'userid' => $result[1]]);
                return redirect()->to('/');
            } else {
                $sess->setFlashdata('login_error', 
                    'Kombinasi Username &amp; Password tidak ditemukan');
                return redirect()->to('/auth');
            }
        } else {
            $data['validation'] = $this->validator;
            return view('auth_login', $data);
        }
    }

    public function logout()
    {
        $sess = session();
        $sess->remove('currentuser');
        $sess->setFlashdata('logout', 'success');
        return redirect()->to('/auth');
    }

    public function EditProfileForm()
    {
        $userModel = new UserModel();
        $sess = session();
        $user = $userModel->find($sess->get('currentuser')['userid']);
        $data['user'] = $user;
        return view('auth_edit_profile', $data);
    }

    public function EditProfile()
    {
        $userModel = new UserModel();
        $sess = session();
        $user = $userModel->find($sess->get('currentuser')['userid']);
        $user->fullname = $this->request->getPost('fullname');
        $user->username = $this->request->getPost('username');

        if($this->validate($userModel->editRules)){
            $userModel->save($user);
            $sess->setFlashdata('edit_profile', 'success');
            return redirect()->to('/');
        } else {
            $data['validation'] = $this->validator;
            $data['user'] = $user;
            return view('auth_edit_profile', $data);
        }
    }
}