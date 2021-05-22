<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $reposetory;
    /**
     * @var ObjectManager
     */
    private $em;
    public function __construct(PropertyRepository $reposetory)
    {
        $this->reposetory = $reposetory;
    }

    /**
     * @Route("/biens" , name ="property.index")
     */
    public function index(PaginatorInterface $paginator , Request $request): Response
    {
        /*
       //insert into Property
       $property =new Property();
        $property->setTitle('mon premier bien')
        ->setPrice(2000)
        ->setRooms(4)
        ->setBedrooms(3)
        ->setDescription('description')
        ->setSurface(60)
        ->setFloor(4)
        ->setHeat(1)
        ->setCity('Sousse')
        ->setAddress('mon address')
        ->setPostalCode('9090');
        $em=$this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush();
        */

        $search =new PropertySearch();
        $form =$this->createForm(PropertySearchType::class , $search);
        $form->handleRequest($request);
        
        $properties = $paginator->paginate(
            $this->reposetory->findAllVisibeQuery($search) ,
            $request->query->getInt('page' , 1),
            12
        );
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'form'  =>$form->createView()
        ]);
    }



    /**
     * @Route("/biens/{slug}-{id}" , name ="property.show" , requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */

    public function show(string $slug ,$id): Response
    {
       
        $property =$this->reposetory->find($id);
        if($property->getSlug() !== $slug){
           return $this->redirectToRoute('property.show',[
               'id' => $property->getId(),
               'slug' =>$property->getSlug()
            ],
            302);
        }
        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property
        ]);
    }
}
