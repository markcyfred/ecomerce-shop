<?php
require_once 'BaseOAuth.php';

class GoogleOAuth extends BaseOAuth {
    
    public function __construct($conn) {
        parent::__construct($conn, 'google');
    }
    
    /**
     * Generate OAuth state parameter for security
     */
    public function generateState() {
        $state = bin2hex(random_bytes(32));
        $_SESSION[OAUTH_STATE_KEY] = $state;
        return $state;
    }
    
    /**
     * Get Google OAuth authorization URL
     */
    public function getAuthUrl() {
        $state = $this->generateState();
        
        $params = [
            'client_id' => GOOGLE_CLIENT_ID,
            'redirect_uri' => GOOGLE_REDIRECT_URI,
            'scope' => GOOGLE_SCOPES,
            'response_type' => 'code',
            'state' => $state,
            'access_type' => 'offline',
            'prompt' => 'consent'
        ];
        
        return GOOGLE_AUTH_URL . '?' . http_build_query($params);
    }
    
    /**
     * Exchange authorization code for access token
     */
    public function getAccessToken($code) {
        $data = [
            'client_id' => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => GOOGLE_REDIRECT_URI
        ];
        
        $result = $this->makeRequest(
            GOOGLE_TOKEN_URL,
            'POST',
            http_build_query($data),
            ['Content-Type: application/x-www-form-urlencoded']
        );
        
        if ($result['http_code'] !== 200) {
            return false;
        }
        
        $tokenData = json_decode($result['response'], true);
        return isset($tokenData['access_token']) ? $tokenData : false;
    }
    
    /**
     * Get user information from Google
     */
    public function getUserInfo($accessToken) {
        $result = $this->makeRequest(
            GOOGLE_USERINFO_URL . '?access_token=' . $accessToken,
            'GET',
            null,
            ['Authorization: Bearer ' . $accessToken]
        );
        
        if ($result['http_code'] !== 200) {
            return false;
        }
        
        $userData = json_decode($result['response'], true);
        
        // Format user data for our system
        return [
            'oauth_id' => $userData['id'],
            'email' => $userData['email'],
            'first_name' => $userData['given_name'] ?? '',
            'last_name' => $userData['family_name'] ?? '',
            'picture' => $userData['picture'] ?? ''
        ];
    }
    
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
        $googleId = mysqli_real_escape_string($this->conn, $userInfo['oauth_id']);
        $picture = mysqli_real_escape_string($this->conn, $userInfo['picture'] ?? '');
        
        // Generate customer code
        $customerCode = $this->generateCustomerCode();
        
        $query = "INSERT INTO users (
            customer_code, first_name, last_name, email, 
            oauth_provider, oauth_id, profile_picture, 
            user_status, role_as, agreed_to_terms
        ) VALUES (
            '$customerCode', '$firstName', '$lastName', '$email',
            'google', '$googleId', '$picture',
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
            'oauth_provider' => 'google'
        ];
        $_SESSION['role_as'] = $userData['role_as'];
        
        return true;
    }
    
    /**
     * Validate OAuth state parameter
     */
    public function validateState($state) {
        return isset($_SESSION[OAUTH_STATE_KEY]) && 
               $_SESSION[OAUTH_STATE_KEY] === $state;
    }
    
    /**
     * Clear OAuth state
     */
    public function clearState() {
        unset($_SESSION[OAUTH_STATE_KEY]);
    }
}
?> 