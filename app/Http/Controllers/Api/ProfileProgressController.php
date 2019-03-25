<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateProfileProgressRequest;
use App\Repositories\ProfileProgressRepository;
use Illuminate\Http\JsonResponse;

class ProfileProgressController extends Controller
{
    /** @var ProfileProgressRepository */
    private $profileProgressRepository;

    /**
     * @param ProfileProgressRepository $profileProgressRepository
     */
    public function __construct(ProfileProgressRepository $profileProgressRepository)
    {
        $this->profileProgressRepository = $profileProgressRepository;
    }

    /**
     * @param CreateProfileProgressRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateProfileProgressRequest $request)
    {
        $validatedProgress = $request->validated();

        $profileProgresses = $this->profileProgressRepository->createMany($validatedProgress['data']);

        if ($profileProgresses->isEmpty()) {
            return response()->json([
                'message' => 'No new profile progresses were created'
            ], JsonResponse::HTTP_OK);
        }

        return response()->json([
            'message' => 'Profile progresses were created successfully'
        ], JsonResponse::HTTP_CREATED);
    }
}
