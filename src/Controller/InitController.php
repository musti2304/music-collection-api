<?php


namespace App\Controller;


use mysqli;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InitController extends AbstractController
{


    public function init(Request $request): Response
    {
        // Create DB connection
        $db = new mysqli('localhost:3306', 'root', 'root', 'collections');
        $api = new SpotifyWebAPI();

        // Get the content
        $content = $request->getContent();
        var_dump($content);
        $accessToken = $request->get('access_token');

        // Get the access token
        $api->setAccessToken($accessToken);

        // Get all artists of the user
        $artists = $api->getUserFollowedArtists();

        // Get the id, name of the artists
        $jsonArtists = json_decode($artists, true, 512, JSON_THROW_ON_ERROR);

        foreach ($jsonArtists['artists']['items'] as $data) {
            $artist = new Artist($data['id'], $data['name']);

            // Save artists in table
            $result = $db->query('INSERT IGNORE INTO artists (artist_id, artist_name) VALUES 
                            (' .$artist->getId().','.$artist->getName().');'
            );

        }


        // Create DB tables
        /*$db->query('CREATE TABLE artists
                        (
                            id int(10) UNIQUE NOT NULL,
                            artist_id VARCHAR(100) NOT NULL,
                            artist_name VARCHAR(100) NOT NULL
                        );'
        );*/

        // return the table contents to the client

    }

}