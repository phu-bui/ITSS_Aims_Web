<?php
namespace App\Entities;
class Cart{
	public $products = null;
	public $totalPrice = 0;
	public $totalQuanty = 0;

	public function __construct($cart){
		if($cart){
			$this->products = $cart->products;
			$this->totalPrice = $cart->totalPrice;
			$this->totalQuanty = $cart->totalQuanty;
		}
	}

	public function AddCart($product,$id){
		$newProduct = ['quanty' => 0, 'price' => $product->price,'productInfo' => $product];
		if($this->products){
			if(array_key_exists($id, $this->products))
			{
				$newProduct = $this->products[$id];	
			}			
		}
		$newProduct['quanty']++;
		$newProduct['price'] = $newProduct['quanty']*$product->price;
		$this->products[$id] = $newProduct;
		$this->totalPrice += $product->price;
		$this->totalQuanty ++;
	}


	public function DeleteOneItem($id){
		if($this->products[$id]['quanty'] > 1){
			$this->totalPrice -= $this->products[$id]['price']/$this->products[$id]['quanty'];
			$this->products[$id]['price'] -= $this->products[$id]['price']/$this->products[$id]['quanty'];
			$this->products[$id]['quanty']--;
			$this->totalQuanty --;
		}
		else{
			$this->totalQuanty -= $this->products[$id]['quanty'];
			$this->totalPrice -= $this->products[$id]['price'];
			unset($this->products[$id]);
		}
	}

	public function DeleteItemCart($id){
		$this->totalQuanty -= $this->products[$id]['quanty'];
		$this->totalPrice -= $this->products[$id]['price'];
		unset($this->products[$id]);
	}
}

?>