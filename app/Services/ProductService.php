<?php

namespace App\Services;

use App\Exceptions\CustomQueryException;
use App\Repositories\ProductRepository;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository)
    {
        $this->productRepository = $repository;
    }

    /**
     * @return mixed
     * @throws CustomQueryException
     */
    public function list()
    {
        return $this->productRepository->findAll([]);
    }

    /**
     * @param $data
     * @return mixed
     * @throws CustomQueryException
     */
    public function store($data): mixed
    {
        return $this->productRepository->create($data);
    }

    /**
     * @param $data
     * @return mixed
     * @throws CustomQueryException
     */
    public function getOne($id): mixed
    {
        return $this->productRepository->findOneByOrFail(['id' => $id]);
    }

    /**
     * @param $data
     * @return mixed
     * @throws CustomQueryException
     */
    public function update($data): mixed
    {
        $this->productRepository->update($this->productRepository->findOneByOrFail(['id' => $data['id']]), $data);
        return $this->productRepository->findOneByOrFail(['id' => $data['id']]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws CustomQueryException
     */
    public function delete($id): mixed
    {
        $this->productRepository->findOneByOrFail(['id' => $id]);
        return $this->productRepository->delete($id);
    }
}
