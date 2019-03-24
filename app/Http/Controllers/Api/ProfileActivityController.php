<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateProfileActivityRequest;
use App\Queries\ProfileActivityQuery;

class ProfileActivityController extends Controller
{
    /** @var ProfileActivityQuery */
    private $profileActivity;

    /**
     * @param ProfileActivityQuery $profileActivity
     */
    public function __construct(ProfileActivityQuery $profileActivity)
    {
        $this->profileActivity = $profileActivity;
    }

    /**
     * @param CreateProfileActivityRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateProfileActivityRequest $request)
    {
        $validatedActivities = $request->validated();

        $this->profileActivity->createMany($validatedActivities['data']);

        return response()->json([
            'message' => 'Profile activities were created successfully'
        ]);
    }
}
