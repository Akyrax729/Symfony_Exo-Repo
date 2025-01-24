<?php

namespace App\Controller;


use App\Form\FilterType;
use App\Repository\SurvivantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class FiltreSurvivantController extends AbstractController
{
    #[Route('/filtre/survivant', name: 'app_filtre_survivant')]
    public function index(SurvivantRepository $repository, Request $request): Response
    {
       
        $form = $this->createForm(FilterType::class);

        $form->handleRequest($request);

        $postDataPower = $request->get('minPower', 0);
        $postDataClass = $request->get('class', 'all');
        $postDataRace = $request->get('race', 'all');



        if ($form->isSubmitted()&&$form->isValid()){
            $data = $form->getData();
            // dd($data);

            $postDataPower = $form->get('minPower')->getData();
            $postDataRace = $form->get('race')->getData();
            $postDataClass = $form->get('class')->getData();

            if ($postDataRace != null){ 
                $postDataRace = $postDataRace->getRaceName();
            } 

            if ($postDataClass != null){ 
                $postDataClass = $postDataClass->getClassName();
            } 


            

            // dump($postDataPower);
            // dump($postDataRace);
            // dd($postDataClass);
            $filter = '1';
            
        } else {
            $filter = null;
        }

        


        if ($filter == null){
            $survivants = $repository->findAll();

        } else {

            // $survivants = $repository->filterFormPower($postDataPower);
            // $survivants = $repository->filterFormClass($postDataClass);
            // $survivants = $repository->filterFormRace($postDataRace);

            $survivants = $repository->filterForm($postDataPower, $postDataRace, $postDataClass);
            // $survivants = $repository->filterForm(10, 2, 2);
        }

        


       
        return $this->render('filtre_survivant/filtreSurvivant.html.twig', [
            'survivants' => $survivants,
            'filterform'=>$form->createView(),
        ]);
    }
}



