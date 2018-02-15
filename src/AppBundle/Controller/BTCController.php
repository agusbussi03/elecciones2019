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
                ->add('importe', MoneyType::class)
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
                $operacion->setCuenta($cuentaBTC);
                $operacion->setDetalle("Compra BTC");
                $operacion->setFecha(new \DateTime('now'));
                $em->persist($operacion);

                $operacion2 = new \AppBundle\Entity\Operaciones();
                $operacion2->setImporte($operacion->getImporte() * -1);
                $operacion2->setCuenta($cuenta);
                $operacion2->setDetalle("Compra BTC");
                $operacion2->setFecha($operacion->getFecha());
                $em->persist($operacion2);
                $em->flush();

                $cuenta->setsaldo($cuenta->getsaldo() + $operacion->getImporte());
                $em->persist($cuenta);
                $em->flush();

                $cuentaBTC->setsaldo($cuentaBTC->getsaldo() + $operacion2->getImporte());
                $em->persist($cuentaBTC);
                $em->flush();


                $em->getConnection()->commit();
            } catch (Exception $e) {
                // Rollback the failed transaction attempt
                $em->getConnection()->rollback();
                throw $e;
            }
            $this->addFlash('notice', 'Deposito informado');
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('default/btccomprar.html.twig', array(
                    'form' => $form->createView(), 'cuenta' => $cuenta, 'helpers' => new Helpers
        ));
    }

}
