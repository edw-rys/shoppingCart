<?php
class Product{
    private $id;
    private $name;
    private $description;
    private $url_img;
    private $quantity;
    private $price;
    private $discount;
    private $category;
	private $i_like;
	public function getId() {
		return $this->id;
	}

	public function setId( $id) {
		$this->id = $id;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getUrl_img() {
		return $this->url_img;
	}

	public function setUrl_img($url_img) {
		$this->url_img = $url_img;
	}

	public function getQuantity() {
		return $this->quantity;
	}

	public function setQuantity($quantity) {
		$this->quantity = $quantity;
	}

	public function getPrice() {
		return $this->price;
	}

	public function setPrice($price) {
		$this->price = $price;
	}

	public function getDiscount() {
		return $this->discount;
	}

	public function setDiscount($discount) {
		$this->discount = $discount;
	}

	public function getCategory() {
		return $this->category;
	}

	public function setCategory( $category) {
		$this->category = $category;
	}

	public function isI_like() {
		return $this->i_like;
	}

	public function setI_like( $like) {
		$this->i_like = $like;
	}


    public function __construct(){}
    
}