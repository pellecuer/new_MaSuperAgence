<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);



        $properties= $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );             
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'form' =>$form->createView()
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