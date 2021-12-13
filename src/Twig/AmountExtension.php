<?php

namespace App\Twig;

use App\Entity\Transaction;
use App\Entity\Transfert;
use App\Repository\TransactionRepository;
use App\Repository\TransfertRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AmountExtension extends AbstractExtension
{
    /**
     * @var TransfertRepository
     */
    private $transfertRepository;
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var Security
     */
    private $security;

    /**
     * AmountExtension constructor.
     * @param TransfertRepository $transfertRepository
     * @param TransactionRepository $transactionRepository
     * @param Environment $twig
     * @param Security $security
     */
    public function __construct(TransfertRepository $transfertRepository, TransactionRepository $transactionRepository, Environment $twig, Security $security) {
        $this->transfertRepository = $transfertRepository;
        $this->transactionRepository = $transactionRepository;
        $this->twig = $twig;
        $this->security = $security;
    }

    public function getFunctions() : array
    {
        return [
            new TwigFunction('totalAmount', [$this, 'getAmount'], ['is_safe' => ['html']]),
            new TwigFunction('totalPourcentage', [$this, 'getPourcentage'], ['is_safe' => ['html']])
        ];
    }

    public function getAmount($entity) : string {
        $transferts = $this->transfertRepository->findBy(['user_client'=>$entity]);
        $transactions = $this->transactionRepository->findBy(['user_client'=>$entity]);
        $count1 = 0;
        foreach ($transactions as $transaction) {
            $count1 += (float) $transaction->getSolde();
        }
        $count2 = 0;
        foreach ($transferts as $transfert) {
            $count2 += (float) $transfert->getAmount();
        }

        return $this->twig->render('partials/amount.html.twig', [
            'totalAmount'   => $count1-$count2
        ]);
    }

    public function getPourcentage($entity) : string {
        $pourcentage = 0;
        foreach ($entity->getOperations() as $operation) {
            $pourcentage += $operation->getPourcentage();
        }
        return $this->twig->render('partials/pourcentage.html.twig', [
            'pourcentage'   => $pourcentage
        ]);
    }
}