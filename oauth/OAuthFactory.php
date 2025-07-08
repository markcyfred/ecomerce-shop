<?php
require_once 'BaseOAuth.php';
require_once 'GoogleOAuth.php';
require_once 'GitHubOAuth.php';

class OAuthFactory {
    
    /**
     * Create an OAuth instance for the specified provider
     * 
     * @param string $provider The OAuth provider name
     * @param mysqli $conn Database connection
     * @return BaseOAuth|null OAuth instance or null if provider not supported
     */
    public static function create($provider, $conn) {
        switch (strtolower($provider)) {
            case 'google':
                return new GoogleOAuth($conn);
            case 'github':
                return new GitHubOAuth($conn);
            default:
                return null;
        }
    }
    
    /**
     * Get all supported providers
     * 
     * @return array Array of supported provider names
     */
    public static function getSupportedProviders() {
        return ['google', 'github'];
    }
    
    /**
     * Check if a provider is supported
     * 
     * @param string $provider Provider name
     * @return bool True if supported, false otherwise
     */
    public static function isSupported($provider) {
        return in_array(strtolower($provider), self::getSupportedProviders());
    }
    
    /**
     * Get provider display name
     * 
     * @param string $provider Provider name
     * @return string Display name or original name if not found
     */
    public static function getProviderName($provider) {
        $providers = OAUTH_PROVIDERS;
        return $providers[strtolower($provider)] ?? ucfirst($provider);
    }
    
    /**
     * Get provider color
     * 
     * @param string $provider Provider name
     * @return string Color hex code or default color
     */
    public static function getProviderColor($provider) {
        $colors = OAUTH_PROVIDER_COLORS;
        return $colors[strtolower($provider)] ?? '#666666';
    }
    
    /**
     * Get provider icon class
     * 
     * @param string $provider Provider name
     * @return string Icon CSS class
     */
    public static function getProviderIcon($provider) {
        $icons = OAUTH_PROVIDER_ICONS;
        return $icons[strtolower($provider)] ?? 'fas fa-user';
    }
}
?> 