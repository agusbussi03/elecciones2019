<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\FosUser;
use AppBundle\Services\Helpers;
use AppBundle\Entity\Transferencia;
use AppBundle\Entity\Operaciones;
use AppBundle\Entity\Cuenta;
use AppBundle\Entity\Moneda;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdminController extends Controller {

    /**
     * @Route("/admin/depositos", name="admindepositos")
     */
    public function admindepositosAction(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $db = $this->getDoctrine();
        $query = $db->getRepository(Transferencia::class)->createQueryBuilder('t')
                ->where('t.importe>0 ')
                ->orderBy('t.fecha', 'DESC')
                ->getQuery();
        $transferencias = $query->getResult();
        return $this->render('default/admin_deposito.html.twig', array(
                    'transferencias' => $transferencias, 'helpers' => new Helpers()
        ));
    }

    /**
     * @Route("/admin_depositos/{operacion}/{id}", name="admindepositosoperacion")
     */
    public function admindepositosoperacionAction($operacion, $id) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $db = $this->getDoctrine()->getRepository(Transferencia::class);
        $transferencia = $db->find($id);
        $db = $this->getDoctrine()->getRepository(Cuenta::class);
        $cuenta = $db->find($transferencia->getCuenta()->getId());
        $transferencia->setConfirmacion(new \DateTime('now'));
        
        if ($operacion == "aprobar") {
            $transferencia->setEstado(1);
            $cuenta->setSaldo($cuenta->getSaldo()+$transferencia->getImporte());
            $em->persist($cuenta);
            $this->addFlash('notice', 'Deposito aprobado por '.$transferencia->getImporte().'. Nuevo saldo: '.$cuenta->getSaldo());
        }
        if ($operacion == "denegar") {
            $transferencia->setEstado(2);
            $this->addFlash('notice', 'Deposito denegado');
        }
        $em->persist($transferencia);
        $em->flush();
        return $this->redirectToRoute('admindepositos');
    }

    
     /**
     * @Route("/admin/extracciones", name="adminextracciones")
     */
    public function adminextraccionesAction(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $db = $this->getDoctrine();
        $query = $db->getRepository(Transferencia::class)->createQueryBuilder('t')
                ->where('t.importe<0 ')
                ->orderBy('t.fecha', 'DESC')
                ->getQuery();
        $transferencias = $query->getResult();
        return $this->render('default/admin_extraccion.html.twig', array(
                    'transferencias' => $transferencias, 'helpers' => new Helpers()
        ));
    }
    
     /**
     * @Route("/admin_extracciones/{operacion}/{id}", name="adminextraccionesoperacion")
     */
    public function adminextraccionesoperacionAction($operacion, $id) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $db = $this->getDoctrine()->getRepository(Transferencia::class);
        $transferencia = $db->find($id);
        $db = $this->getDoctrine()->getRepository(Cuenta::class);
        $cuenta = $db->find($transferencia->getCuenta()->getId());
        $transferencia->setConfirmacion(new \DateTime('now'));
        
        if ($operacion == "aprobar") {
            $transferencia->setEstado(1);
            $cuenta->setSaldo($cuenta->getSaldo()+$transferencia->getImporte());
            $em->persist($cuenta);
            $this->addFlash('notice', 'Extraccion aprobada por '.$transferencia->getImporte().'. Nuevo saldo: '.$cuenta->getSaldo());
        }
        if ($operacion == "denegar") {
            $transferencia->setEstado(2);
            $this->addFlash('notice', 'Extraccion denegada');
        }
        $em->persist($transferencia);
        $em->flush();
        return $this->redirectToRoute('adminextracciones');
    }
    
    
      /**
     * @Route("/admin/operaciones", name="adminoperaciones")
     */
    public function adminoperacionesAction(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $db = $this->getDoctrine();
        $query = $db->getRepository(Operaciones::class)->createQueryBuilder('t')
                ->orderBy('t.fecha', 'DESC')
                ->getQuery();
        $operaciones = $query->getResult();
        return $this->render('default/admin_operacion.html.twig', array(
                    'operaciones' => $operaciones, 'helpers' => new Helpers()
        ));
    }
    

      /**
     * @Route("/admin_operaciones/{operacion}/{id}", name="adminoperacionesoperacion")
     */
    public function adminoperacionesoperacionAction($operacion, $id) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $db = $this->getDoctrine()->getRepository(Operaciones::class);
        $BTCoperacion = $db->find($id);
        $db = $this->getDoctrine()->getRepository(Cuenta::class);
        $cuenta = $db->find($BTCoperacion->getDestinoCuenta()->getId());
        $BTCoperacion->setConfirmacion(new \DateTime('now'));
        
        if ($operacion == "aprobar") {
            $BTCoperacion->setEstado(1);
            $cuenta->setSaldo($cuenta->getSaldo()+$BTCoperacion->getDestinoImporte());
            $em->persist($cuenta);
            $this->addFlash('notice', 'Operacion aprobada');
        }
        if ($operacion == "denegar") {
            $BTCoperacion->setEstado(2);
            $this->addFlash('notice', 'Extraccion denegada');
        }
        $em->persist($BTCoperacion);
        $em->flush();
        return $this->redirectToRoute('adminoperaciones');
    }
    
    
    
}
