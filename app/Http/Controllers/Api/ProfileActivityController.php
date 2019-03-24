<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateProfileActivityRequest;
use App\Queries\ProfileActivityQuery;
use Illuminate\Http\JsonResponse;

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

        $profileActivities = $this->profileActivity->createMany($validatedActivities['data']);

        if ($profileActivities->isEmpty()) {
            return response()->json([
                'message' => 'No new profile activities were created'
            ], JsonResponse::HTTP_OK);
        }

        return response()->json([
            'message' => 'Profile activities were created successfully'
        ], JsonResponse::HTTP_CREATED);
    }
}
