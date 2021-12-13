<?php 

namespace App\Controller;

use App\Functions\MyFunction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/account")
 * Undocumented class
 */
class AccountController extends AbstractController
{

    /**
     * @var Security
     */
    private $security;
    /**
     * @var MyFunction
     */
    private $myFunction;

    /**
     * AccountController constructor.
     * @param Security $security
     * @param MyFunction $myFunction
     */
    public function __construct(Security $security, MyFunction $myFunction)
    {
        $this->security = $security;
        $this->myFunction = $myFunction;
    }
    /**
     * @Route("/", name="home") 
     * @return Response
     */
    public function index (): Response {
        $trans_alert = [];
        foreach ($this->myFunction->transfertByUser() as $transfert) {
            if(!$transfert->getStatus()) {
                $trans_alert[] = $transfert;
            }
        }
        return $this->render("account/index.html.twig", [
            'transferts'  => $this->myFunction->transfertByUser(),
            'trans_alert'   => $trans_alert,
            'current_page'  => 'home'
        ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile() {
        return $this->render('account/profile.html.twig', [
            'current_page'  => 'profile'
        ]);
    }

}