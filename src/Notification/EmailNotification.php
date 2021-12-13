<?php
namespace App\Notification;

use App\Entity\UserClient;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class EmailNotification {

    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $environment;

    public function __construct(MailerInterface $mailer , Environment $environment)
    {

        $this->mailer = $mailer;
        $this->environment = $environment;
    }

    public function sendConfirmation(UserClient $client) {
        $email = (new Email())
            ->from("anselmehotegni@gmail.com")
            ->to($client->getEmail())
            ->subject("csc")
            ->text("oko")
            ->html("okoo")
        ;

        $this->mailer->send($email);
    }

}