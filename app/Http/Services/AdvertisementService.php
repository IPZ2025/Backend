<?php

namespace App\Http\Services;

use App\Http\Requests\StoreAdvertisementRequest;
use App\Http\Requests\UpdateAdvertisementRequest;
use App\Models\Advertisement;
use App\Models\Photo;
use App\Models\User;
use Ren\Http\Services\Utils\AuthUtil;

class AdvertisementService
{
    private $authUtil;

    public function __construct(AuthUtil $authUtil)
    {
        $this->authUtil = $authUtil;
    }

    public function listAdvertisementResources()
    {
        return Advertisement::paginate()->toResourceCollection();
    }

    public function createAdvertisement(StoreAdvertisementRequest $request, User $user)
    {
        $this->authUtil->checkUserAffiliation($user, "Try to create advertisement for another user");
        $advertisement = Advertisement::create([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
            "price" => $request->input("price"),
        ]);
        $this->setCategories($advertisement, $request->input("categories"));
        $this->setPhotos($advertisement, $request->input("photos"));
        $advertisement->refresh();
        return $advertisement->toResource();
    }

    public function getAdvertisementResource(User $user, Advertisement $advertisement)
    {
        return $advertisement->toResource();
    }

    public function updateAdvertisement(UpdateAdvertisementRequest $request, User $user, Advertisement $advertisement)
    {
        $this->authUtil->checkUserAffiliation($user, "Try to create advertisement for another user");
        $request->whenHas("name", fn() => $advertisement->name = $request->input("name"));
        $request->whenHas("description", fn() => $advertisement->description = $request->input("description"));
        $request->whenHas("price", fn() => $advertisement->price = $request->input("price"));
        //TODO
    }

    public function deleteAdvertisement(User $user, Advertisement $advertisement)
    {
        $this->authUtil->checkUserAffiliation($user, "Try to delete advertisement for another user");
        $advertisement->delete();
        return $advertisement->toRecource();
    }

    protected function setCategories(Advertisement $advertisement, array $categories)
    {
        if (!empty($categories)) {
            $advertisement->categories()->attach($categories);
        }
    }

    protected function updateCategories(Advertisement $advertisement, array $categories)
    {
        if (!empty($categories)) {
            $advertisement->categories()->sync($categories);
        }
    }

    protected function setPhotos(Advertisement $advertisement, array $photos)
    {
        if (!empty($photos)) {
            $photos = collect($photos)->map(fn($item) => ["url" => $item]);
            $advertisement->photos()->createMany($photos);
        }
    }

    protected function updatePhotos(Advertisement $advertisement, array $photos)
    {
        if (!empty($photos)) {
            $newPhotos = collect($photos);
            $advertisement->photos->each(function ($photo) use (&$newPhotos) {
                if (!$newPhotos->contains($photo->url)) {
                    $photo->delete();
                } else {
                    $newPhotos = $newPhotos->reject(fn($url) => $url == $photo->url);
                }
            });
            $photos = $newPhotos->map(fn($item) => ["url" => $item]);
            $advertisement->photos()->createMany($photos);
        }
    }
}
