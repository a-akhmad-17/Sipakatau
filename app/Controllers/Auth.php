<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function login(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (session()->get('logged_in')) {
            $userRole = session()->get('role');
            $redirects = [
                'admin' => 'admin',
                'kabid' => 'bidang',
                'kaban' => 'eksekutif',
                'user'  => 'user',
                'ormas' => 'user'
            ];
            $target = $redirects[$userRole] ?? '/';
            return redirect()->to($target);
        }
        return view('auth/login', ['title' => 'Log In - SIPAKATAU']);
    }

    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $db = \Config\Database::connect();
        $user = $db->table('sys_users')
                   ->where('username', $username)
                   ->where('status', 'active')
                   ->get()
                   ->getRowArray();

        if ($user && password_verify($password, $user['password'])) {
            // Dapatkan bidang_id jika ada
            $sessionData = [
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'role'       => $user['role'],
                'bidang_id'  => $user['bidang_id'],
                'logged_in'  => true
            ];
            session()->set($sessionData);

            // Load helper app_helper & telegram secara manual
            helper(['app', 'telegram']);
            log_activity('LOGIN', null, ['user_id' => $user['id'], 'username' => $user['username']], 'sys_users', $user['id']);

            // Kirim notifikasi login ke Telegram
            $roleNames = [
                'admin' => 'Administrator (OPD)',
                'kabid' => 'Kepala Bidang',
                'kaban' => 'Kepala Badan (Kaban)',
                'user'  => 'User Biasa',
                'ormas' => 'Ormas Terdaftar'
            ];
            $roleText = $roleNames[$user['role']] ?? ucfirst($user['role']);
            
            $request = \Config\Services::request();
            $ipAddress = $request->getIPAddress();
            $userAgent = $request->getUserAgent()->getAgentString();

            telegram_send_transaction('🔑 Seseorang Telah Log In Ke Sistem', [
                'Username'  => $user['username'],
                'Peran'     => $roleText,
                'IP Address'=> $ipAddress,
                'User Agent'=> strlen($userAgent) > 100 ? substr($userAgent, 0, 100) . '...' : $userAgent
            ]);

            $redirects = [
                'admin' => 'admin',
                'kabid' => 'bidang',
                'kaban' => 'eksekutres', // wait, let's keep eksekutif
                'kaban' => 'eksekutif',
                'user'  => 'user',
                'ormas' => 'user'
            ];
            $target = $redirects[$user['role']] ?? '/';

            return redirect()->to($target)->with('success', 'Selamat datang kembali, ' . ucfirst($user['username']));
        }

        return redirect()->back()->with('error', 'Username atau password salah / tidak aktif.')->withInput();
    }

    public function logout()
    {
        helper('app');
        $userId = session()->get('user_id');
        if ($userId) {
            log_activity('LOGOUT', null, null, 'sys_users', $userId);
        }
        session()->destroy();
        return redirect()->to('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    public function register(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (session()->get('logged_in')) {
            $userRole = session()->get('role');
            $redirects = [
                'admin' => 'admin',
                'kabid' => 'bidang',
                'kaban' => 'eksekutif',
                'user'  => 'user',
                'ormas' => 'user'
            ];
            $target = $redirects[$userRole] ?? '/';
            return redirect()->to($target);
        }
        return view('auth/register', ['title' => 'Daftar Akun Baru - SIPAKATAU']);
    }

    public function attemptRegister()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[50]|is_unique[sys_users.username]',
            'email'    => 'required|valid_email|max_length[100]',
            'phone'    => 'required|min_length[5]|max_length[20]',
            'password' => 'required|min_length[6]|max_length[255]',
            'password_confirm' => 'required|matches[password]'
        ], [
            'username' => [
                'required' => 'Nama pengguna wajib diisi.',
                'min_length' => 'Nama pengguna minimal 3 karakter.',
                'max_length' => 'Nama pengguna maksimal 50 karakter.',
                'is_unique' => 'Nama pengguna sudah digunakan.'
            ],
            'email' => [
                'required' => 'Alamat email wajib diisi.',
                'valid_email' => 'Format alamat email tidak valid.',
                'max_length' => 'Alamat email maksimal 100 karakter.'
            ],
            'phone' => [
                'required' => 'Nomor telepon wajib diisi.',
                'min_length' => 'Nomor telepon minimal 5 karakter.',
                'max_length' => 'Nomor telepon maksimal 20 karakter.'
            ],
            'password' => [
                'required' => 'Kata sandi wajib diisi.',
                'min_length' => 'Kata sandi minimal 6 karakter.'
            ],
            'password_confirm' => [
                'required' => 'Konfirmasi kata sandi wajib diisi.',
                'matches' => 'Konfirmasi kata sandi tidak cocok.'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', implode(' ', $validation->getErrors()))->withInput();
        }

        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $phone = $this->request->getPost('phone');
        $password = $this->request->getPost('password');

        $db = \Config\Database::connect();
        
        $userId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $userData = [
            'id'         => $userId,
            'username'   => $username,
            'email'      => $email,
            'phone'      => $phone,
            'password'   => password_hash($password, PASSWORD_BCRYPT),
            'role'       => 'user',
            'status'     => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $db->table('sys_users')->insert($userData);

        helper('app');
        log_activity('REGISTER_USER_PUBLIK', [], ['user_id' => $userId, 'username' => $username, 'email' => $email, 'phone' => $phone], 'sys_users', $userId);

        return redirect()->to('login')->with('success', 'Akun pendaftaran Anda berhasil dibuat. Silakan masuk untuk memulai pengajuan.');
    }

    public function google()
    {
        $clientId = env('google.clientID') ?? getenv('google.clientID');
        $clientSecret = env('google.clientSecret') ?? getenv('google.clientSecret');
        
        if (empty($clientId) || empty($clientSecret)) {
            // Simulator Mode (no keys configured)
            return redirect()->to('auth/google/simulation');
        }
        
        $redirectUri = base_url('auth/google/callback');
        
        // Cek apakah redirect URI menggunakan IP privat/lokal
        $host = parse_url($redirectUri, PHP_URL_HOST);
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            // Jika IP privat (bukan loopback 127.0.0.1 atau ::1)
            if ($host !== '127.0.0.1' && $host !== '::1') {
                return redirect()->to('auth/google/simulation')->with('error', 'Google Login: Google OAuth tidak mendukung IP Privat (' . esc($host) . '). Dialihkan otomatis ke Mode Simulasi.');
            }
        }
        
        // Real Google OAuth Flow - Redirect to google consent screen
        $authUrl = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'state'         => 'secure_state_token'
        ]);
        
        return redirect()->to($authUrl);
    }

    public function googleSimulation()
    {
        $data = [
            'title' => 'Google Account Sign In - Simulation'
        ];
        return view('auth/google_simulation', $data);
    }

    public function googleCallback()
    {
        helper(['app', 'telegram']);
        $db = \Config\Database::connect();
        
        // Check if simulation POST
        $isSimulation = $this->request->getPost('is_simulation');
        
        if ($isSimulation) {
            $email = $this->request->getPost('email');
            $name = $this->request->getPost('name');
            $username = strtolower(explode('@', $email)[0]);
        } else {
            // Real OAuth flow code handling
            $code = $this->request->getGet('code');
            if (empty($code)) {
                return redirect()->to('login')->with('error', 'Google Login: Kode otentikasi tidak ditemukan.');
            }
            
            $clientId = env('google.clientID') ?? getenv('google.clientID');
            $clientSecret = env('google.clientSecret') ?? getenv('google.clientSecret');
            $redirectUri = base_url('auth/google/callback');
            
            // Exchange code for token
            $ch = curl_init('https://oauth2.googleapis.com/token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'code'          => $code,
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri'  => $redirectUri,
                'grant_type'    => 'authorization_code'
            ]));
            $response = curl_exec($ch);
            curl_close($ch);
            
            $tokenData = json_decode($response, true);
            if (empty($tokenData['access_token'])) {
                return redirect()->to('login')->with('error', 'Google Login: Gagal menukar kode otentikasi.');
            }
            
            // Fetch User info
            $ch = curl_init('https://www.googleapis.com/oauth2/v3/userinfo');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $tokenData['access_token']
            ]);
            $userInfoResponse = curl_exec($ch);
            curl_close($ch);
            
            $userInfo = json_decode($userInfoResponse, true);
            if (empty($userInfo['email'])) {
                return redirect()->to('login')->with('error', 'Google Login: Gagal mengambil data pengguna.');
            }
            
            $email = $userInfo['email'];
            $name = $userInfo['name'] ?? 'Google User';
            $username = strtolower(explode('@', $email)[0]);
        }

        // Clean & Validate email and username
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $username = preg_replace('/[^a-zA-Z0-9]/', '', $username);

        // Find user by email in sys_users
        $user = $db->table('sys_users')
                   ->where('email', $email)
                   ->where('status', 'active')
                   ->get()
                   ->getRowArray();
                   
        // If not found by email, search by username
        if (!$user) {
            $userByUsername = $db->table('sys_users')
                                 ->where('username', $username)
                                 ->get()
                                 ->getRowArray();
            if ($userByUsername) {
                // Suffix username if already exists
                $username .= mt_rand(10, 99);
            }

            // Auto-register user
            $userId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
                mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
            
            $userData = [
                'id'         => $userId,
                'username'   => $username,
                'email'      => $email,
                'password'   => password_hash(bin2hex(random_bytes(10)), PASSWORD_BCRYPT), // Secure random password
                'role'       => 'user', // Default role
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('sys_users')->insert($userData);
            
            log_activity('REGISTER_USER_VIA_GOOGLE', [], ['user_id' => $userId, 'username' => $username, 'email' => $email], 'sys_users', $userId);
            
            $user = $db->table('sys_users')->where('id', $userId)->get()->getRowArray();
        }

        // Establish login session
        $sessionData = [
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'role'       => $user['role'],
            'bidang_id'  => $user['bidang_id'],
            'logged_in'  => true
        ];
        session()->set($sessionData);

        log_activity('LOGIN_VIA_GOOGLE', null, ['user_id' => $user['id'], 'username' => $user['username']], 'sys_users', $user['id']);

        // Telegram Notification
        $roleNames = [
            'admin' => 'Administrator (OPD)',
            'kabid' => 'Kepala Bidang',
            'kaban' => 'Kepala Badan (Kaban)',
            'user'  => 'User Biasa',
            'ormas' => 'Ormas Terdaftar'
        ];
        $roleText = $roleNames[$user['role']] ?? ucfirst($user['role']);
        $ipAddress = $this->request->getIPAddress();

        telegram_send_transaction('🔑 Login Sukses via Google Account', [
            'Username'  => $user['username'],
            'Email'     => $user['email'],
            'Peran'     => $roleText,
            'IP Address'=> $ipAddress
        ]);

        $redirects = [
            'admin' => 'admin',
            'kabid' => 'bidang',
            'kaban' => 'eksekutif',
            'user'  => 'user',
            'ormas' => 'user'
        ];
        $target = $redirects[$user['role']] ?? '/';

        return redirect()->to($target)->with('success', 'Berhasil masuk menggunakan Akun Google: ' . esc($user['email']));
    }
}
