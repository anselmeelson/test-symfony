<?php


namespace App\Functions;


use App\Repository\TransactionRepository;
use App\Repository\TransfertRepository;
use Symfony\Component\Security\Core\Security;

class MyFunction
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;
    /**
     * @var TransfertRepository
     */
    private $transfertRepository;

    /**
     * MyFunction constructor.
     * @param Security $security
     * @param TransactionRepository $transactionRepository
     * @param TransfertRepository $transfertRepository
     */
    public function __construct(Security $security, TransactionRepository $transactionRepository, TransfertRepository $transfertRepository)
    {

        $this->security = $security;
        $this->transactionRepository = $transactionRepository;
        $this->transfertRepository = $transfertRepository;
    }

    public function transfertByUser() {
        return $this->transfertRepository->findBy(['user_client'=>$this->security->getUser()]);
    }

    public function transactionByUser() {
        return $this->transactionRepository->findBy(['user_client'=>$this->security->getUser()]);
    }

    public function getAmount() {
        $count = 0;
        foreach ($this->transactionByUser() as $transaction) {
            $count += (float) $transaction->getSolde();
        }

        $count1 = 0;
        foreach ($this->transfertByUser() as $transfert) {
            $count1 += (float) $transfert->getAmount();
        }

        return $count - $count1;
    }
}