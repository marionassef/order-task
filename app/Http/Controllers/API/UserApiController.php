<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CustomQueryException;
use App\Exceptions\CustomValidationException;
use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(title="Order Task", version="0.1")
 */
class UserApiController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws CustomValidationException
     * @throws CustomQueryException
     * * @OA\Post(
     *    path="/api/v1/users/register",
     *   summary="Register new user",
     *   tags={"Users Controller"},
     * @OA\RequestBody(description="Register new user",
     * 	@OA\MediaType(mediaType="application/json",
     *   )
     * ),
     * @OA\Response(response=200, description="Successfull operation.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="code", type="integer", example=200),
     *     			@OA\Property(property="data", type="json", example={
    "message": "success",
    "data": {
    "id": 8,
    "name": "mario anassf",
    "email": "dev.mario.nassef@gmail.com",
    "created_at": "2023-06-24 14:11:11",
    "updated_at": "2023-06-24 14:11:11",
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiZjQzMmNmMDI5OWU1ODA0NjdjZGVhZWYxMDY1NWJmNzM1ZDU2OGNhNWFkZGUzZDY1MGY5MmI3MGFlOGI4ZTFmNTJkNDk1YTNiMTc0ZjkzMWQiLCJpYXQiOjE2ODc2MTU4NzEuMTk4MDIxLCJuYmYiOjE2ODc2MTU4NzEuMTk4MDIzLCJleHAiOjE2ODgwNDc4NzEuMTgzOTg5LCJzdWIiOiI4Iiwic2NvcGVzIjpbIioiXX0.f9d1aXEvJFEigvIQmLDfE-gG_T9JdFnI86smZVQgwtPsD0o0tK4KaGQz7z4BJ6zUhPa_aJSP7HSIjagBkV7Q9XiGYyANi3733dEspCUKKgfpxDNPsyD7Hshs4nIs6ctl_W92v9t-gU8MEMYY8tpfC-Ot941r2jwS0d6c_mm_h2MkBIwGRe2MfaAHzYdggnvR1EfM8Rgh-N-31rJ69WoducmjoM3V0bPWkZIDQM0nn2RrZhGpDTDicmbeBjCOVCpgXtyvdDymYCjDCRmg3BYIBL3ER7D7HP2xJog-3DxLqKDbPy_g0d7mQkSbYTpu3J0tn705xw268z5ZwzvQUTM-oUelLYMywpLf10jOtezaDrprb-FYectbmEVsxYLoLtu4-F7DTT6dehqd4Ck4P3qQEbxVBglxzmkuPtaPvGg4YIaX84DMMI_WfsXRzbsZ3dfmNuyJTPZTrS52f1JtI0KBfBQ2zyK2eJ1K4NTdFybUGFzhxI9DwM-hBfA05QmoXk-jOq6a4L4UeRqtyvUgIfSNtSzWN0IFnDgmI8cRCu0eXg7o_RhdZWNR46CF9q79ZnyflLd3_vAhhqe11Vtt0NxvJ-NkirhjCG-K-xdM8xynYfeaJxchh5gS1srSm-VXao3ptNtMMXnQ03ygy4RYzGID-duG2-9biscElXV9DrfcOIw",
    "refresh_token": "def50200c1f860c5159f8703e98885cd1025c5297a2daf8ad0a3c9ebb86128bf9cd5da6794f78cc039dd1e1ba30c9a4a6c9ee8aa23a0d969fae0aead73a0f340fd5860b5d9033b4334df48ba1d520ad821c7bbfed7b9173716bdbe017f8e2f3923a9eb703133e3bad0dde04470dabd0ac4db758c649c75d2fa9b5b0e60313e9e0ea28cfd6e672083eca214b22735fba20be2812f229641a037a75246041116feeb2a00b767c54ce5fa1c164b7b7471f9bc17df05eec206170ce75f95e64cf0d824f1eb6d959657009ebf1946c3f5cb09c75bb9391d2dde17717673cd6ae7cd309e7a9fc9b351ec280395f2d96e2767fc4c25922c1762ba2cd9e12820f858a9faad9c473ca90a95932042e5d6b1f207108f3086f97692c765a679b3587213b1486f5061532b27122dea9ddc9bf47af0741c1f54b6370862eec24452d5dd3ed628eef149aa198183b3f4467cf6364730a1add041d38736e86b8d42c1524a6acfa9468e4d22"
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
    public function register(RegisterRequest $request): JsonResponse
    {
        return CustomResponse::successResponse('success',
            new UserResource($this->userService->register($request->validated())), 201);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws CustomValidationException
     * @throws CustomQueryException|AuthenticationException
     * @OA\Post(
     *    path="/api/v1/users/login",
     *   summary="User login",
     *   tags={"Users Controller"},
     * @OA\RequestBody(description="store Item",
     * 	@OA\MediaType(mediaType="application/json",
     *   	@OA\Schema(
     *     		@OA\Property(property="name", type="string"),
     *     		@OA\Property(property="price", type="integer"),
     *     		@OA\Property(property="seller", type="integer"),
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
    "id": 8,
    "name": "mario anassf",
    "email": "dev.mario.nassef@gmail.com",
    "created_at": "2023-06-24 14:11:11",
    "updated_at": "2023-06-24 14:11:11",
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiZjQzMmNmMDI5OWU1ODA0NjdjZGVhZWYxMDY1NWJmNzM1ZDU2OGNhNWFkZGUzZDY1MGY5MmI3MGFlOGI4ZTFmNTJkNDk1YTNiMTc0ZjkzMWQiLCJpYXQiOjE2ODc2MTU4NzEuMTk4MDIxLCJuYmYiOjE2ODc2MTU4NzEuMTk4MDIzLCJleHAiOjE2ODgwNDc4NzEuMTgzOTg5LCJzdWIiOiI4Iiwic2NvcGVzIjpbIioiXX0.f9d1aXEvJFEigvIQmLDfE-gG_T9JdFnI86smZVQgwtPsD0o0tK4KaGQz7z4BJ6zUhPa_aJSP7HSIjagBkV7Q9XiGYyANi3733dEspCUKKgfpxDNPsyD7Hshs4nIs6ctl_W92v9t-gU8MEMYY8tpfC-Ot941r2jwS0d6c_mm_h2MkBIwGRe2MfaAHzYdggnvR1EfM8Rgh-N-31rJ69WoducmjoM3V0bPWkZIDQM0nn2RrZhGpDTDicmbeBjCOVCpgXtyvdDymYCjDCRmg3BYIBL3ER7D7HP2xJog-3DxLqKDbPy_g0d7mQkSbYTpu3J0tn705xw268z5ZwzvQUTM-oUelLYMywpLf10jOtezaDrprb-FYectbmEVsxYLoLtu4-F7DTT6dehqd4Ck4P3qQEbxVBglxzmkuPtaPvGg4YIaX84DMMI_WfsXRzbsZ3dfmNuyJTPZTrS52f1JtI0KBfBQ2zyK2eJ1K4NTdFybUGFzhxI9DwM-hBfA05QmoXk-jOq6a4L4UeRqtyvUgIfSNtSzWN0IFnDgmI8cRCu0eXg7o_RhdZWNR46CF9q79ZnyflLd3_vAhhqe11Vtt0NxvJ-NkirhjCG-K-xdM8xynYfeaJxchh5gS1srSm-VXao3ptNtMMXnQ03ygy4RYzGID-duG2-9biscElXV9DrfcOIw",
    "refresh_token": "def50200c1f860c5159f8703e98885cd1025c5297a2daf8ad0a3c9ebb86128bf9cd5da6794f78cc039dd1e1ba30c9a4a6c9ee8aa23a0d969fae0aead73a0f340fd5860b5d9033b4334df48ba1d520ad821c7bbfed7b9173716bdbe017f8e2f3923a9eb703133e3bad0dde04470dabd0ac4db758c649c75d2fa9b5b0e60313e9e0ea28cfd6e672083eca214b22735fba20be2812f229641a037a75246041116feeb2a00b767c54ce5fa1c164b7b7471f9bc17df05eec206170ce75f95e64cf0d824f1eb6d959657009ebf1946c3f5cb09c75bb9391d2dde17717673cd6ae7cd309e7a9fc9b351ec280395f2d96e2767fc4c25922c1762ba2cd9e12820f858a9faad9c473ca90a95932042e5d6b1f207108f3086f97692c765a679b3587213b1486f5061532b27122dea9ddc9bf47af0741c1f54b6370862eec24452d5dd3ed628eef149aa198183b3f4467cf6364730a1add041d38736e86b8d42c1524a6acfa9468e4d22"
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
    public function login(LoginRequest $request): JsonResponse
    {
        return CustomResponse::successResponse('success',
            new UserResource($this->userService->login($request->validated())), 200);
    }

    /**
     * @throws CustomQueryException
     * @OA\Get(
     *    path="/api/v1/users",
     *   summary="listing of the users",
     *   tags={"Users Controller"},
     * @OA\RequestBody(description="listing of the users",
     * 	@OA\MediaType(mediaType="application/json",
     *   )
     * ),
     * @OA\Response(response=200, description="Successfull operation.",
     *      @OA\MediaType(mediaType="application/json",
     * 			@OA\Schema(
     *     			@OA\Property(property="code", type="integer", example=200),
     *     			@OA\Property(property="data", type="json", example={
    "message": "success",
    "data": {
    {
    "id": 8,
    "name": "mario anassf",
    "email": "dev2.mario.nassef@gmail.com",
    "created_at": "2023-06-24 14:11:11",
    "updated_at": "2023-06-24 14:11:11",
    "access_token": null,
    "refresh_token": null
    },
    {
    "id": 7,
    "name": "mario anassf",
    "email": "d1.mario.nassef@gmail.com",
    "created_at": "2023-06-24 12:02:19",
    "updated_at": "2023-06-24 12:02:19",
    "access_token": null,
    "refresh_token": null
    },
    {
    "id": 6,
    "name": "mario anassf",
    "email": "ds.mario.nassef@gmail.com",
    "created_at": "2023-06-24 11:59:57",
    "updated_at": "2023-06-24 11:59:57",
    "access_token": null,
    "refresh_token": null
    },
    {
    "id": 5,
    "name": "mario anassf",
    "email": "dns.mario.nassef@gmail.com",
    "created_at": "2023-06-24 11:59:17",
    "updated_at": "2023-06-24 11:59:17",
    "access_token": null,
    "refresh_token": null
    },
    {
    "id": 4,
    "name": "mario anassf",
    "email": "dn.mario.nassef@gmail.com",
    "created_at": "2023-06-24 11:58:40",
    "updated_at": "2023-06-24 11:58:40",
    "access_token": null,
    "refresh_token": null
    },
    {
    "id": 3,
    "name": "mario anassf",
    "email": "da.mario.nassef@gmail.com",
    "created_at": "2023-06-24 11:56:57",
    "updated_at": "2023-06-24 11:56:57",
    "access_token": null,
    "refresh_token": null
    },
    {
    "id": 2,
    "name": "mario anassf",
    "email": "de.mario.nassef@gmail.com",
    "created_at": "2023-06-24 11:56:10",
    "updated_at": "2023-06-24 11:56:10",
    "access_token": null,
    "refresh_token": null
    },
    {
    "id": 1,
    "name": "mario anassf",
    "email": "dev.mario.nassef@gmail.com",
    "created_at": "2023-06-24 11:53:08",
    "updated_at": "2023-06-24 11:53:08",
    "access_token": null,
    "refresh_token": null
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
            UserResource::collection($this->userService->list()));
    }
}
