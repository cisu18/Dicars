<?php
namespace Dicars\LogisticaBundle\Controller;

use Dicars\DataBundle\Entity\Producto;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\TransactionRequiredException;



class AdministrarProductoController extends Controller{

	public function RegistrarProductoAction(){
		
		$request = $this->get('request');
		$form = $request->request->get('formulario');
		
		$datos = array();		
		parse_str($form,$datos);
		
		$Producto_id = null;
		$Producto_serie = null;
		$Producto_talla = null;
		$Producto_marca = null;
		$Producto_tipo = null;
		$Producto_desc = null;
		$Producto_prec_contado = null;
		$Producto_prec_credito = null;
		$Producto_prec_costo = null;
		$Producto_cod_barra = null;
		$Producto_archivo = null;
		$Producto_categoria=null;
		$Producto_stock_min = null;
		$Producto_stock_max = null;
		$Producto_stock = null;
		$Producto_est = null;
		$Producto_porc_uti = null;
		$Producto_porc_uti_bruta = null;		
		
		if ($form != null){
			$Producto_id = $datos["codigo"];
			$Producto_talla = $datos["talla"];
			$Producto_serie = $datos["serie"];
			
			$Producto_marca = $this->getDoctrine()
    		->getRepository('DicarsDataBundle:VenMarca')
			->findOneBy(array('nmarcaId'  => 1));
			
			$Producto_tipo = $datos["tipo"];
			$Producto_desc = $datos["descripcion"];
			$Producto_prec_contado = $datos["minimocontado"];
			$Producto_prec_credito = $datos["minimocredito"];
			$Producto_prec_costo = $datos["preciocosto"];
			$Producto_cod_barra = "AER1234";
			$Producto_archivo = "Hola soy el archivo";
			
			$Producto_categoria =  $this->getDoctrine()
	    	->getRepository('DicarsDataBundle:VenCategoria')
			->findOneBy(array('ncategoriaId' => 1));
			
			$Producto_stock_min = 10;
			$Producto_stock_max = 40;
			$Producto_stock = 25;
			$Producto_est = 1;
			$Producto_porc_uti = 18;
			$Producto_porc_uti_bruta = 20;
			
			$Producto = new Producto();
			$Producto->setCproductotalla($Producto_talla);
			$Producto->setCproductoserie($Producto_serie);
			$Producto->setNproductomarca($Producto_marca);
			$Producto->setNproductotipo($Producto_tipo);
			$Producto->setCproductodesc($Producto_desc);
			$Producto->setNproductopcontado($Producto_prec_contado);
			$Producto->setNproductopcredito($Producto_prec_credito);
			$Producto->setNproductopcosto($Producto_prec_costo);
			$Producto->setCproductocodbarra($Producto_cod_barra);
			$Producto->setCproductoimage($Producto_archivo);
			$Producto->setNcategoria($Producto_categoria);
			$Producto->setNproductostockmin($Producto_stock_min);
			$Producto->setNproductostockmax($Producto_stock_max);
			$Producto->setNproductosotck($Producto_stock);
			$Producto->setCproductoest($Producto_est);
			$Producto->setNproductoporcuti($Producto_porc_uti);
			$Producto->setNproductoutibruta($Producto_porc_uti_bruta);
			
			$em = $this->getDoctrine()->getEntityManager();
			$this->getDoctrine()->getEntityManager()->beginTransaction();
			try {
				$em->persist($Producto);
				$em->flush();
			} catch (Exception $e) {
				$this->getDoctrine()->getEntityManager()->rollback();
				$this->getDoctrine()->getEntityManager()->close();
				$return = array("responseCode"=>400, "greeting"=>"Bad");
							
				throw $e;			
			}
				$this->getDoctrine()->getEntityManager()->commit();
				$em->clear();
				$return = array("responseCode"=>200, "datos"=>$datos);
					
		}
		else {
			$return = array("responseCode"=>400, "greeting"=>"Bad");
		}		
		
		$return = json_encode($return);
		return new Response($return,200,array('Content-Type'=>'application/json'));
	}
	
	
	public function EditarProductoAction(){
	
		$request = $this->get('request');
		$form = $request->request->get('formulario');
	
		$datos = array();
		parse_str($form,$datos);
		
		$Producto_serie = null;
		$Producto_talla = null;
		$Producto_marca = null;
		$Producto_tipo = null;
		$Producto_desc = null;
		$Producto_prec_contado = null;
		$Producto_prec_credito = null;
		$Producto_prec_costo = null;
		$Producto_cod_barra = null;
		$Producto_archivo = null;
		$Producto_categoria=null;
		$Producto_stock_min = null;
		$Producto_stock_max = null;
		$Producto_stock = null;
		$Producto_est = null;
		$Producto_porc_uti = null;
		$Producto_porc_uti_bruta = null;
		
		if ($form != null){
			
			$Producto_id = $datos["id"];
			$Producto_talla = $datos["talla"];
			$Producto_serie = $datos["serie"];
				
			$Producto_marca = $this->getDoctrine()
			->getRepository('DicarsDataBundle:VenMarca')
			->findOneBy(array('nmarcaId'  => 1));
				
			$Producto_tipo = $datos["tipo"];
			$Producto_desc = $datos["descripcion"];
			$Producto_prec_contado = $datos["minimocontado"];
			$Producto_prec_credito = $datos["minimocredito"];
			$Producto_prec_costo = $datos["preciocosto"];
			$Producto_cod_barra = "AER1234";
			$Producto_archivo = "Hola soy el archivo";
				
			$Producto_categoria =  $this->getDoctrine()
			->getRepository('DicarsDataBundle:VenCategoria')
			->findOneBy(array('ncategoriaId' => 1));
				
			$Producto_stock_min = 10;
			$Producto_stock_max = 40;
			$Producto_stock = 25;
			$Producto_est = 1;
			$Producto_porc_uti = 18;
			$Producto_porc_uti_bruta = 20;
			
			$Producto = $this->getDoctrine()
			->getRepository('DicarsDataBundle:Producto')
			->findOneBy(array('nproductoId' => $Producto_id));
			
			$Producto->setCproductotalla($Producto_talla);
			$Producto->setCproductoserie($Producto_serie);
			$Producto->setNproductomarca($Producto_marca);
			$Producto->setNproductotipo($Producto_tipo);
			$Producto->setCproductodesc($Producto_desc);
			$Producto->setNproductopcontado($Producto_prec_contado);
			$Producto->setNproductopcredito($Producto_prec_credito);
			$Producto->setNproductopcosto($Producto_prec_costo);
			$Producto->setCproductocodbarra($Producto_cod_barra);
			$Producto->setCproductoimage($Producto_archivo);
			$Producto->setNcategoria($Producto_categoria);
			$Producto->setNproductostockmin($Producto_stock_min);
			$Producto->setNproductostockmax($Producto_stock_max);
			$Producto->setNproductosotck($Producto_stock);
			$Producto->setCproductoest($Producto_est);
			$Producto->setNproductoporcuti($Producto_porc_uti);
			$Producto->setNproductoutibruta($Producto_porc_uti_bruta);
				
			$em = $this->getDoctrine()->getEntityManager();
			$this->getDoctrine()->getEntityManager()->beginTransaction();
			
		try {
			$em->flush();
		} catch (Exception $e) {
			$this->getDoctrine()->getEntityManager()->rollback();
			$this->getDoctrine()->getEntityManager()->close();
			$return = array("responseCode"=>400, "greeting"=>"Bad");
				
			throw $e;
		}
		$this->getDoctrine()->getEntityManager()->commit();
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