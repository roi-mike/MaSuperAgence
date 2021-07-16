<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    private $repository;
    private $em;
    

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em){
        $this->repository = $repository;
        $this->em = $em;
    }



    /**
     * @Route("/biens", name="property")
     */

    public function index(): Response
    {
        // $property = new Property();

        // $property->setTitle('Mon premier bien')
        // ->setPrice(20000000)
        // ->setRooms(6)
        // ->setBedrooms(3)
        // ->setDescription('Une petite description')
        // ->setSurface(60)
        // ->setFloor(4)
        // ->setHeat(1)
        // ->setCity('Sucy En Brie')
        // ->setAddress('15 Boulevard Gambetta')
        // ->setPostalCode('94370');
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($property);
        // $em->flush();

        $property = $this->repository->findAllVisible();
        $this->em->flush();
        
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
        ]);
    }


    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug":"[a-z0-9\-]*"})
     * #return Response
     */

     public function show($slug, $id): Response{
        $property = $this->repository->find($id);

        if($property->getSlug() !== $slug){
            return $this->redirectToRoute('property.show',[
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
            ], 301);
        }


        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties',
        ]);
     }
}
