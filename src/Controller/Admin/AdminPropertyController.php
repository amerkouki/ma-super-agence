<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{

    /**
     *
     * @var PropertyRepository $reposetory
     */
    private $reposetory;

    function __construct(PropertyRepository $reposetory)
    {
        $this->reposetory = $reposetory;
    }
    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index(): Response
    {
        $properties = $this->reposetory->findAll();
        return $this->render('admin/property/index.html.twig', [
            'properties' => $properties,
        ]);
    }




  /**
     * @Route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request)
    {

        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($property);
            $em->flush();
            $this->addFlash('success' , 'bien crée avec success');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/edit.html.twig', [
            'properties' => $property,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/admin/property/{id}", name="admin.property.edit" ,methods="GET|POST")
     */
    public function edit($id, Request $request)
    {
        $property = $this->reposetory->find($id);
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success' , 'bien edite avec success');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig', [
            'properties' => $property,
            'form' => $form->createView()
        ]);
    }
    

 /**
     * @Route("/admin/property/{id}", name="admin.property.delete" , methods="DELETE")
     */
    public function delete($id , Request $request)
    {
        $property = $this->reposetory->find($id );
        
        if($this->isCsrfTokenValid('delete' . $property->getId() , $request->get('_token'))){
            $em = $this->getDoctrine()->getManager();
            $em->remove($property);
            $em->flush();
            $this->addFlash('success' , 'bien supprimer avec success');
          
        }
        return $this->redirectToRoute('admin.property.index');
       
    }

}
