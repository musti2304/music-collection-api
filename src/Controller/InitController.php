<?php


namespace App\Controller;


use App\Entity\Artist;
use Exception;
use JsonException;
use mysqli;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class InitController extends AbstractController
{

    /**
     * @Route("/api/v1/init", name="initialize", methods={"POST"})
     * @param ValidatorInterface $validator
     * @param Request $request
     * @return Response
     * @throws JsonException
     */
    public function init(ValidatorInterface $validator, Request $request): Response
    {

        // Create DB connection
        $entityManager = $this->getDoctrine()->getManager();
//        $db = new mysqli('localhost', 'root', 'root', 'collections');
        $api = new SpotifyWebAPI();


        // Get the content
        $content = $request->getContent();
        var_dump($content);
        $accessToken = $request->get('access_token');

        // Get the access token
        $api->setAccessToken($accessToken);

        // Get all artists of the user
        $artists = $api->getUserFollowedArtists(['limit' => 1]);
        // Get the id, name of the artists
//        $jsonArtists = json_decode($artists, true);

        $jsonArtists = json_encode($artists, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
//        var_dump($jsonArtists);
        $arrayArtists = json_decode($jsonArtists, true, 512, JSON_THROW_ON_ERROR);
//        var_dump($arrayArtists);
        foreach ($arrayArtists['artists']['items'] as $data) {
            $artist = new Artist();
            $artist->setArtistId($data['id']);
            $artist->setArtistName($data['name']);

            // Save artists in table
            try {
                $entityManager->persist($artist);
                $entityManager->flush();

                $errors = $validator->validate($artist);
                if (count($errors) > 0) {
                    print_r((string)$errors, 400);
                }

                print_r("artists saved");

            } catch (Exception $exception) {
                $exception->getMessage();
            }

            /*$query = 'INSERT INTO artist (artist_id, artist_name) VALUES
                            ("'. $artist->getArtistId() . '","' . $artist->getArtistName() . '")';
            $result = $db->query($query);*/

//            var_dump($result);
            var_dump($artist->getArtistName());
            var_dump($artist->getArtistId());
//            if ($result) {
//                continue;
//            } else {
//                throw new \Exception("Error inserting");
//            }


        }


        // Create DB tables
        /*        $db->query('CREATE TABLE artist
                                (
                                    id int(10) UNIQUE NOT NULL,
                                    artist_id VARCHAR(100) NOT NULL,
                                    artist_name VARCHAR(100) NOT NULL
                                );'
                );*/

        // return the table contents to the client
//        $result = $db->query('SELECT artist_id, artist_name FROM artist');
//        $result = $db->query('SELECT count(1) FROM artist');
//        $row = mysqli_num_rows($result);
//        if (!$result) {
//            throw $this->createNotFoundException('No elements in table artist');
//        }
//        while ($row = mysqli_fetch_assoc($result)) {
//
//            $data .= [
//                'id' => $row['artist_id'],
//                'name' => $row['artist_name']
//            ];
//
//        }
//        $jsonData = json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);

        return $this->json(
            [
                'success' => true,
            ]
        );
    }

}