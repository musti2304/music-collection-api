<?php

namespace App\Controller;

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends AbstractController
{

    /**
     * @return Response
     */
    public function authorize(): Response
    {
        $apiConfig = include(__DIR__ . "/../../config/api_config.php");

        if (empty($apiConfig)) {
            die('Failed to load api config');

        }

        $session = new Session(
            $apiConfig['client_id'],
            $apiConfig['client_secret'],
            $apiConfig['redirect_uri']
        );

        $options = [
            'scope' => [
                'user-follow-read'
            ],
        ];

        $authUrl = $session->getAuthorizeUrl($options);

//        if ($authUrl) {
//            header('Location: ' . $session->getAuthorizeUrl($options));
//        }
//        $authUrl = html_entity_decode(urldecode($authUrl));
        var_dump($authUrl);

        $session->requestAccessToken($_GET['code']);
        $accessToken = $session->getAccessToken();
        $refreshToken = $session->getRefreshToken();

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        return $this->json($api->getUserFollowedArtists());

//        $ch = curl_init();
//        curl_setopt_array($ch,
//            [
//                CURLOPT_URL => $authUrl,
//                CURLOPT_RETURNTRANSFER => true,
//            ]
//        );
//        $result = curl_exec($ch);
//        var_dump($result);
//        curl_close($ch);

//        var_dump($_GET['code']);
//        // Login via client id and client secret
//        $authUrl = $session->getAuthorizeUrl($options);
//var_dump($authUrl);
//
//        // Save access token
//        $accessToken = $session->getAccessToken();
//        $api->setAccessToken($accessToken);
//
//
//
//
//        if (!isset($accessToken)) {
//            return $this->json(['success' => false]);
//        }
//
//        $artists = $api->getUserFollowedArtists();
//var_dump($artists);
//        return $this->json([
//            'success' => true,
//        ]);
    }

    public function access(Request $request): Response
    {
        return $this->json([
            'success' => true,
        ]);
    }

}