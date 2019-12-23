<?php
/**
 * Created by PhpStorm.
 * User: Isaac
 * Date: 19/12/2019
 * Time: 19:32
 */

namespace App\Controller;


use App\Entity\Property;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;


    public function __construct(PropertyRepository $repository,EntityManagerInterface  $manager )
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index():Response
    {
/*      1.
        $repository = $this->getDoctrine()->getRepository(Property::class);
        dump($repository->findAll());*/

        /*
        2
        $property = $this->repository->findAllVisible();
        $property[0]->setSold(true);
        $this->manager->flush();
        dump($property);*/

        // 3.




        return $this->render('property/index.html.twig' , [
            'current_menu' => 'properties'
        ]);
    }

    /**
     * @Route("/biens/ajouter", name="property.add")
     * @return Response
     *
     */
    public function add(): Response
    {
/*        $property = new Property();
        $property->setTitle('Mon premier bien')
            ->setPrice('200000')
            ->setDescription('Ma belle maison')
            ->setSurface('60')
            ->setRooms(4)
            ->setBedrooms(6)
            ->setFloor(4)
            ->setHeat(1)
            ->setCity('Paris')
            ->setAdress('2 Rue de Vaugirard')
            ->setPostalCode('75015')
            ->setSold(1);

        $em = $this ->getDoctrine()->getManager();
        $em ->persist($property);
        $em->flush();*/


        return $this->render('property/add.html.twig', [
            'current_menu' => 'properties.add'
        ]);
    }

    /**
     * @Route("/biens/{slug}/{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     * @param Property $property
     */
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
            ], 301);

        }
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties.add',
        ]);
    }
}