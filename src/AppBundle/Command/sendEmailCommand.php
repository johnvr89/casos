<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Console\Style\SymfonyStyle;

class sendEmailCommand extends ContainerAwareCommand {

    private $io;

    /**
     * Basic configuration of command [name, parameters]
     */
    protected function configure() {

        $this->setName('payemail')
                ->setDescription('Enviar correo a clientes que deben casos');
    }

    /**
     * Run the command functionality
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        try {
            $this->io = new SymfonyStyle($input, $output);
            $container = $this->getContainer();
            $repoClient = $container->get('doctrine')->getRepository('AppBundle:AGEmpresa');
            $mainCompany = $repoClient->findOneBy(array('tipoCliente' => 3));
            if ($mainCompany == null) {
                throw new \Exception('No existe la empresa rectora.');
            }
            $clients = $repoClient->getClientWithPaymet();
            $emailCompany = $mainCompany->getCorreo();
            $countEmails = count($clients);

            if ($countEmails == 0) {
                $this->io->block("INFO: No existen pagos pendientes para mañana");
                //$output->writeln("INFO: No existen pagos pendientes para mañana");
            } else {
                $this->io->block("Enviando correos " . 'Total a enviar: ' . $countEmails);
                // $output->writeln("Enviando correos " . 'Total a enviar: ' . $countEmails);
                $countOK = 0;
                $nameClient=array();
                foreach ($clients as $client) {
                    $nameClient[]=$client->getNombre();
                    $send=false;
                   try{
                       $send=  $this->getContainer()->get('manager.email')->sendEmailToCustomClient($client->getCorreo(),'Estimado cliente el presente correo es para informarle que debe de realizar un pago en el dia de mañana y su deuda es de:$'.$client->getTotalDeuda().'.','Recordatorio de pago');

                   }
                   catch (\Exception $e) {
                       $this->io->error($e->getMessage());
                   }
                    if ($send) {
                        $this->io->success($client->getCorreo());

                        $countOK++;
                    } else {
                        $this->io->error($client->getCorreo());
                    }
                }
                $message='';
                if(count($nameClient)==1){
                  $message='el cliente que debe de pagar mañana es: '.$nameClient[0];
                }else{
                    $message=' los clientes que deben de pagar mañana son: '
                        .implode(',',array_diff($nameClient,array($nameClient[count($nameClient)-1]))).' y '.$nameClient[count($nameClient)-1].
                        '.';
                }

                $this->getContainer()->get('manager.email')->sendEmailToSupervisor('Estimado supervisor '.$message,'Clientes que deben pagar mañana');
                if ($countOK == 0) {
                    $this->io->error("Fall&oacute; el env&iacute;o de correos.");
                } else if ($countOK != $countEmails) {
                    $this->io->warning("Fall&oacute; el env&iacute;o de'.$countEmails-$countOK.' correos.");
                } else {
                    $this->io->success("Correos enviados satisfactoriamente");
                }
            }
        } catch (\Exception $e) {
            $this->io->error($e->getMessage());
        }
    }

    /**
     * Load errors
     * @param type $host Server
     * @return type Information loading procedure
     */
    public function sendEmail($email, $emailCompany,$deuda=0) {
        $message = \Swift_Message::newInstance()
                ->setSubject('Recordatorio de pago')
                ->setFrom($emailCompany)
                ->setTo($email)
                ->setBody('Estimado cliente el presente correo es para informarle que debe de realizar un pago en el dia de mañana y su deuda es de:$'.$deuda.'.');
        /*
          ->setBody('Estimado Cliente le enviamos el presente correo '
          . 'para recordarle que mañana debe de pagar el'
          . ' proximo cobro del caso pendiente en nuestra empresa.'); */


        return $this->getContainer()->get('swiftmailer.mailer.default')->send($message);
    }

}
