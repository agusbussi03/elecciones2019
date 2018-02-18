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

class PesosController extends Controller {

    /**
     * @Route("/depositar", name="depositar")
     */
    public function depositarAction(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $transferencia = new Transferencia();
        $transferencia->setFecha(new \DateTime('now'));
        $db = $this->getDoctrine();
        $cuenta_repository = $db->getRepository(Cuenta::class);
        $query = $cuenta_repository->createQueryBuilder('c')
                ->where('c.fosUser = :usuario and c.moneda= :moneda')
                ->setParameter('usuario', $user->getId())
                ->setParameter('moneda', 1)
                ->getQuery();
        $cuenta = $query->getResult();
        $transferencia->setCuenta($cuenta[0]);
        $form = $this->createFormBuilder($transferencia)
                ->add('detalle', TextType::class, array('attr' => array('class' => 'form-control')))
                ->add('fecha', DateType::class)
                ->add('importe', MoneyType::class, array('attr' => array('class' => 'form-control','style' => 'width:200px')))
                ->add('save', SubmitType::class, array('label' => 'Informar deposito','attr' => array('class' => 'btn btn-primary')))
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $transferencia = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($transferencia);
            $em->flush();
            $this->addFlash('notice', 'Deposito informado');
            return $this->redirectToRoute('dashboard');
        }
        $query = $db->getRepository(Transferencia::class)->createQueryBuilder('t')
                ->where('t.importe>0 and t.cuenta= :cuenta')
                ->setParameter('cuenta', $cuenta[0])
                ->getQuery();
        $transferencias = $query->getResult();
        return $this->render('default/deposito.html.twig', array(
                    'form' => $form->createView(), 'transferencias' => $transferencias
        ));
    }

    /**
     * @Route("/extraer", name="extraer")
     */
    public function extraerAction(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $transferencia = new Transferencia();
        $transferencia->setFecha(new \DateTime('now'));
        $db = $this->getDoctrine();
        $cuenta_repository = $db->getRepository(Cuenta::class);
        $query = $cuenta_repository->createQueryBuilder('c')
                ->where('c.fosUser = :usuario and c.moneda= :moneda')
                ->setParameter('usuario', $user->getId())
                ->setParameter('moneda', 1)
                ->getQuery();
        $cuenta = $query->getResult();
        $transferencia->setCuenta($cuenta[0]);
        $form = $this->createFormBuilder($transferencia)
                ->add('detalle', TextType::class)
                ->add('fecha', DateType::class)
                ->add('importe', MoneyType::class)
                ->add('save', SubmitType::class, array('label' => 'Informar extracción'))
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $transferencia = $form->getData();
            $transferencia->setImporte($transferencia->getImporte() * -1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($transferencia);
            $em->flush();
            $this->addFlash('notice', 'Extracción informada');
            return $this->redirectToRoute('dashboard');
        }
        $query = $db->getRepository(Transferencia::class)->createQueryBuilder('t')
                ->where('t.importe<0 and t.cuenta= :cuenta')
                ->setParameter('cuenta', $cuenta[0])
                ->getQuery();
        $transferencias = $query->getResult();
        return $this->render('default/extraccion.html.twig', array(
                    'form' => $form->createView(), 'transferencias' => $transferencias
        ));
    }

}
