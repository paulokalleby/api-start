<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $entity;

    public function __construct(User $model)
    {
        $this->entity = $model;
    }

    public function getAllUsers(array $filters = [])
    {
        return  $this->entity
            ->where(function ($query) use ($filters) {

                if (isset($filters['name'])) {
                    $query->where('name', 'LIKE', "%{$filters['name']}%");
                }

                if (isset($filters['active'])) {
                    $query->whereActive($filters['active']);
                } else {
                    $query->whereActive(1);
                }
            })
            ->paginate();
    }

    public function getUserById(string $id)
    {
        return $this->entity->findOrFail($id);
    }

    public function createUser(array $data)
    {
        $data['password'] = bcrypt($data['password']);

        return $this->entity->create($data);
    }

    public function updateUser(array $data, string $id)
    {
        $user = $this->entity->findOrFail($id);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function deleteUser(string $id)
    {
        $user = $this->entity->findOrFail($id);

        if (in_array($user->email, config('acl.admins'))) {

            return response()->json([
                'message' => 'Esta ação não é autorizada.'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
