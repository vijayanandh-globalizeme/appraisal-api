<?php 

namespace App\Libraries;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class MSGraph {

    public $oauthClient;

    public function __construct(){
        $this->oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => config('azure.appId'),
            'clientSecret'            => config('azure.appSecret'),
            'redirectUri'             => config('azure.redirectUri'),
            'urlAuthorize'            => config('azure.authority').config('azure.authorizeEndpoint'),
            'urlAccessToken'          => config('azure.authority').config('azure.tokenEndpoint'),
            'urlResourceOwnerDetails' => '',
            'scopes'                  => config('azure.scopes')
        ]);
    }

    public function setAccessToken($authCode){
        // Make the token request
        $accessToken = $this->oauthClient->getAccessToken('authorization_code', [
            'code' => $authCode
        ]);

        $graph = new Graph();
        $graph->setAccessToken($accessToken->getToken());

        $user = $graph->createRequest('GET', '/me')
                      ->setReturnType(Model\User::class)
                      ->execute();
        return $user->getMail();
    }

}