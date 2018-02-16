<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\FosUser;
use AppBundle\Services\Helpers;
use AppBundle\Entity\Transferencia;
use AppBundle\Entity\Cuenta;
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
        $user = $this->getUser();
        $db = $this->getDoctrine();
        $cuenta_repository = $db->getRepository(Cuenta::class);
        $query = $cuenta_repository->createQueryBuilder('c')
                ->where('c.fosUser = :usuario and c.moneda= :moneda')
                ->setParameter('usuario', $user->getId())
                ->setParameter('moneda', 1)
                ->getQuery();
        $cuenta = $query->getResult();
        $cuenta = $cuenta[0];
        $operacion = new \AppBundle\Entity\Operaciones();
        $form = $this->createFormBuilder($operacion)
                ->add('origen_importe', MoneyType::class,array('currency'=>'USD','label'=>'Importe:'))
                ->add('save', SubmitType::class, array('label' => 'Comprar'))
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $query = $cuenta_repository->createQueryBuilder('c')
                    ->where('c.fosUser = :usuario and c.moneda= :moneda')
                    ->setParameter('usuario', $user->getId())
                    ->setParameter('moneda', 2)
                    ->getQuery();
            $cuentaBTC = $query->getResult();
            $cuentaBTC = $cuentaBTC[0];
            $operacion = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            try {
                // SE CREA LA OPERACION BTC
                $helpers=new Helpers();
                $cotizacion=$helpers->cotizacionARS_BTC();
                $cotizacion=$cotizacion->bpi->ARS->rate_float;
                $operacion->setOrigenCuenta($cuenta);
                $operacion->setDetalle("Compra BTC");
                $operacion->setFecha(new \DateTime('now'));
                $btc=round($operacion->getOrigenImporte() / ($cotizacion*1.05),8);
                $operacion->setDestinoImporte($btc);
                $operacion->setCotizacion($cotizacion);
                $operacion->setDestinoCuenta($cuentaBTC);
                $em->persist($operacion);
                $em->flush();

                $cuenta->setsaldo($cuenta->getsaldo() - $operacion->getOrigenImporte());
                $em->persist($cuenta);
                $em->flush();

                $cuentaBTC->setsaldo($cuentaBTC->getsaldo()+$btc);
                $em->persist($cuentaBTC);
                $em->flush();

                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }
            $this->addFlash('notice', "Operacion terminada. ".$btc." adquiridos.");
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
        $user = $this->getUser();
        $db = $this->getDoctrine();
        $cuenta_repository = $db->getRepository(Cuenta::class);
        $query = $cuenta_repository->createQueryBuilder('c')
                ->where('c.fosUser = :usuario and c.moneda= :moneda')
                ->setParameter('usuario', $user->getId())
                ->setParameter('moneda', 2)
                ->getQuery();
        $cuentaBTC = $query->getResult();
        $cuentaBTC = $cuentaBTC[0];
        $operacion = new \AppBundle\Entity\Operaciones();
        $form = $this->createFormBuilder($operacion)
                ->add('origen_importe', \Symfony\Component\Form\Extension\Core\Type\NumberType::class)
                ->add('save', SubmitType::class, array('label' => 'Vender'))
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $query = $cuenta_repository->createQueryBuilder('c')
                    ->where('c.fosUser = :usuario and c.moneda= :moneda')
                    ->setParameter('usuario', $user->getId())
                    ->setParameter('moneda', 1)
                    ->getQuery();
            $cuenta = $query->getResult();
            $cuenta = $cuenta[0];
            $operacion = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            try {
                // SE CREA LA OPERACION BTC
                $helpers=new Helpers();
                $cotizacion=$helpers->cotizacionARS_BTC();
                $operacion->setOrigenCuenta($cuentaBTC);
                $operacion->setDetalle("Venta BTC");
                $operacion->setFecha(new \DateTime('now'));
                $pesos=$operacion->getOrigenImporte() * ($cotizacion*0.95);
                $operacion->setDestinoImporte($pesos);
                $operacion->setCotizacion($cotizacion);
                $operacion->setDestinoCuenta($cuenta);
                $em->persist($operacion);
                $em->flush();

                $cuentaBTC->setsaldo($cuentaBTC->getsaldo() - $operacion->getOrigenImporte());
                $em->persist($cuentaBTC);
                $em->flush();

                $cuenta->setsaldo($cuenta->getsaldo()+$pesos);
                $em->persist($cuenta);
                $em->flush();

                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }
            $this->addFlash('notice', "Operacion terminada. ".$pesos." vendidos.");
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
        $user = $this->getUser();
        $db = $this->getDoctrine();
        $cuenta_repository = $db->getRepository(Cuenta::class);
        $query = $cuenta_repository->createQueryBuilder('c')
                ->where('c.fosUser = :usuario and c.moneda= :moneda')
                ->setParameter('usuario', $user->getId())
                ->setParameter('moneda', 2)
                ->getQuery();
        $cuentaBTC = $query->getResult();
        $cuentaBTC = $cuentaBTC[0];
       
        return $this->render('default/btcrecibir.html.twig', array(
                     'cuenta' => $cuentaBTC,  ));
    }
    
    
    
    
}
