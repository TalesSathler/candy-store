<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Return products
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function get(Request $request)
    {
        try {
            if ($request->route('product_id')) {
                $data = $this->productService->getOne($request);
                if (!$data) {
                    return (new ProductResource([]))
                        ->additional(['message' => 'Product not found!'])->response()->setStatusCode(404);
                }

                return (new ProductResource($data))
                    ->additional(['message' => 'Successfully retrieved product!'])->response()->setStatusCode(200);
            }

            $data = $this->productService->get($request);
            return (new ProductResourceCollection($data))
                ->additional(['message' => 'Successfully retrieved product!'])->response()->setStatusCode(200);
        } catch (\Exception $exception) {
            return (new ProductResource([]))
                ->additional(['message' => 'Error try retrieved product, please try again! ' . $exception->getMessage()])->response()->setStatusCode(400);
        }
    }

    /**
     * Create new product
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|max:255',
            'product_weight' => 'required|regex:/^[0-9]+(\.[0-9]{1,2})?$/',
            'product_price' => 'required|regex:/^[0-9]+(\.[0-9]{1,2})?$/',
            'product_amount' => 'required|integer',
            'product_type' => 'required|in:Cake,Pie'
        ]);

        if ($validator->fails()) {
            return (new ProductResource([]))
                ->additional(['message' => $validator->getMessageBag()->getMessages()])->response()->setStatusCode(400);
        }


        try {
            DB::beginTransaction();
            $product = $this->productService->save($request);
            DB::commit();
        } catch (\Exception $exception) {
            return (new ProductResource([]))
                ->additional(['message' => 'Error try storing product, please try again! ' . $exception->getMessage()])->response()->setStatusCode(400);
        }

        return (new ProductResource($product))
            ->additional(['message' => 'Product stored with success!'])->response()->setStatusCode(200);
    }

    /**
     * Update a product
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,product_id',
            'product_name' => 'required|max:255',
            'product_weight' => 'required|regex:/^[0-9]+(\.[0-9]{1,2})?$/',
            'product_price' => 'required|regex:/^[0-9]+(\.[0-9]{1,2})?$/',
            'product_amount' => 'required|integer',
            'product_type' => 'required|in:Cake,Pie'
        ]);

        if ($validator->fails()) {
            return (new ProductResource([]))
                ->additional(['message' => $validator->getMessageBag()->getMessages()])->response()->setStatusCode(400);
        }


        try {
            DB::beginTransaction();
            $product = $this->productService->edit($request);
            DB::commit();
        } catch (\Exception $exception) {
            return (new ProductResource([]))
                ->additional(['message' => 'Error try updating product, please try again! ' . $exception->getMessage()])->response()->setStatusCode(400);
        }

        return (new ProductResource($product))
            ->additional(['message' => 'Product updated with success!'])->response()->setStatusCode(200);
    }

    /**
     * Delete a product
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $validator = Validator::make($request->route()->parameters(), [
            'product_id' => 'required|exists:products,product_id',
        ]);

        if ($validator->fails()) {
            return (new ProductResource([]))
                ->additional(['message' => $validator->getMessageBag()->getMessages()])->response()->setStatusCode(400);
        }

        try {
            DB::beginTransaction();
            $product = $this->productService->remove($request);
            DB::commit();
        } catch (\Exception $exception) {
            return (new ProductResource([]))
                ->additional(['message' => 'Error try deleting product, please try again! ' . $exception->getMessage()])->response()->setStatusCode(400);
        }

        return (new ProductResource($product))
            ->additional(['message' => 'Product deleted with success!'])->response()->setStatusCode(200);
    }
}
