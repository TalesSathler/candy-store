<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface InterestedServiceInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function get(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function edit(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function remove(Request $request);
}
