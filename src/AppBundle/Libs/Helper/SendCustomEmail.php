<?php

namespace AppBundle\Libs\Helper;

/**
 * Description of BuildBodyMail
 *
 * @author rene
 */
class SendCustomEmail {

    private $container;
    private $case;
    private $payment;
    private $dir;

    public function __construct($container) {
        $this->container = $container;
        $this->dir = $this->container->getParameter('kernel.root_dir') . '/../var/logs/emails/';
    }

    /* type mail = 1  cuando se inserte un
     *  pago se envie un correo notificando al 
     *  cliente y al supervisor que se pago el caso asociado. */
    /* type mail = 2  Cuando se modifica un caso hay que notificar al supervisor. */

    public function sendMessage($typeMail) {
        try {
            switch ($typeMail) {
                case 1:
                    if ($this->container->getParameter('send_create_payment')) {
                        $this->setCase($this->payment->getCaso());
                        $body = 'Estimado supervisor el presente correo es para informarle que se ha insertado un nuevo pago con un total pagado de $' . $this->payment->getValorPagado() . ' al caso con nombre ' . $this->case->getNombre();
                        $bodyClient = 'Estimado cliente el presente correo es para informarle que usted ha realizado un pago con un total de $' . $this->payment->getValorPagado() . ' al caso con nombre ' . $this->case->getNombre();
                        $this->sendEmailToSupervisor($body, 'Pago realizado');
                        $this->sendEmailToClient($bodyClient, 'Pago realizado');
                    }
                    break;
                case 2:
                    if ($this->container->getParameter('send_update_case')) {
                        $body = 'Estimado supervisor el presente correo es para informarle que se ha modificado el caso con nombre ' . $this->case->getNombre();
                        $this->sendEmailToSupervisor($body, 'Caso modificado');
                    }
                    break;
                case 3:
                    if ($this->container->getParameter('send_create_case')) {
                        $body = 'Estimado supervisor el presente correo es para informarle que se ha creado el caso con nombre ' . $this->case->getNombre();
                        $this->sendEmailToSupervisor($body, 'Caso creado');
                    }
                    break;
                case 4:
                    if ($this->container->getParameter('send_update_payment')) {
                        $this->setCase($this->payment->getCaso());
                        $body = 'Estimado supervisor el presente correo es para informarle que se ha actualizado un pago con un total pagado de $' . $this->payment->getValorPagado() . ' al caso con nombre ' . $this->case->getNombre();
                        $this->sendEmailToSupervisor($body, 'Pago actualizado');
                    }
                    break;
            }
        } catch (\Exception $e) {
            
        }
    }

    private function registerTraceOfEmail($text) {
        try {
            $date = new \DateTime('now');
            $date = $date->format('Ymd-H-i-s');
            $myfile = fopen($this->dir . ($date.uniqid()) . ".log", "w");

            fwrite($myfile, $text);
        } catch (\Exception $e) {
            
        }
    }

    public function sendEmailToSupervisor($body, $subject) {
        $usersSupervisor = $this->container->get('doctrine')->getRepository('AppBundle:AGUsuario');
        $usersSupervisor = $usersSupervisor->findAllUserSupervisor();

        $repoClient = $this->container->get('doctrine')->getRepository('AppBundle:AGEmpresa');
        $mainCompany = $repoClient->findOneBy(array('tipoCliente' => 3));
        if ($mainCompany) {
            foreach ($usersSupervisor as $user) {
                $message = \Swift_Message::newInstance()
                        ->setSubject($subject)
                        ->setFrom($mainCompany->getCorreo())
                        ->setTo($user->getCorreo())
                        ->setBody($body);
                try {
                    $send = $this->container->get('swiftmailer.mailer.default')->send($message);

                    if ($send) {
                        $this->registerTraceOfEmail('Enviado satisfactoriamente el correo para ' . $user->getCorreo() . ' con cuerpo ' . $body);
                    } else {
                        $this->registerTraceOfEmail('No se pudo enviar el correo para ' . $user->getCorreo() . ' con asunto ' . $subject . ' y cuerpo ' . $body);
                    }
                } catch (\Exception $e) {
                    $this->registerTraceOfEmail('No se pudo enviar el correo para ' . $user->getCorreo() . ' con asunto ' . $subject . ' y cuerpo ' . $body);
                }
            }
        }
    }

    private function sendEmailToClient($body, $subject) {

        $usersClient = $this->payment->getCaso()->getEmpresa();

        $repoClient = $this->container->get('doctrine')->getRepository('AppBundle:AGEmpresa');
        $mainCompany = $repoClient->findOneBy(array('tipoCliente' => 3));
        if ($mainCompany && $usersClient) { {
                $message = \Swift_Message::newInstance()
                        ->setSubject($subject)
                        ->setFrom($mainCompany->getCorreo())
                        ->setTo($usersClient->getCorreo())
                        ->setBody($body);
                try {
                    $send = $this->container->get('swiftmailer.mailer.default')->send($message);

                    if ($send) {
                        $this->registerTraceOfEmail('Enviado satisfactoriamente el correo para ' . $usersClient->getCorreo() . 'con asunto ' . $subject . ' y  cuerpo ' . $body);
                    } else {
                        $this->registerTraceOfEmail('No se pudo enviar el correo para ' . $usersClient->getCorreo() . 'con asunto ' . $subject . ' y cuerpo ' . $body);
                    }
                } catch (\Exception $e) {
                    $this->registerTraceOfEmail('No se pudo enviar el correo para ' . $usersClient->getCorreo() . 'con asunto ' . $subject . ' y  cuerpo ' . $body);
                }
            }
        }
    }
    public function sendEmailToCustomClient($email,$body, $subject) {



        $repoClient = $this->container->get('doctrine')->getRepository('AppBundle:AGEmpresa');
        $mainCompany = $repoClient->findOneBy(array('tipoCliente' => 3));
        $send=false;
        if ($mainCompany) { {
            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($mainCompany->getCorreo())
                ->setTo($email)
                ->setBody($body);
            try {
                $send = $this->container->get('swiftmailer.mailer.default')->send($message);

                if ($send) {
                    $this->registerTraceOfEmail('Enviado satisfactoriamente el correo para ' .$email. 'con asunto ' . $subject . ' y  cuerpo ' . $body);
                } else {
                    $this->registerTraceOfEmail('No se pudo enviar el correo para ' . $email . 'con asunto ' . $subject . ' y cuerpo ' . $body);
                }
            } catch (\Exception $e) {
                $this->registerTraceOfEmail('No se pudo enviar el correo para ' .$email. 'con asunto ' . $subject . ' y  cuerpo ' . $body);
            }
        }
        }
        return $send;
    }

    public function setCase($case) {
        $this->case = $case;
    }

    public function setPayment($payment) {
        $this->payment = $payment;
    }

}
