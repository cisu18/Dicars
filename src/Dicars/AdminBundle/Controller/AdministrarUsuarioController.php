<?php
namespace Dicars\AdminBundle\Controller;

use Dicars\DataBundle\Entity\Usuario;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\TransactionRequiredException;

class AdministrarUsuarioController  extends Controller{

	public function RegistrarUsuarioAction(){
		$request = $this->get('request');
		$form = $request->request->get('formulario');
	
		$datos = array();
		parse_str($form,$datos);
	
		$Usuario_trabajador = null;
		$Usuario_id = null;
		$Usuario_clave = null;
		$Usuario_estado = null;
		$Usuario_fechareg = null;
	
		if ($form!=null){
			
			$Usuario_trabajador = $this->getDoctrine()
			->getRepository('DicarsDataBundle:VenPersonal')
			->findOneBy(array('npersonalId'  => $datos["trabajador"]));
			
			$Usuario_id = $datos["usuario_id"];
			$Usuario_clave = $datos["contrasena"];
			$Usuario_estado = $datos["estado"];
			
			$Usuario_fechareg = new \DateTime();
			
			$Usuario = new Usuario();
			$Usuario->setNpersonal($Usuario_trabajador);
			$Usuario->setCusuarioid($Usuario_id);
			$Usuario->setCusuarioclave($Usuario_clave);
			$Usuario->setCusuarioest($Usuario_estado);
			$Usuario->setCusuariofecreg($Usuario_fechareg);
			
			$em = $this->getDoctrine()->getEntityManager();
			$em -> beginTransaction();
			try {
				$em->persist($Usuario);
				$em->flush();
			} catch (Exception $e){
				$em->rollback();
				$em->close();
				$return = array("responseCode"=>400, "greeting"=>"Bad");					
				throw $e;
			}
			$em->commit();
			$em->clear();
			$em->close();			
			$return = array("responseCode"=>200, "datos"=>$datos);
		}
		else {
			$return = array("responseCode"=>400, "greeting"=>"Bad");
		}
	
		$return = json_encode($return);
		return new Response($return,200,array('Content-Type'=>'application/json'));
	}
	
	public function EditarUsuarioAction(){
	
		$request = $this->get('request');
		$form = $request->request->get('formulario');
	
		$datos = array();
		parse_str($form,$datos);
		
		$Usuario_cod = null;
		$Usuario_trabajador = null;
		$Usuario_id = null;
		$Usuario_clave = null;
		$Usuario_estado = null;
		$Usuario_fechareg = null;
	
		if ($form != null){
			
			$Usuario_cod = $datos["idE"];
			$Usuario_id = $datos["usuario_idE"];
			$Usuario_clave = $datos["contrasenaE"];
			$Usuario_estado = $datos["estadoE"];
			
			$Usuario = $this->getDoctrine()
			->getRepository('DicarsDataBundle:Usuario')
			->findOneBy(array('nusuarioId' => $Usuario_cod));
				
			$Usuario->setCusuarioid($Usuario_id);
			$Usuario->setCusuarioclave($Usuario_clave);
			$Usuario->setCusuarioest($Usuario_estado);
			
			$em = $this->getDoctrine()->getEntityManager();
			$em->beginTransaction();
	
			try {
				$em->flush();
			} catch (Exception $e) {
				$em->rollback();
				$em->close();
				$return = array("responseCode"=>400, "greeting"=>"Bad");
	
				throw $e;
			}
			$em->commit();
			$em->close();
			$em->clear();
			$return = array("responseCode"=>200, "datos"=>$datos);	
		}
		else {
			$return = array("responseCode"=>400, "greeting"=>"Bad");
		}	
		$return = json_encode($return);
		return new Response($return,200,array('Content-Type'=>'application/json'));
	}
	
}
