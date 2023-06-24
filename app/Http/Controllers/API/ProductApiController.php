<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CustomQueryException;
use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductDeleteRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductApiController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @return JsonResponse
     * @throws CustomQueryException
     */
    public function list(): JsonResponse
    {
        return CustomResponse::successResponse('success',
            new ProductResource($this->productService->list()));
    }

    /**
     * @param ProductCreateRequest $request
     * @return JsonResponse
     * @throws CustomQueryException
     */
    public function store(ProductCreateRequest $request): JsonResponse
    {
        return CustomResponse::successResponse('success',
            new ProductResource($this->productService->store($request->validated())));
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws CustomQueryException
     */
    public function details(int $id): JsonResponse
    {
        return CustomResponse::successResponse('success',
            new ProductResource($this->productService->getOne($id)));
    }

    /**
     * @param ProductUpdateRequest $request
     * @return JsonResponse
     * @throws CustomQueryException
     */
    public function update(ProductUpdateRequest $request): JsonResponse
    {
        return CustomResponse::successResponse('success',
            new ProductResource($this->productService->update($request->validated())));
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws CustomQueryException
     */
    public function delete(int $id): JsonResponse
    {
        $this->productService->delete($id);
        return CustomResponse::successResponse('success');
    }
}
