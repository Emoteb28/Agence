<?php

namespace App\Controller\Admin;

use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;

class AdminPropertyController extends AbstractController
{

    /**
     * AdminPropertyController constructor.
     * @param PropertyRepository $repository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/administration", name="admin.property.index")
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("administration/property/create", name="admin.property.new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('succes', 'Bien crée');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/new.html.twig', [
            'properties' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Property $property
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/administration/property/{id}", name="admin.property.edit",  methods="GET|POST")
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('succes', 'Bien modifié');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/edit.html.twig', [
            'properties' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administration/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @return Response
     */
    public function delete(Property $property, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {

            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('succes', 'Bien effacé ');
            //return new Response('suppression');
        }
        return $this->redirectToRoute('admin.property.index');

    }
}
