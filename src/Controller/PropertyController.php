<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class PropertyController extends abstractController
{

    /**
     *
     * @var PropertyRepository
     */
    private $repository;


    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/biens", name="property.index")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        //créer une entité qui va représenter notre recheche (nb pièce max + prix max)
        // Créer un formulaire
        //Gérer le traitement dans le controller


        $properties= $paginator->paginate(
            $this->repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );             
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties
        ]);
    }

    /**
     * @Route("/biens/{slug} - {id}", name="property.show", requirements={"slug" : "[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug, $id): Response
    {

        if ($property->getSlug() !==$slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);

        }
        $property = $this->repository->find($id);


        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}