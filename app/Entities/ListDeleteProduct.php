<?php
namespace App\Entities;
class ListDeleteProduct{
	public $products = null;
	public $totalQuanty = 0;

	public function __construct($cart){
		if($cart){
			$this->products = $cart->products;
			$this->totalQuanty = $cart->totalQuanty;
		}
	}

	public function AddList($product,$id){
		$newProduct = ['quanty' => 0, 'productInfo' => $product];
		if($this->products){
			if(array_key_exists($id, $this->products))
			{
				$newProduct = $this->products[$id];	
			}			
		}
		$newProduct['quanty']++;
		$this->products[$id] = $newProduct;
		$this->totalQuanty ++;
	}

	public function DeleteItemList($id){
		$this->totalQuanty -= $this->products[$id]['quanty'];
		unset($this->products[$id]);
	}
}

?>