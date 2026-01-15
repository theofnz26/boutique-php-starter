<?php

require_once 'Category.php';

class Product
{
    public function __construct(
        public int $id,
        public string $name,
        public float $price,
        public Category $category // category 
    ) {}
}