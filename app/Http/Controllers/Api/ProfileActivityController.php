<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateProfileActivityRequest;
use App\Repositories\ProfileActivityRepository;
use Illuminate\Http\JsonResponse;

class ProfileActivityController extends Controller
{
    /** @var ProfileActivityRepository */
    private $profileActivityRepository;

    /**
     * @param ProfileActivityRepository $profileActivityRepository
     */
    public function __construct(ProfileActivityRepository $profileActivityRepository)
    {
        $this->profileActivityRepository = $profileActivityRepository;
    }

    /**
     * @param CreateProfileActivityRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateProfileActivityRequest $request)
    {
        $validatedActivities = $request->validated();

        $profileActivities = $this->profileActivityRepository->createMany($validatedActivities['data']);

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
