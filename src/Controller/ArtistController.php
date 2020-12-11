<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

class ArtistController extends AbstractController
{
//    /**
//     * @Route("/artist", name="artist")
//     */
//    public function index(): Response
//    {
//        return $this->render('artist/index.html.twig', [
//            'controller_name' => 'ArtistController',
//        ]);
//    }

    /**
     * @Route("/api/v1/artists", name="get_artists", methods={"GET"})
     * @return Response
     */
    public function getArtists(): Response
    {

        // Fetch all the artist
        $repository = $this->getDoctrine()->getRepository(Artist::class);
        $artists = $repository->findAll();

        $data = [
            'success' => true,
            'artists' => $artists,
        ];
//        var_dump($data);

        if (!$artists) {
            throw $this->createNotFoundException('Artists not found');
        }

//        var_dump($this->json($data));
        return $this->json($data);
    }

    /**
     * @Route("/api/v1/artists/{id}", name="get_artist", methods={"GET"})
     * @param string $id
     * @return Response
     */
    public function getArtist(string $id): Response
    {
        $em = $this->getDoctrine()->getManager();
//        dd($em);
        $artist = $em->getRepository(Artist::class)->find($id);
//        dd($artist);
//        $artist = $this->getDoctrine()
//            ->getRepository(Artist::class)
//            ->find($id);

        if (!$artist) {
            throw $this->createNotFoundException('Artist with id '.$id.' not found');

        }

        return $this->json($artist);
    }
}
