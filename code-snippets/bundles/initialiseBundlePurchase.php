function initiate_bundle_purchase(){
    // Set up Auth0 authentication
    $auth0 = new \Auth0\SDK\Auth0([
        'domain' => 'YOUR_AUTH0_DOMAIN',
        'clientId' => 'YOUR_CLIENT_ID',
        'clientSecret' => 'YOUR_CLIENT_SECRET',
        'cookieSecret' => 'YOUR_COOKIE_SECRET'
    ]);
    
    // Redirect to Auth0 login page
    header('Location: ' . $auth0->login('YOUR_REDIRECT_URL'));
    exit;
}
