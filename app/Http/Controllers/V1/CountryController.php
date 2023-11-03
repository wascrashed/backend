<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Country\Models\Country;
use App\Tbuy\Country\Resources\CountryResource;


/**
 * @group Другое
 * @subgroup Страны
 * @authenticated
 */
class CountryController extends Controller
{
    /**
     * Список стран
     *
     * @responseFile status=200 storage/responses/country/index.json
     * @return SuccessResponse
     */
    public function __invoke(): SuccessResponse
    {
        return new SuccessResponse(
            response: CountryResource::collection(Country::all()),
            message: 'Список стран'
        );
    }
}
