<?php
	require_once("cartMap.php");
	session_start();	
/*
	//echo serialize($_SESSION)."|";
	$cart=$_SESSION['cart'];
	if(!isset($cart)){
		$cart = new CartMap();
	}


	echo $cart->size();
	$_SESSION['cart']=$cart;
	//die(serialize($_SESSION['cart']));
*/
class CartManager{

	private $cart;

	/**
	  *
	  **/
	function __construct(){
		//echo "construtor";	
		$this->initCart();
		if(isset($this->cart)){

			$this->cart->resetIndice();
			$this->updateSession();
		}
	}
	/**
	  *
	  **/
	private function initCart(){
		$this->cart =$_SESSION['cart'];
		if(!isset($this->cart)){
			//echo "cart nulo"."<br>";
			$this->cart = new CartMap();
		}

	}
	/**
	  *
	  **/
	private function updateSession(){
		$_SESSION['cart']=$this->cart;
	}
	/**
	  *
	  **/
	public function addProduct($produto){
		$this->initCart();
		$this->cart->put($produto,1);
		$this->updateSession();
	}
	/**
	  *
	  **/
	public function delProduct($idProduto){
		$this->initCart();
		$this->cart->remove($idProduto);
		$this->updateSession();	
	}
	/**
	  *
	  **/
	public function getTotalItens(){
		$this->initCart();
		return $this->cart->totalItens();	
	}
	/**
	  *
	  **/
	public function getQtUnits(){
		return $this->cart->size();
	}
	/**
  	  *
	  **/
	public function hasItem(){
		$this->initCart();		
		return $this->cart->hasNext();
	}
	/**
	  *
	  **/
	public function getItem(){
		$item=$this->cart->next();
		$this->updateSession();
		return $item;
	}
	/**
	  *
	  **/
	public function getItens(){
		return $this->cart->getKeys();	
	}
	/**
	  *
	  **/	
	public function getSessionId(){
		return session_id();
	}
	/**
	  *
	  **/
	public function getValorTotalCart(){
		return $this->cart->getValorTotalItens();
	}	
}
?>
