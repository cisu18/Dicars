<?php
namespace Dicars\VentasBundle\Controller;

use Symfony\Component\Validator\Constraints\Date;

use Dicars\DataBundle\Entity\VenPersonal;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\TransactionRequiredException;


class AdministrarTrabajadorController extends Controller{

	public function RegistrarTrabajadorAction(){

		$request = $this->get('request');
		$form = $request->request->get('formulario');
		
		$datos = array();		
		parse_str($form,$datos);
		
		$Empleado_cargo = null;
		$Empleado_dni = null;
		$Empleado_nombre = null;
		$Empleado_apellido = null;
		$Empleado_telefono = null;
		$Empleado_email = null;
		$Empleado_fechanacimiento = null;								
		$Empleado_sexo = null;
		$Empleado_estado = null;
		$Empleado_edad = null;

		if ($form!=null){					
			
			$Empleado_cargo =  $this->getDoctrine()
			->getRepository('DicarsDataBundle:VenCargo')
			->findOneBy(array('ncargoId' => $datos["cargo"]));
			
			$Empleado_dni = $datos["dni"];
			$Empleado_nombre = $datos["nombres"];
			$Empleado_apellido = $datos["apellidos"];
			$Empleado_telefono = $datos["telefono"];
			$Empleado_email = $datos["email"];
			$Empleado_fechanacimiento = date_create_from_format('d/m/Y', $datos["fechanacimiento"]);
			$Empleado_sexo = $datos["sexo"];
			$Empleado_estado = $datos["estado"];
			$Empleado_edad = $datos["edad"];
			
			$Empleado = new VenPersonal();
			$Empleado->setNcargo($Empleado_cargo);
			$Empleado->setCpersonaldni($Empleado_dni);
			$Empleado->setCpersonalnom($Empleado_nombre);
			$Empleado->setCpersonalape($Empleado_apellido);
			$Empleado->setCpersonaltelf($Empleado_telefono);
			$Empleado->setCpersonalemail($Empleado_email);
			$Empleado->setDpersonalfec($Empleado_fechanacimiento);
			$Empleado->setCpersonalsexo($Empleado_sexo);
			$Empleado->setCpersonalest($Empleado_estado);
			$Empleado->setCpersonaledad($Empleado_edad);
			
			$em = $this->getDoctrine()->getEntityManager();
			$em->beginTransaction();
			try {
				$em->persist($Empleado);
				$em->flush();
			} catch (Exception $e) {
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


	//EDITAR CLIENTE
	public function EditarTrabajadorAction(){
		$request = $this->get('request');
		$form = $request->request->get('formulario');
		
		$datos = array();
		parse_str($form,$datos);
	
		$Empleado_cargo = null;
		$Empleado_dni = null;
		$Empleado_nombre = null;
		$Empleado_apellido = null;
		$Empleado_telefono = null;
		$Empleado_email = null;
		$Empleado_fechanacimiento = null;								
		$Empleado_sexo = null;
		$Empleado_estado = null;		
		$Empleado_edad = null;
		
		if ($form!=null){
			
			$Empleado_Id = $datos["idE"];
			
			$Empleado_cargo =  $this->getDoctrine()
			->getRepository('DicarsDataBundle:VenCargo')
			->findOneBy(array('ncargoId' => 1));
			
			$Empleado_dni = $datos["dniE"];
			$Empleado_nombre = $datos["nombresE"];
			$Empleado_apellido = $datos["apellidosE"];
			$Empleado_telefono = $datos["telefonoE"];
			$Empleado_email = $datos["emailE"];
			$Empleado_fechanacimiento = new \DateTime($datos["fechanacimientoE"]);
			$Empleado_sexo = $datos["sexoE"];
			$Empleado_estado = $datos["estadoE"];			
			$Empleado_edad = $datos["edadE"];				
			/**/
			$Empleado = $this->getDoctrine()
			->getRepository('DicarsDataBundle:VenPersonal')
			->findOneBy(array('npersonalId' => $Empleado_Id));
			
			$Empleado->setNcargo($Empleado_cargo);
			$Empleado->setCpersonaldni($Empleado_dni);
			$Empleado->setCpersonalnom($Empleado_nombre);
			$Empleado->setCpersonalape($Empleado_apellido);
			$Empleado->setCpersonaltelf($Empleado_telefono);
			$Empleado->setCpersonalemail($Empleado_email);
			$Empleado->setDpersonalfec($Empleado_fechanacimiento);
			$Empleado->setCpersonalsexo($Empleado_sexo);
			$Empleado->setCpersonalest($Empleado_estado);
			$Empleado->setCpersonaledad($Empleado_edad);
				
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
}