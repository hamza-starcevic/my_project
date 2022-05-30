<?php

namespace App\Controller;

use App\Entity\Crud;
use App\Form\CrudType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    public function someAction(Request $request) {
        // access Doctrine
        $this->doctrine;
    }




    #[Route('/', name: 'main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    /**
     * @Route("create", name="create")
     */
    public function create(Request $request){
            $crud = new Crud();
            $form = $this->createForm(CrudType::class, $crud);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
            $me = $this->doctrine->getManager();
            $me->persist($crud);
            $me->flush();
            $this->addFlash('notce','Submitted successfully!');
            return $this->redirectToRoute('main');
            }
            return $this->render('main/create.html.twig', [
                'form' => $form->createView()
            ]);
    }
}

