<?php

namespace App\Http\Controllers;

use App\Utils\ApiResponseClass;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $products = Product::with(['brand', 'categories'])->get();
        return ApiResponseClass::respondWithJSON($products, '');
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
                'description' => 'nullable|string|max:1000',
                'price' => 'required|numeric|min:0|max:999999.99',
                'brand_id' => 'required|exists:brands,id',
                'is_active' => 'boolean',
            ]);

            $product = Product::create($validatedData);
            
            // Cargar relaciones para la respuesta
            $product->load(['brand', 'categories']);
            
            DB::commit();
            return ApiResponseClass::respondWithJSON($product, 'Producto creado exitosamente', 201);

        } catch (\Exception $e) {
            ApiResponseClass::rollback($e, 'Error creando el producto');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $product = Product::with(['brand', 'categories', 'suppliers', 'inventories'])->find($id);
        
        if (!$product) {
            return ApiResponseClass::respondWithJSON(null, 'Producto no encontrado', 404);
        }

        return ApiResponseClass::respondWithJSON($product, 'Producto encontrado exitosamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $product = Product::find($id);
        
        if (!$product) {
            return ApiResponseClass::respondWithJSON(null, 'Producto no encontrado', 404);
        }

        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'price' => 'sometimes|required|numeric|min:0|max:999999.99',
                'brand_id' => 'sometimes|required|exists:brands,id',
                'is_active' => 'boolean',
            ]);

            $product->update($validatedData);
            
            // Cargar relaciones para la respuesta
            $product->load(['brand', 'categories']);
            
            DB::commit();
            return ApiResponseClass::respondWithJSON($product, 'Producto actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return ApiResponseClass::respondWithJSON(null, 'Error actualizando el producto', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $product = Product::find($id);
        
        if (!$product) {
            return ApiResponseClass::respondWithJSON(null, 'Producto no encontrado', 404);
        }

        DB::beginTransaction();
        try {
            // Verificar si el producto tiene relaciones que impidan su eliminación
            if ($product->cartItems()->exists() || $product->reviews()->exists()) {
                return ApiResponseClass::respondWithJSON(
                    null, 
                    'No se puede eliminar el producto porque tiene elementos relacionados', 
                    400
                );
            }

            $productData = $product->toArray();
            $product->delete();
            
            DB::commit();
            return ApiResponseClass::respondWithJSON($productData, 'Producto eliminado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return ApiResponseClass::respondWithJSON(null, 'Error eliminando el producto', 500);
        }
    }

    /**
     * Get products by brand
     */
    public function getByBrand(string $brandId): JsonResponse
    {
        $products = Product::with(['brand', 'categories'])
                          ->where('brand_id', $brandId)
                          ->where('is_active', true)
                          ->get();

        return ApiResponseClass::respondWithJSON($products, 'Productos encontrados exitosamente');
    }

    /**
     * Get products by category
     */
    public function getByCategory(string $categoryId): JsonResponse
    {
        $products = Product::with(['brand', 'categories'])
                          ->whereHas('categories', function ($query) use ($categoryId) {
                              $query->where('category_id', $categoryId);
                          })
                          ->where('is_active', true)
                          ->get();

        return ApiResponseClass::respondWithJSON($products, 'Productos encontrados exitosamente');
    }

    /**
     * Search products by name or description
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->validate([
            'q' => 'required|string|min:2|max:255'
        ]);

        $products = Product::with(['brand', 'categories'])
                          ->where(function ($queryBuilder) use ($query) {
                              $queryBuilder->where('name', 'LIKE', '%' . $query['q'] . '%')
                                          ->orWhere('description', 'LIKE', '%' . $query['q'] . '%');
                          })
                          ->where('is_active', true)
                          ->get();

        return ApiResponseClass::respondWithJSON($products, 'Búsqueda completada exitosamente');
    }

    /**
     * Toggle product status
     */
    public function toggleStatus(string $id): JsonResponse
    {
        $product = Product::find($id);
        
        if (!$product) {
            return ApiResponseClass::respondWithJSON(null, 'Producto no encontrado', 404);
        }

        $product->update(['is_active' => !$product->is_active]);
        $product->load(['brand', 'categories']);

        $status = $product->is_active ? 'activado' : 'desactivado';
        return ApiResponseClass::respondWithJSON($product, "Producto {$status} exitosamente");
    }
}