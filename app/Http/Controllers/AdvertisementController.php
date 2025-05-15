<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdvertisementRequest;
use App\Http\Requests\UpdateAdvertisementRequest;
use App\Http\Services\AdvertisementService;
use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdvertisementController extends Controller implements HasMiddleware
{
    private $advertisementService;

    public function __construct(AdvertisementService $advertisementService)
    {
        $this->advertisementService = $advertisementService;
    }

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index', 'indexAll', 'show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        return $this->advertisementService->listAdvertisementResourcesForUser($user);
    }

    public function indexAll()
    {
        return $this->advertisementService->listAdvertisementResources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertisementRequest $request, User $user)
    {
        return $this->advertisementService->createAdvertisement($request, $user)->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Advertisement $advertisement)
    {
        return $this->advertisementService->getAdvertisementResource($user, $advertisement);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdvertisementRequest $request, User $user, Advertisement $advertisement)
    {
        return $this->advertisementService->updateAdvertisement($request, $user, $advertisement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Advertisement $advertisement)
    {
        return $this->advertisementService->deleteAdvertisement($user, $advertisement);
    }
}
