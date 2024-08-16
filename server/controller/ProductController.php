<?php

namespace app\controller;

use app\services\ProductService;

class ProductController
{

    private $productService;

    function __construct()
    {
        $this->productService = new ProductService();
    }

    function addProduct(array $payload, $files, $file)
    {
        return $this->productService->setProduct($payload, $files, $file);
    }

    function getSingleProduct(string $slug)
    {
        return $this->productService->getProduct($slug);
    }

    function getAllProduct()
    {
        return $this->productService->getProducts();
    }

    function getCount()
    {
        return $this->productService->getProductsCount();
    }

    function deleteProduct(string $images, int $id)
    {
        return $this->productService->removeProduct($images, $id);
    }

    function modifyProductInfo(array $payload)
    {
        return $this->productService->editProduct($payload);
    }
}
