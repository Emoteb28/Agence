<?php
/**
 * Created by PhpStorm.
 * User: Isaac
 * Date: 19/12/2019
 * Time: 19:32
 */

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    /**
     * @Route ("/", name="home")
     * @param PropertyRepository $repository
     * @return Response
     *
     */
    public function index(PropertyRepository $repository): Response
    {
        $property = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
                'properties' => $property
            ]
        );
    }
}