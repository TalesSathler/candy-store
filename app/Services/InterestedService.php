<?php

namespace App\Services;

use App\Jobs\SendMail;
use App\Models\Product;
use App\Services\Interfaces\InterestedServiceInterface;
use App\Models\Interested;
use Illuminate\Http\Request;

class InterestedService implements InterestedServiceInterface
{
    /**
     * Returns all interested
     * @param Request $request
     * @return Interested[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        //Search interested
        return Interested::all();
    }

    /**
     * Return an interested
     * @param Request $request
     * @return Product[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getOne(Request $request)
    {
        $interested = $request->route('Interested');
        //Search interested
        return Interested::find($interested);
    }

    /**
     * Save an interested
     * @param Request $request
     * @return Interested
     */
    public function save(Request $request)
    {
        $interested = new Interested($request->all());
        $interested->save();

        //Check availability of product
        if ($interested->product->product_amount > 0) {
            $emailJob = (new SendMail($interested))->onQueue('emails');
            dispatch($emailJob);

            $interested->interested_sent = true;
            $interested->save();
        }

        return $interested;
    }

    /**
     * Edit an interested
     * @param Request $request
     * @return mixed
     */
    public function edit(Request $request)
    {
        //Search and save interested
        $interested = Interested::find($request->route('interested_id'));
        $interested->fill($request->all());
        $interested->save();
        return $interested;
    }

    /**
     * Remove an interested
     * @param Request $request
     * @return mixed
     */
    public function remove(Request $request)
    {
        //Search interested
        $interested = Interested::find($request->route('interested_id'));
        $interested->delete();
        return $interested;
    }

    /**
     * Remove an interested searched by product
     * @param Product $product
     * @return void
     */
    public function removeByProduct(Product $product)
    {
        //Search interested
        $collectionInterested = Interested::where('product_id', $product->product_id)->get();
        foreach ($collectionInterested as $interested) {
            $interested->delete();
        }
    }
}
