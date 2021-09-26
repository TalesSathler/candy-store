<?php

namespace App\Http\Controllers;

use App\Http\Resources\InterestedResource;
use App\Http\Resources\InterestedResourceCollection;
use App\Services\Interfaces\InterestedServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class InterestedController extends Controller
{
    private $interestedService;

    public function __construct(InterestedServiceInterface $interestedService)
    {
        $this->interestedService = $interestedService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function get(Request $request)
    {
        try {
            if ($request->route('interested_id')) {
                $data = $this->interestedService->getOne($request);
                if (!$data) {
                    return (new InterestedResource([]))
                        ->additional(['message' => 'Interested not found!'])->response()->setStatusCode(404);
                }

                return (new InterestedResource($data))
                    ->additional(['message' => 'Successfully retrieved interested!'])->response()->setStatusCode(200);
            }

            $data = $this->interestedService->get($request);
            return (new InterestedResourceCollection($data))
                ->additional(['message' => 'Successfully retrieved interested!'])->response()->setStatusCode(200);
        } catch (\Exception $exception) {
            return (new InterestedResource([]))
                ->additional(['message' => 'Error try retrieved interested, please try again! ' . $exception->getMessage()])->response()->setStatusCode(400);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'interested_name' => 'required|max:255',
            'interested_email' => 'required|email|max:255',
            'product_id' => 'required|exists:products,product_id',
        ]);

        if ($validator->fails()) {
            return (new InterestedResource([]))
                ->additional(['message' => $validator->getMessageBag()->getMessages()])->response()->setStatusCode(400);
        }


        try {
            DB::beginTransaction();
            $interested = $this->interestedService->save($request);
            DB::commit();
        } catch (\Exception $exception) {
            return (new InterestedResource([]))
                ->additional(['message' => 'Error try storing interested, please try again! ' . $exception->getMessage()])->response()->setStatusCode(400);
        }

        return (new InterestedResource($interested))
            ->additional(['message' => 'Interested stored with success!'])->response()->setStatusCode(200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'interested_id' => 'required|exists:interested,interested_id',
            'interested_name' => 'required|max:255',
            'interested_email' => 'required|email|max:255',
            'product_id' => 'required|exists:products,product_id',
        ]);

        if ($validator->fails()) {
            return (new InterestedResource([]))
                ->additional(['message' => $validator->getMessageBag()->getMessages()])->response()->setStatusCode(400);
        }


        try {
            DB::beginTransaction();
            $interested = $this->interestedService->edit($request);
            DB::commit();
        } catch (\Exception $exception) {
            return (new InterestedResource([]))
                ->additional(['message' => 'Error try updating interested, please try again! ' . $exception->getMessage()])->response()->setStatusCode(400);
        }

        return (new InterestedResource($interested))
            ->additional(['message' => 'Interested updated with success!'])->response()->setStatusCode(200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $validator = Validator::make($request->route()->parameters(), [
            'interested_id' => 'required|exists:interested,interested_id',
        ]);

        if ($validator->fails()) {
            return (new InterestedResource([]))
                ->additional(['message' => $validator->getMessageBag()->getMessages()])->response()->setStatusCode(400);
        }

        try {
            DB::beginTransaction();
            $interested = $this->interestedService->remove($request);
            DB::commit();
        } catch (\Exception $exception) {
            return (new InterestedResource([]))
                ->additional(['message' => 'Error try deleting interested, please try again! ' . $exception->getMessage()])->response()->setStatusCode(400);
        }

        return (new InterestedResource($interested))
            ->additional(['message' => 'Interested deleted with success!'])->response()->setStatusCode(200);
    }
}
