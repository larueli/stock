<?php


namespace App\Service;


use Swift_Mailer;
use Swift_Message;

/**
 * \class Mail
 *
 * \brief   Permet d'envoyer simplement un mail.
 *
 * @author  Ivann LARUELLE
 * @package App\Service
 */
class Mail
{
    /**
     * \brief Le service de Mail (SwiftMail)
     *
     * @var Swift_Mailer $mailer
     */
    private $mailer;

    /**
     * \brief Le champ from des mails (fourni auto par services.yaml)
     *
     * @var string $fromEmail
     */
    private $fromEmail;

    /**
     * Mail constructor.
     *
     * \brief Ne doit pas être appelé. Ce service est auto-wiré.
     *
     * @param Swift_Mailer $mailer    autowiré par Symfony
     * @param string       $fromEmail hinté (cf services.yaml)
     */
    public function __construct(Swift_Mailer $mailer, $fromEmail)
    {
        $this->mailer    = $mailer;
        $this->fromEmail = $fromEmail;
    }

    /**
     * Permet d'envoyer un mail très simplement.
     *
     * @param string $sujet        Le sujet du mail
     * @param array  $destinataire l'adresse mail du destinataire au format ``['mail' => 'Nom']``
     * @param string $contenu      Le contenu HTML du mail, généré par template TWIG par exemple
     *
     * \note Les templates mails se trouvent dans un dossier à part et ont leur propre base.
     */
    public function envoyerMail(string $sujet, array $destinataire, string $contenu)
    {
        $message = ( new Swift_Message($sujet) )
            ->setFrom([$this->fromEmail => 'Logements UTT'])
            ->setTo($destinataire)
            ->setBody($contenu, 'text/html');
        $this->mailer->send($message);
    }

}