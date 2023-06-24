<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CustomQueryException;
use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductCreateRequest;
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
     *
     *  * @OA\Get(
     *    path="/api/v1/products",
     *   summary="listing of the products",
     *   tags={"Product Controller"},
     *   security={{"bearer_token":{}}},
     * @OA\RequestBody(description="listing of the products",
     * 	@OA\MediaType(mediaType="application/json",
     *   )
     * ),
     * @OA\SecurityScheme(
     *     securityScheme="BearerAuth",
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="JWT"
     * ),
     * @OA\Response(response=200, description="Successfull operation.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="code", type="integer", example=200),
     *     			@OA\Property(property="data", type="json", example={
    "message": "success",
    "data": {
    {
    "id": 1,
    "name": "product test 2",
    "price": "2.00",
    "created_at": "2023-06-24 13:07:28",
    "updated_at": "2023-06-24 13:13:46"
    }
    }
    })
     *            )
     *        )
     * ),
     *@OA\Response(response=400, description="Invalid service id.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="error_code", type="integer", example=400),
     *     			@OA\Property(property="error_message", type="string", example="Invalid data."),
     *            )
     *        )
     * ),
     *@OA\Response(response=500, description="something went wrong please try again later.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="error_code", type="integer", example=400),
     *     			@OA\Property(property="error_message", type="string", example="something went wrong please try again later."),
     *            )
     *        )
     * )
     *)
     */
    public function list(): JsonResponse
    {
        return CustomResponse::successResponse('success',
            ProductResource::collection($this->productService->list()));
    }

    /**
     * @param ProductCreateRequest $request
     * @return JsonResponse
     * @throws CustomQueryException
     *
     * @OA\Post(
     *    path="/api/v1/products/store",
     *   summary="store product",
     *   tags={"Product Controller"},
     *   security={{"bearer_token":{}}},
     * @OA\RequestBody(description="store product",
     * 	@OA\MediaType(mediaType="application/json",
     *   	@OA\Schema(
     *     		@OA\Property(property="name", type="string"),
     *     		@OA\Property(property="price", type="integer"),
     *        )
     *   )
     * ),
     * @OA\SecurityScheme(
     *     securityScheme="BearerAuth",
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="JWT"
     * ),
     * @OA\Response(response=200, description="Successfull operation.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="code", type="integer", example=200),
     *     			@OA\Property(property="data", type="json", example={
    "message": "success",
    "data": {
    "id": 5,
    "name": "asd",
    "price": "12.00",
    "created_at": "2023-06-19T20:06:34.000000Z",
    "updated_at": "2023-06-19T20:40:25.000000Z"
    }
    })
     *            )
     *        )
     * ),
     *@OA\Response(response=400, description="Invalid Data.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="error_code", type="integer", example=400),
     *     			@OA\Property(property="error_message", type="string", example="Invalid Data."),
     *            )
     *        )
     * ),
     *@OA\Response(response=500, description="something went wrong please try again later.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="error_code", type="integer", example=400),
     *     			@OA\Property(property="error_message", type="string", example="something went wrong please try again later."),
     *            )
     *        )
     * )
     *)
     *
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
     *
     *  *
     * @OA\Get(
     *    path="/api/v1/products/{id}",
     *   summary="Get product",
     *   tags={"Product Controller"},
     * @OA\RequestBody(description="store product",
     * 	@OA\MediaType(mediaType="application/json",
     *   	@OA\Schema(
     *     		@OA\Property(property="id", type="string"),
     *        )
     *   )
     * ),
     * @OA\Response(response=200, description="Successfull operation.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="code", type="integer", example=200),
     *     			@OA\Property(property="data", type="json", example={
    "message": "success",
    "data": {
    "id": 5,
    "name": "asd",
    "price": "12.00",
    "created_at": "2023-06-19T20:06:34.000000Z",
    "updated_at": "2023-06-19T20:40:25.000000Z"
    }
    })
     *            )
     *        )
     * ),
     *@OA\Response(response=400, description="Invalid Data.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="error_code", type="integer", example=400),
     *     			@OA\Property(property="error_message", type="string", example="Invalid Data."),
     *            )
     *        )
     * ),
     *@OA\Response(response=500, description="something went wrong please try again later.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="error_code", type="integer", example=400),
     *     			@OA\Property(property="error_message", type="string", example="something went wrong please try again later."),
     *            )
     *        )
     * )
     *)
     *
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
     *
     * @OA\Put(
     *    path="/api/v1/product/update/{id}",
     *   summary="Update product",
     *   tags={"Product Controller"},
     * @OA\RequestBody(description="Update product",
     * 	@OA\MediaType(mediaType="application/json",
     *   	@OA\Schema(
     *     		@OA\Property(property="id", type="string"),
     *     		@OA\Property(property="name", type="string"),
     *     		@OA\Property(property="price", type="string"),
     *        )
     *   )
     * ),
     * @OA\Response(response=200, description="Successfull operation.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="code", type="integer", example=200),
     *     			@OA\Property(property="data", type="json", example={
    "message": "success",
    "data": {
    "id": 5,
    "name": "asd",
    "price": "12.00",
    "created_at": "2023-06-19T20:06:34.000000Z",
    "updated_at": "2023-06-19T20:40:25.000000Z"
    }
    })
     *            )
     *        )
     * ),
     *@OA\Response(response=400, description="Invalid Data.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="error_code", type="integer", example=400),
     *     			@OA\Property(property="error_message", type="string", example="Invalid Data."),
     *            )
     *        )
     * ),
     *@OA\Response(response=500, description="something went wrong please try again later.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="error_code", type="integer", example=400),
     *     			@OA\Property(property="error_message", type="string", example="something went wrong please try again later."),
     *            )
     *        )
     * )
     *)
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
     *
     *  *
     * @OA\Delete(
     *    path="/api/v1/products/{id}",
     *   summary="Delete Product",
     *   tags={"Product Controller"},
     * @OA\RequestBody(description="Delete Product",
     * 	@OA\MediaType(mediaType="application/json",
     *   	@OA\Schema(
     *     		@OA\Property(property="id", type="string"),
     *        )
     *   )
     * ),
     * @OA\Response(response=200, description="Successfull operation.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="code", type="integer", example=200),
     *     			@OA\Property(property="data", type="json", example={
    "message": "success",
    "data": {}})
     *            )
     *        )
     * ),
     *@OA\Response(response=400, description="Invalid Data.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="error_code", type="integer", example=400),
     *     			@OA\Property(property="error_message", type="string", example="Invalid Data."),
     *            )
     *        )
     * ),
     *@OA\Response(response=500, description="something went wrong please try again later.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="error_code", type="integer", example=400),
     *     			@OA\Property(property="error_message", type="string", example="something went wrong please try again later."),
     *            )
     *        )
     * )
     *)
     *
     */
    public function delete(int $id): JsonResponse
    {
        $this->productService->delete($id);
        return CustomResponse::successResponse('success');
    }
}
