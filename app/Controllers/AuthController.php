<?php
namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function form()
    {
        return view('auth/login', [
            'title' => 'SysInfo — Connexion'
        ]);
    }

    public function login()
    {
        $model = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = $model->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Email ou mot de passe incorrect')->withInput();
        }
        // Stocker uniquement les données non sensibles en session
        session()->set('user', [
            'id' => $user['id'],
            'nom' => $user['nom'],
            'email' => $user['email'],
            'role' => $user['role'],
            // 'admin' | 'etudiant' | 'professeur'
        ]);

        return redirect()->to('/etudiants');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}