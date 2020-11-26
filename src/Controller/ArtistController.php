<?php


namespace App\Controller;


use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArtistController extends AbstractController
{

    public function getArtists(Request $request): Response
    {
        $api = new SpotifyWebAPI();
        return $this->json($api->getArtist('2BCF7CstRXVyyH72etqztG?si=yvS-WAwGQR6Agx6zs4cQpw'));

    }

}