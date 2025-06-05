<?php

namespace App\Http\Controllers;

use App\Utils\ApiResponseClass;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::with(['carts.items.product', 'orders', 'reviews', 'roles'])
            ->get()
            ->map(function ($user) {
                $totalCartValue = $user->carts->sum(function ($cart) {
                    return $cart->items->sum(function ($item) {
                        return $item->quantity * $item->product->price;
                    });
                });

                $totalCartItems = $user->carts->sum(function ($cart) {
                    return $cart->items->sum('quantity');
                });

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_active' => $user->is_active,
                    'total_carts' => $user->carts->count(),
                    'total_orders' => $user->orders->count(),
                    'total_reviews' => $user->reviews->count(),
                    'total_cart_value' => $totalCartValue,
                    'total_cart_items' => $totalCartItems,
                    'user_roles' => $user->roles->pluck('name')->implode(', '),

                    'carts' => $user->carts->map(function($cart) {
                        return [
                            'id' => $cart->id,
                            'created_at' => $cart->created_at,
                            'items_count' => $cart->items->count(),
                            'total' => $cart->items->sum(function ($item) {
                                return $item->quantity * $item->product->price;
                            }),
                        ];
                    }),
                    'orders' => $user->orders,
                    'reviews' => $user->reviews,
                ];
            });

        return ApiResponseClass::respondWithJSON($users, '');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'nullable|string|max:20',
                'is_active' => 'boolean',
            ]);

            $user = User::create($validatedData);
            DB::commit();
            return ApiResponseClass::respondWithJSON($user, 'Usuario creado exitosamente', 201);

        } catch (\Exception $e) {
            ApiResponseClass::rollback($e, 'Error creando al usuario');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = User::with(['carts.items.product', 'orders', 'reviews', 'roles'])->find($id);

        if (!$user) {
            return ApiResponseClass::respondWithJSON(null, 'Usuario no encontrado', 404);
        }

        $totalCartValue = $user->carts->sum(function ($cart) {
            return $cart->items->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
        });

        $totalCartItems = $user->carts->sum(function ($cart) {
            return $cart->items->sum('quantity');
        });

        $result = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_active' => $user->is_active,
            'total_carts' => $user->carts->count(),
            'total_orders' => $user->orders->count(),
            'total_reviews' => $user->reviews->count(),
            'total_cart_value' => $totalCartValue,
            'total_cart_items' => $totalCartItems,
            'user_roles' => $user->roles->pluck('name')->implode(', '),

            'carts' => $user->carts->map(function($cart) {
                return [
                    'id' => $cart->id,
                    'created_at' => $cart->created_at,
                    'items_count' => $cart->items->count(),
                    'total' => $cart->items->sum(function ($item) {
                        return $item->quantity * $item->product->price;
                    }),
                ];
            }),
            'orders' => $user->orders,
            'reviews' => $user->reviews,
        ];

        return ApiResponseClass::respondWithJSON($result, 'Usuario encontrado exitosamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return ApiResponseClass::respondWithJSON(null, 'Usuario no encontrado', 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $user->update($validatedData);

        return ApiResponseClass::respondWithJSON($user, 'Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return ApiResponseClass::respondWithJSON(null, 'Usuario no encontrado', 404);
        }

        $user->delete();

        return ApiResponseClass::respondWithJSON($user, 'Usuario eliminado exitosamente');
    }
}
