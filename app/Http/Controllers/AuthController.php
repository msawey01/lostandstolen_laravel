<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class AuthController extends Controller
{

public function gettoken()
{
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  // Authorization code should be in the "code" query param
  if (isset($_GET['code'])) {
    // Check that state matches
	print_r(array_keys($_SESSION));
    if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth_state'])) {
      exit('State provided in redirect does not match expected value.');
    }

    // Clear saved state
    unset($_SESSION['oauth_state']);

    // Initialize the OAuth client
    $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
      'clientId'                => env('OAUTH_APP_ID'),
      'clientSecret'            => env('OAUTH_APP_PASSWORD'),
      'redirectUri'             => env('OAUTH_REDIRECT_URI'),
      'urlAuthorize'            => env('OAUTH_AUTHORITY').env('OAUTH_AUTHORIZE_ENDPOINT'),
      'urlAccessToken'          => env('OAUTH_AUTHORITY').env('OAUTH_TOKEN_ENDPOINT'),
      'urlResourceOwnerDetails' => '',
      'scopes'                  => env('OAUTH_SCOPES')
    ]);

    try {
		// Make the token request
		$accessToken = $oauthClient->getAccessToken('authorization_code', [
			'code' => $_GET['code']
		]);

		// Save the access token and refresh tokens in session
		// This is for demo purposes only. A better method would
		// be to store the refresh token in a secured database
		$tokenCache = new \App\TokenStore\TokenCache;
		$tokenCache->storeTokens($accessToken->getToken(), $accessToken->getRefreshToken(),
        $accessToken->getExpires());
		
		$graph = new Graph();
		$graph->setAccessToken($tokenCache->getAccessToken());
		
		$user = $graph->createRequest('GET', '/me')
					  ->setReturnType(Model\User::class)
					  ->execute();

		$userName = $user->getDisplayName();
		$properties = $user->getProperties();
		$id = $properties['id'];
		echo $id;
		$request = '/myorganization/users/'.$properties['id'].'/checkMemberGroups';
		echo $request;

//		$groupIds = $graph->createRequest('GET', '/myorganization/users/'.$properties['id'].'/checkMemberGroups')
//			  ->setReturnType(Model\Group::class)
//			  ->execute();

#		echo $groupIds;
		// Redirect back to mail page
//		return redirect()->route('dbedit', ['token' => $accessToken->getToken(), 'username' => $userName, 'prop' => $properties['id']]);
    }
    catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
      exit('ERROR getting tokens: '.$e->getMessage());
    }
    exit();
  }
 }
public function signin() 
{
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  // Initialize the OAuth client
  $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
    'clientId'                => env('OAUTH_APP_ID'),
    'clientSecret'            => env('OAUTH_APP_PASSWORD'),
    'redirectUri'             => env('OAUTH_REDIRECT_URI'),
    'urlAuthorize'            => env('OAUTH_AUTHORITY').env('OAUTH_AUTHORIZE_ENDPOINT'),
    'urlAccessToken'          => env('OAUTH_AUTHORITY').env('OAUTH_TOKEN_ENDPOINT'),
    'urlResourceOwnerDetails' => '',
    'scopes'                  => env('OAUTH_SCOPES')
  ]);

  // Generate the auth URL
  $authorizationUrl = $oauthClient->getAuthorizationUrl();
  // Save client state so we can validate in response
  $_SESSION['oauth_state'] = $oauthClient->getState();

  // Redirect to authorization endpoint
  echo 'Authorization URL '.$authorizationUrl;
  header('Location: '.$authorizationUrl);
  exit();
}
}