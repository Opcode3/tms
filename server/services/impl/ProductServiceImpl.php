<?php

namespace app\services\impl;

interface ProductServiceImpl
{
    function setProduct(array $data, $files, $file): string;
    function getProduct(string $slug): string;
    function getProducts(): string;
    function getProductsCount(): int;
    function editProduct(array $payload): string;
    function removeProduct(string $images, int $id): string;
}
