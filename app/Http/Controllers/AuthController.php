<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DBController;
use App\Constants;
use DB;
use App\TableData;
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

		$memberOf = $graph->createRequest('GET', '/me/memberOf')
						  ->setReturnType(Model\Group::class)
						  ->execute();

		$groups = array_values($memberOf);
		$groupIds = [];
		foreach($groups as $group) {
			if (($group->getProperties()['id'] === env('READ_WRITE_GROUP_ID')) ||
				($group->getProperties()['id'] === env('READ_WRITE_ASSIGNED_ID'))) {
				return redirect()->route('dbedit');
			}
		}
		return redirect()->route('accessdenied');
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
  header('Location: '.$authorizationUrl);
  exit();
}
}