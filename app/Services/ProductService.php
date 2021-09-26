<?php

namespace App\Services;

use App\Services\Interfaces\ProductServiceInterface;
use App\Jobs\SendMail;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductService implements ProductServiceInterface
{
    /**
     * Returns all products
     * @param Request $request
     * @return Product[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function get(Request $request)
    {
        $productType = $request->query('productType');
        if ($productType) {
            //Search products
            return Product::where('product_type', ucfirst($productType))->get();
        }

        //Search products
        return Product::all();
    }

    /**
     * Return a product
     * @param Request $request
     * @return Product[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getOne(Request $request)
    {
        $productId = $request->route('product_id');
        //Search product
        return Product::find($productId);
    }

    /**
     * Save a product
     * @param Request $request
     * @return Product
     */
    public function save(Request $request)
    {
        $product = new Product($request->all());
        $product->save();
        return $product;
    }

    /**
     * Edit a product
     * @param Request $request
     * @return mixed
     */
    public function edit(Request $request)
    {
        //Search and save product
        $product = Product::find($request->route('product_id'));
        $product->fill($request->all());
        $product->save();

        //Check availability of product
        if ($product->product_amount > 0) {
            foreach ($product->interested()->where('interested_sent', false)->get() as $interested) {
                $emailJob = (new SendMail($interested->toArray()))->onQueue('emails');
                dispatch($emailJob);

                $interested->interested_sent = true;
                $interested->save();
            }
        }

        return $product;
    }

    /**
     * Remove a product
     * @param Request $request
     * @return mixed
     */
    public function remove(Request $request)
    {
        //Search product
        $product = Product::find($request->route('product_id'));

        $interestedService = new InterestedService();
        $interestedService->removeByProduct($product);

        $product->delete();
        return $product;
    }
}
