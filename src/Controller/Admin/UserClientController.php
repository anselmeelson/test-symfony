<?php

namespace App\Controller\Admin;

use App\Entity\Operation;
use App\Entity\Transaction;
use App\Entity\Transfert;
use App\Entity\UserClient;
use App\Form\OperationType;
use App\Form\TransactionType;
use App\Form\TransfertType;
use App\Form\UserClientType;
use App\Repository\UserClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/admin/client")
 */
class UserClientController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="user_client_index", methods={"GET"})
     * @param UserClientRepository $userClientRepository
     * @return Response
     */
    public function index(UserClientRepository $userClientRepository): Response
    {
        return $this->render('user_client/index.html.twig', [
            'user_clients' => $userClientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_client_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userClient = new UserClient();
        $form = $this->createForm(UserClientType::class, $userClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($userClient);
            $entityManager->flush();

            return $this->redirectToRoute('user_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_client/new.html.twig', [
            'user_client' => $userClient,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="user_client_show", methods={"GET|POST"})
     * @param UserClient $userClient
     * @param Request $request
     * @return Response
     */
    public function show(UserClient $userClient, Request $request): Response
    {
        $transcation = new Transaction();
        $transfert = new Transfert();

        $form = $this->createForm(TransactionType::class, $transcation);
        $form->handleRequest($request);

        $list_transaction = $this->getDoctrine()->getRepository(Transaction::class)->findBy(['user_client'=> $userClient]);
        $list_transfert = $this->getDoctrine()->getRepository(Transfert::class)->findBy(['user_client'=> $userClient]);

        $trans_list = [];
        foreach($list_transaction as $new){
            $new->setSolde((float)$new->getSolde());
            $trans_list[] = $new;
        }
        if($form->isSubmitted()) {
            $transcation->setUserClient($userClient);
            $this->getDoctrine()->getManager()->persist($transcation);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("user_client_show", ['id'=>$userClient->getId()]);
        }

        return $this->render('user_client/show.html.twig', [
            'user_client' => $userClient,
            'form_transaction'   => $form->createView(),
            'list_transaction'               => $trans_list,
            'lists_transfert'   => $list_transfert,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_client_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, UserClient $userClient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserClientType::class, $userClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_client/edit.html.twig', [
            'user_client' => $userClient,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user_client_delete", methods={"POST"})
     */
    public function delete(Request $request, UserClient $userClient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userClient->getId(), $request->request->get('_token'))) {
            $entityManager->remove($userClient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_client_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/admin/client/add/operation/{id}", name="add_operation_modal", methods={"GET", "POST"})
     * @param Transfert $transfert
     * @param Request $request
     * @return Response
     */
    public function newOperation(Transfert $transfert,Request $request) {

        $operation = new Operation();
        $form_operation = $this->createForm(OperationType::class, $operation);
        $form_operation->handleRequest($request);



        if($form_operation->isSubmitted() && $form_operation->isValid()) {
            $op = $request->request->all('operation');
            $opi = $request->attributes->all();
            $user_client = $opi['transfert']->getUserClient();
            $operation->setTransfert($transfert);
            if($op['frais']) {
                $transfert->setStatus(false);
                $this->getDoctrine()->getManager()->flush();
            } else {
                $transfert->setStatus(true);
                $this->getDoctrine()->getManager()->flush();
            }

            $this->getDoctrine()->getManager()->persist($operation);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("user_client_show", ['id'=>$user_client->getId()]);
        }

        return $this->render('modal/addOpModal.html.twig', [
            'form_operation'    => $form_operation->createView(),
            'transfert'         => $transfert
        ]);

    }
}
