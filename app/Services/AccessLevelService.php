<?php

namespace App\Services;

use App\Models\AccessLevel;

use Exception;
use Illuminate\Support\Str;

class AccessLevelService
{

    public function create(array $data)
    {
        $access_level = AccessLevel::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'status' => 'active'
        ]);
        return $access_level;
    }

    /**
     * Return information about all access_levels to admin.
     *
     * @return mixed
     */
    public function getAllAccessLevels()
    {
        return AccessLevel::paginate(50);
    }

    /**
     * Return all information about a access_level.
     *
     * @param $id
     */
    public function getAccessLevel(int $id)
    {
        $access_level = AccessLevel::findOrFail($id);

        return $access_level;
    }


    /**
     * Update a access_level.
     *
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function updateAccessLevel(int $id, array $data)
    {

        $access_level = AccessLevel::findOrFail($id);

        $access_level->name = $data['name'] ?? $access_level->name;
        $access_level->slug = Str::slug($access_level->name);

        $access_level->save();
        return $access_level;
    }



    /**
     * Update access_level status.
     *
     * @return mixed
     */
    public function updateAccessLevelStatus(int $id, string $status)
    {
        $access_level = AccessLevel::findOrFail($id);
        $access_level->status = $status;

        $access_level->save();

        return $access_level;
    }

    /**
     * Deletes a access_level.
     */
    public function deleteAccessLevel(int $id)
    {
        $access_level = AccessLevel::findOrFail($id);

        $access_level->delete($id);


        return true;
    }
}
