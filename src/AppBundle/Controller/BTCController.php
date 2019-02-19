<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\FosUser;
use AppBundle\Services\Helpers;
use AppBundle\Entity\Transferencia;
use AppBundle\Entity\Cuenta;
use AppBundle\Entity\Moneda;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BTCController extends Controller {

    /**
     * @Route("/btccomprar", name="btccomprar")
     */
    public function btccomprarAction(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $db = $this->getDoctrine();
        $cuenta_repository = $db->getRepository(Cuenta::class);
        $query = $cuenta_repository->createQueryBuilder('c')
                ->where('c.fosUser = :usuario and c.moneda= :moneda')
                ->setParameter('usuario', $user->getId())
                ->setParameter('moneda', Moneda::ARS)
                ->getQuery();
        $cuenta = $query->getResult();
        $cuenta = $cuenta[0];
        $operacion = new \AppBundle\Entity\Operaciones();
        $form = $this->createFormBuilder($operacion)
                ->add('origen_importe', MoneyType::class, array('currency' => 'USD', 'label' => 'Importe:', 'attr' => array('class' => 'form-control', 'style' => 'width:200px;')))
                ->add('save', SubmitType::class, array('label' => 'Comprar', 'attr' => array('class' => 'btn btn-primary')))
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $query = $cuenta_repository->createQueryBuilder('c')
                    ->where('c.fosUser = :usuario and c.moneda= :moneda')
                    ->setParameter('usuario', $user->getId())
                    ->setParameter('moneda', Moneda::BTC)
                    ->getQuery();
            $cuentaBTC = $query->getResult();
            $cuentaBTC = $cuentaBTC[0];
            $operacion = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            try {
                // SE CREA LA OPERACION BTC
                $helpers = new Helpers();
                $cotizacion = $helpers->cotizacionARS_BTC();
                $cotizacion = $cotizacion->bpi->USD->rate_float;
                $operacion->setOrigenCuenta($cuenta);
                $operacion->setDetalle("Compra BTC");
                $operacion->setFecha(new \DateTime('now'));
                $btc = round($operacion->getOrigenImporte() / ($cotizacion * 1.05), 8);
                $operacion->setDestinoImporte($btc);
                $operacion->setCotizacion($cotizacion);
                $operacion->setDestinoCuenta($cuentaBTC);
                $em->persist($operacion);
                $em->flush();

                $cuenta->setsaldo($cuenta->getsaldo() - $operacion->getOrigenImporte());
                $em->persist($cuenta);
                $em->flush();

                //$cuentaBTC->setsaldo($cuentaBTC->getsaldo() + $btc);
               // $em->persist($cuentaBTC);
               // $em->flush();

                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }
            $this->addFlash('notice', "Operacion registrada.");
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('default/btccomprar.html.twig', array(
                    'form' => $form->createView(), 'cuenta' => $cuenta, 'helpers' => new Helpers
        ));
    }

    /**
     * @Route("/btcvender", name="btcvender")
     */
    public function btcvenderAction(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $db = $this->getDoctrine();
        $cuenta_repository = $db->getRepository(Cuenta::class);
        $query = $cuenta_repository->createQueryBuilder('c')
                ->where('c.fosUser = :usuario and c.moneda= :moneda')
                ->setParameter('usuario', $user->getId())
                ->setParameter('moneda', Moneda::BTC)
                ->getQuery();
        $cuentaBTC = $query->getResult();
        $cuentaBTC = $cuentaBTC[0];
        $operacion = new \AppBundle\Entity\Operaciones();
        $form = $this->createFormBuilder($operacion)
                ->add('origen_importe', \Symfony\Component\Form\Extension\Core\Type\NumberType::class, array('label' => 'Importe:', 'attr' => array('class' => 'form-control', 'style' => 'width:200px;')))
                ->add('save', SubmitType::class, array('label' => 'Vender', 'attr' => array('class' => 'btn btn-primary')))
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $query = $cuenta_repository->createQueryBuilder('c')
                    ->where('c.fosUser = :usuario and c.moneda= :moneda')
                    ->setParameter('usuario', $user->getId())
                    ->setParameter('moneda', Moneda::ARS)
                    ->getQuery();
            $cuenta = $query->getResult();
            $cuenta = $cuenta[0];
            $operacion = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            try {
                // SE CREA LA OPERACION BTC
                $helpers = new Helpers();
                $cotizacion = $helpers->cotizacionARS_BTC();
                $cotizacion = $cotizacion->bpi->USD->rate_float;
                $operacion->setOrigenCuenta($cuentaBTC);
                $operacion->setDetalle("Venta BTC");
                $operacion->setFecha(new \DateTime());
                $pesos = $operacion->getOrigenImporte() * ($cotizacion * 0.95);
                $operacion->setDestinoImporte($pesos);
                $operacion->setCotizacion($cotizacion);
                $operacion->setDestinoCuenta($cuenta);
                $em->persist($operacion);
                $em->flush();

                $cuentaBTC->setsaldo($cuentaBTC->getsaldo() - $operacion->getOrigenImporte());
                $em->persist($cuentaBTC);
                $em->flush();

                //$cuenta->setsaldo($cuenta->getsaldo() + $pesos);
                //$em->persist($cuenta);
               // $em->flush();

                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }
            $this->addFlash('notice', "Operacion registrada.");
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('default/btcvender.html.twig', array(
                    'form' => $form->createView(), 'cuenta' => $cuentaBTC, 'helpers' => new Helpers
        ));
    }

    /**
     * @Route("/btcrecibir", name="btcrecibir")
     */
    public function btcrecibirAction(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $db = $this->getDoctrine();
        $cuenta_repository = $db->getRepository(Cuenta::class);
        $query = $cuenta_repository->createQueryBuilder('c')
                ->where('c.fosUser = :usuario and c.moneda= :moneda')
                ->setParameter('usuario', $user->getId())
                ->setParameter('moneda', Moneda::BTC)
                ->getQuery();
        $cuentaBTC = $query->getResult();
        $cuentaBTC = $cuentaBTC[0];

        if ($cuentaBTC->getdireccion() == "") {
            try {
                require_once('jsonRPCClient.php');
                $bitcoin = new \jsonRPCClient('http://someuser:12345678@127.0.0.1:18332/');
                $username = "";
                $sendaddress = $bitcoin->getnewaddress($username);
                $cuentaBTC->setdireccion($sendaddress);
                $db->getManager()->persist($cuentaBTC);
                $db->getManager()->flush();
            } catch (Exception $e) {
                die("<p>Server error! Please contact the admin.</p>");
            }
        }
        return $this->render('default/btcrecibir.html.twig', array(
                    'cuenta' => $cuentaBTC,));
    }

    /**
     * @Route("/btcenviar", name="btcenviar")
     */
    public function btcenviarAction(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $db = $this->getDoctrine();
        $cuenta_repository = $db->getRepository(Cuenta::class);
        $query = $cuenta_repository->createQueryBuilder('c')
                ->where('c.fosUser = :usuario and c.moneda= :moneda')
                ->setParameter('usuario', $user->getId())
                ->setParameter('moneda', Moneda::BTC)
                ->getQuery();
        $cuentaBTC = $query->getResult();
        $cuentaBTC = $cuentaBTC[0];

        $form = $this->createFormBuilder()
                ->add('importe', \Symfony\Component\Form\Extension\Core\Type\NumberType::class, array('label' => 'Importe:', 'attr' => array('class' => 'form-control', 'style' => 'width:200px;')))
                ->add('direccion', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array('label' => 'Dirección:', 'attr' => array('class' => 'form-control', 'style' => 'width:600px;')))
                ->add('save', SubmitType::class, array('label' => 'Enviar', 'attr' => array('class' => 'btn btn-primary')))
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $operacion = new \AppBundle\Entity\Operaciones();
            $datos = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $em->getConnection()->beginTransaction();
            try {
                // SE CREA LA OPERACION BTC

                $operacion->setOrigenCuenta($cuentaBTC);
                $operacion->setDetalle("Envio BTC");
                $operacion->setFecha(new \DateTime('now'));
                $operacion->setOrigenImporte($datos['importe']);
                $operacion->setCotizacion(0);
                $em->persist($operacion);
                $em->flush();

                $cuentaBTC->setsaldo($cuentaBTC->getsaldo() - $datos['importe']);
                $em->persist($cuentaBTC);
                $em->flush();

                require_once('jsonRPCClient.php');
                $bitcoin = new \jsonRPCClient('http://someuser:12345678@127.0.0.1:18332/');
                $username = "";
                $sendaddress = $bitcoin->sendtoaddress($datos['direccion'], $datos['importe']);

                $transaccion_obj = new \AppBundle\Entity\Transacciones();
                $transaccion_obj->settxid($sendaddress);
                $transaccion_obj->setoperaciones($operacion);
                $em->persist($transaccion_obj);
                $em->flush();

                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }
            $this->addFlash('notice', "Operacion terminada. " . $datos['importe'] . " transferidos.");
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('default/btcenviar.html.twig', array(
                    'form' => $form->createView(), 'cuenta' => $cuentaBTC,));
    }

    /**
     * @Route("/btccron", name="btccron")
     */
    public function btccron(Request $request) {

        require_once('jsonRPCClient.php');
        $bitcoin = new \jsonRPCClient('http://someuser:12345678@127.0.0.1:18332/');
        $recibidos = $bitcoin->listreceivedbyaddress();
        foreach ($recibidos as $recibido) {
            echo $recibido['address'] . ":...<br>";
            $db = $this->getDoctrine();
            $query = $db->getRepository(Cuenta::class)
                    ->createQueryBuilder('c')
                    ->where('c.direccion = :direccion and c.moneda= 2')
                    ->setParameter('direccion', $recibido['address'])
                    ->getQuery();
            $cuentaBTC = $query->getResult();
            if (count($cuentaBTC) == 1) {
                echo "en wallet";
                $cuentaBTC = $cuentaBTC[0];
                foreach ($recibido['txids'] as $transaccion) {
                    echo $transaccion . "...<br>";
                    $query = $db->getRepository(\AppBundle\Entity\Transacciones::class)
                            ->createQueryBuilder('t')
                            ->where('t.txid = :transaccion')
                            ->setParameter('transaccion', $transaccion)
                            ->getQuery();
                    $transaccion_query = $query->getResult();
                    if (count($transaccion_query) == 0) {
                        $transaccion_detalle = $bitcoin->gettransaction($transaccion);
                        $em = $this->getDoctrine()->getManager();
                        $em->getConnection()->beginTransaction();
                        try {

                            // SE CREA LA OPERACION BTC
                            $operacion = new \AppBundle\Entity\Operaciones();
                            //$operacion->setOrigenCuenta(NULL);
                            $operacion->setDetalle("Recibo BTC");
                            $operacion->setFecha(new \DateTime('now'));
                            $operacion->setDestinoImporte($transaccion_detalle['amount']);
                            $operacion->setCotizacion(0);
                            $operacion->setDestinoCuenta($cuentaBTC);
                            $em->persist($operacion);
                            $em->flush();

                            $transaccion_obj = new \AppBundle\Entity\Transacciones();
                            $transaccion_obj->settxid($transaccion);
                            $transaccion_obj->setoperaciones($operacion);
                            $em->persist($transaccion_obj);
                            $em->flush();

                            $cuentaBTC->setsaldo($cuentaBTC->getsaldo() + $transaccion_detalle['amount']);
                            $em->persist($cuentaBTC);
                            $em->flush();

                            $em->getConnection()->commit();
                        } catch (Exception $e) {
                            $em->getConnection()->rollback();
                            throw $e;
                        }
                    }
                }
            }
        }

        return 'listo';
    }

}
