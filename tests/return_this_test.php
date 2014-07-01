<?php
class Foo {
    public $foo = 1;
    public function getInstance() {
        return $this;
    }
}

$objFoo = new Foo();
$objFoo->getInstance()->foo = 2;
echo $objFoo->foo;
?>
