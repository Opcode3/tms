<?php

namespace app\services;

use app\config\MysqlDBH;
use app\dto\ResponseDto;
use app\model\Product;
use app\services\impl\ProductServiceImpl;
use app\utils\MediaFileHandler;

class ProductService implements ProductServiceImpl
{

    private $model;

    function __construct()
    {
        $connector = new MysqlDBH();
        $this->model = new Product($connector);
    }

    function setProduct(array $payload, $files, $file): string
    {
        $media = new MediaFileHandler();

        if ($media->singleFileUpload($file) == true) {
            if ($media->multipleFileUpload($files) == true) {
                $response = $this->model->createProject($payload);
                if (is_int($response)) {
                    $res = $media->sealUpload($response);
                    return $res ? ResponseDto::json("Product registration was successful!", 201) :
                        ResponseDto::json("An error was encountered while trying to create product!", 500);
                } else if (is_bool($response)) {
                    return ResponseDto::json("An error was encountered while trying to create product!", 500);
                } else if ($response == "exist") {
                    return ResponseDto::json("This product name already exist in our system!", 422);
                } else {
                    return ResponseDto::json($response, 422);
                }
            }
        }
        return ResponseDto::json("An issue was encountered while trying to upload the media!", 422);
    }

    function getProduct(string $slug): string
    {
        $response = $this->model->fetchProductBySlug($slug);
        return ResponseDto::json($response);
    }

    function getProductsCount(): int
    {
        $response = $this->model->fetchProducts();
        return count($response);
    }

    function getProducts(): string
    {
        $response = $this->model->fetchProducts();
        return ResponseDto::json($response);
    }

    function editProduct(array $payload): string
    {
        $response = $this->model->updateProduct($payload);
        if (is_bool($response)) {
            if ($response) {
                return ResponseDto::json("Product update was successfully", 200);
            }
            return ResponseDto::json("We are unable to update this product. Please try again!");
        }
        return "This product was not found in our system!";
    }

    function removeProduct(string $images, int $id): string
    {
        $response = $this->model->deleteProduct($id);
        if ($response) {
            $media = new MediaFileHandler();
            if ($media->deleteFiles($images)) {
                return ResponseDto::json("Product was deleted successfully", 200);
            }
            return ResponseDto::json("Product has been deleted; but we are unable to delete it's resources entirely!");
        }
        return ResponseDto::json("We are unable to delete this product at the moment. Please try again!");
    }
}
