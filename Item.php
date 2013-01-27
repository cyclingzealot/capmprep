 <?php

 class Item {


 protected $_name;
 protected $_type;
 protected $_parents;
 protected $_children;

 /**
  * @param $name string The name of the item
  * @param $type Item The type of the item
  * @param $parents mixed Can be an item or an array of items
  */
 public __construct($name, $type, $parents) {
 	$this->_name=$name;
	$this->_type=$type;
	$this->_parents=$parents;
 }


 public function getParents() {return $this->_parents;}
 public function getChildren() {return $this->_children;}
 public function setParents($parents) {return $this->_parents;}
 public function setChildren($children) {$this->_children;}
