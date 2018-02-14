<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Moneda;
use AppBundle\Entity\Cuenta;
use AppBundle\Entity\FosUser;

class DefaultController extends Controller
{
    /**
   * @Route("/", name="homepage")
   */
  public function indexAction(Request $request)
  {
      $user = $this->getUser();
      /*** si esta autenticado verifica que tenga todas las cuentas definidas y redirige al dashboard ***/
      if ($user) {
          $user = $this->getUser();
          $db=$this->getDoctrine();
          $cuenta_repository = $db->getRepository(Cuenta::class);
          $monedas = $db->getRepository(Moneda::class)->findAll();
          foreach ($monedas as $moneda) {
              $query = $cuenta_repository->createQueryBuilder('c')
              ->where('c.fosUser = :usuario and c.moneda= :moneda')
              ->setParameter('usuario', $user->getId())
              ->setParameter('moneda', $moneda->getId())
              ->orderBy('c.moneda', 'ASC')
              ->getQuery();
              $cuenta = $query->getResult();
            /** si el usuario no tiene cuenta para esta moneda, se la crea **/
            if (count($cuenta)==0) {
                $cuenta = new Cuenta();
                $cuenta->setsaldo(0);
                $cuenta->setdireccion('');
                $cuenta->setmoneda($moneda);
                $cuenta->setfosUser($db->getRepository(FosUser::class)->find($user->getId()));
                $db->getManager()->persist($cuenta);
                $db->getManager()->flush();
            };
          };

          return $this->redirectToRoute('dashboard');
      }

    //print_r($userManager);
      return $this->render('default/index.html.twig', [
          'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
      ]);
  }
  /**
   * @Route("/dashboard", name="dashboard")
   */
  public function dashboardAction(Request $request)
  {
      $user = $this->getUser();
      $db=$this->getDoctrine();
      $cuenta_repository = $db->getRepository(Cuenta::class);

      $query = $cuenta_repository->createQueryBuilder('c')
        ->where('c.fosUser = :usuario')
        ->setParameter('usuario', $user->getId())
        ->orderBy('c.moneda', 'ASC')
        ->getQuery();
      return $this->render('default/dashboard.html.twig', array('cuentas'=>$query->getResult()));
  }
}
