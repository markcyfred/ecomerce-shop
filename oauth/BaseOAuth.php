<?php
require_once 'config.php';
require_once '../admin/config/dbcon.php';

abstract class BaseOAuth {
    protected $conn;
    protected $provider;
    
    public function __construct($conn, $provider) {
        $this->conn = $conn;
        $this->provider = $provider;
    }
    
    /**
     * Generate OAuth state parameter for security
     */
    public function generateState() {
        $state = bin2hex(random_bytes(32));
        $_SESSION[OAUTH_STATE_KEY] = $state;
        $_SESSION[OAUTH_PROVIDER_KEY] = $this->provider;
        return $state;
    }
    
    /**
     * Get OAuth authorization URL
     */
    abstract public function getAuthUrl();
    
    /**
     * Exchange authorization code for access token
     */
    abstract public function getAccessToken($code);
    
    /**
     * Get user information from provider
     */
    abstract public function getUserInfo($accessToken);
    
    /**
     * Check if user exists in database
     */
    public function userExists($email) {
        $email = mysqli_real_escape_string($this->conn, $email);
        $query = "SELECT id, oauth_provider FROM users WHERE email = '$email'";
        $result = mysqli_query($this->conn, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        
        return false;
    }
    
    /**
     * Create new user account
     */
    public function createUser($userInfo) {
        $email = mysqli_real_escape_string($this->conn, $userInfo['email']);
        $firstName = mysqli_real_escape_string($this->conn, $userInfo['first_name'] ?? '');
        $lastName = mysqli_real_escape_string($this->conn, $userInfo['last_name'] ?? '');
        $oauthId = mysqli_real_escape_string($this->conn, $userInfo['oauth_id']);
        $picture = mysqli_real_escape_string($this->conn, $userInfo['picture'] ?? '');
        
        // Generate customer code
        $customerCode = $this->generateCustomerCode();
        
        $query = "INSERT INTO users (
            customer_code, first_name, last_name, email, 
            oauth_provider, oauth_id, profile_picture, 
            user_status, role_as, agreed_to_terms
        ) VALUES (
            '$customerCode', '$firstName', '$lastName', '$email',
            '$this->provider', '$oauthId', '$picture',
            'active', '0', '1'
        )";
        
        if (mysqli_query($this->conn, $query)) {
            return [
                'success' => true,
                'user_id' => mysqli_insert_id($this->conn),
                'customer_code' => $customerCode
            ];
        }
        
        return ['success' => false, 'error' => mysqli_error($this->conn)];
    }
    
    /**
     * Generate unique customer code
     */
    private function generateCustomerCode() {
        do {
            $code = 'CUST' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $result = $this->conn->query("SELECT id FROM users WHERE customer_code = '$code'");
        } while ($result && $result->num_rows > 0);
        return $code;
    }
    
    /**
     * Login existing user
     */
    public function loginUser($userData) {
        $_SESSION['auth'] = true;
        $_SESSION['auth_user'] = [
            'id' => $userData['id'],
            'email' => $userData['email'],
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
            'profile_picture' => $userData['profile_picture'],
            'oauth_provider' => $this->provider
        ];
        $_SESSION['role_as'] = $userData['role_as'];
        
        return true;
    }
    
    /**
     * Validate OAuth state parameter
     */
    public function validateState($state) {
        return isset($_SESSION[OAUTH_STATE_KEY]) && 
               $_SESSION[OAUTH_STATE_KEY] === $state &&
               isset($_SESSION[OAUTH_PROVIDER_KEY]) &&
               $_SESSION[OAUTH_PROVIDER_KEY] === $this->provider;
    }
    
    /**
     * Clear OAuth state
     */
    public function clearState() {
        unset($_SESSION[OAUTH_STATE_KEY]);
        unset($_SESSION[OAUTH_PROVIDER_KEY]);
    }
    
    /**
     * Make HTTP request
     */
    protected function makeRequest($url, $method = 'GET', $data = null, $headers = []) {
        $ch = curl_init();
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        }
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return [
            'response' => $response,
            'http_code' => $httpCode
        ];
    }
    
    /**
     * Get user by OAuth ID
     */
    public function getUserByOAuthId($oauthId) {
        $oauthId = mysqli_real_escape_string($this->conn, $oauthId);
        $query = "SELECT * FROM users WHERE oauth_id = '$oauthId' AND oauth_provider = '$this->provider'";
        $result = mysqli_query($this->conn, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        
        return false;
    }
}
?> 