# JSONs de Prueba - ProductController Endpoints

## 1. **GET /api/products** - Listar todos los productos
```http
GET /api/products
```
*No requiere body*

---

## 2. **POST /api/products** - Crear producto
```http
POST /api/products
Content-Type: application/json
```

```json
{
    "name": "iPhone 15 Pro Max",
    "description": "Smartphone premium con cámara de 48MP y chip A17 Pro",
    "price": 1199.99,
    "brand_id": 1,
    "is_active": true
}
```

**Ejemplo alternativo:**
```json
{
    "name": "Samsung Galaxy S24",
    "description": "Teléfono Android con IA integrada",
    "price": 899.50,
    "brand_id": 2,
    "is_active": false
}
```

---

## 3. **GET /api/products/{id}** - Mostrar producto específico
```http
GET /api/products/1
```
*No requiere body*

---

## 4. **PUT/PATCH /api/products/{id}** - Actualizar producto
```http
PUT /api/products/1
Content-Type: application/json
```

```json
{
    "name": "iPhone 15 Pro Max - Actualizado",
    "description": "Smartphone premium con cámara de 48MP, chip A17 Pro y batería mejorada",
    "price": 1099.99,
    "brand_id": 1,
    "is_active": true
}
```

**Actualización parcial:**
```json
{
    "price": 999.99,
    "is_active": false
}
```

---

## 5. **DELETE /api/products/{id}** - Eliminar producto
```http
DELETE /api/products/1
```
*No requiere body*

---

## 6. **GET /api/products/brand/{brandId}** - Productos por marca
```http
GET /api/products/brand/1
```
*No requiere body*

---

## 7. **GET /api/products/category/{categoryId}** - Productos por categoría
```http
GET /api/products/category/1
```
*No requiere body*

---

## 8. **GET /api/products/search** - Buscar productos
```http
GET /api/products/search?q=iPhone
```

**O usando POST:**
```http
POST /api/products/search
Content-Type: application/json
```

```json
{
    "q": "smartphone"
}
```

**Otros ejemplos de búsqueda:**
```json
{
    "q": "Samsung"
}
```

```json
{
    "q": "cámara"
}
```

---

## 9. **PATCH /api/products/{id}/toggle-status** - Alternar estado
```http
PATCH /api/products/1/toggle-status
```
*No requiere body*

---

## 10. **POST /api/products/{id}/suppliers** - Asociar proveedores
```http
POST /api/products/1/suppliers
Content-Type: application/json
```

```json
{
    "suppliers": [
        {
            "supplier_id": 1,
            "cost_price": 45.50,
            "is_primary": true
        },
        {
            "supplier_id": 2,
            "cost_price": 47.00,
            "is_primary": false
        }
    ]
}
```

**Un solo proveedor:**
```json
{
    "suppliers": [
        {
            "supplier_id": 3,
            "cost_price": 42.75,
            "is_primary": false
        }
    ]
}
```

---

## 11. **DELETE /api/products/{id}/suppliers** - Remover proveedores
```http
DELETE /api/products/1/suppliers
Content-Type: application/json
```

```json
{
    "supplier_ids": [1, 2]
}
```

**Remover un solo proveedor:**
```json
{
    "supplier_ids": [3]
}
```

---

## 12. **PATCH /api/products/{id}/suppliers/{supplierId}** - Actualizar proveedor específico
```http
PATCH /api/products/1/suppliers/1
Content-Type: application/json
```

```json
{
    "cost_price": 44.00,
    "is_primary": false
}
```

**Solo actualizar precio:**
```json
{
    "cost_price": 43.25
}
```

**Solo cambiar si es primario:**
```json
{
    "is_primary": true
}
```

---

## 13. **POST /api/products/{id}/categories** - Asociar categorías
```http
POST /api/products/1/categories
Content-Type: application/json
```

```json
{
    "category_ids": [1, 2, 3]
}
```

**Una sola categoría:**
```json
{
    "category_ids": [4]
}
```

---

## 14. **DELETE /api/products/{id}/categories** - Remover categorías
```http
DELETE /api/products/1/categories
Content-Type: application/json
```

```json
{
    "category_ids": [1, 3]
}
```

**Remover una sola categoría:**
```json
{
    "category_ids": [2]
}
```

---

## **Respuestas de Ejemplo**

### Respuesta exitosa (200/201):
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "iPhone 15 Pro Max",
        "description": "Smartphone premium con cámara de 48MP y chip A17 Pro",
        "price": "1199.99",
        "brand_id": 1,
        "is_active": true,
        "brand": {
            "id": 1,
            "name": "Apple"
        },
        "categories": [
            {
                "id": 1,
                "name": "Smartphones"
            }
        ],
        "suppliers": [
            {
                "id": 1,
                "name": "Tech Distributor",
                "pivot": {
                    "cost_price": "45.50",
                    "is_primary": true
                }
            }
        ]
    },
    "message": "Producto creado exitosamente"
}
```

### Respuesta de error (404):
```json
{
    "success": false,
    "data": null,
    "message": "Producto no encontrado"
}
```

### Respuesta de validación (422):
```json
{
    "success": false,
    "data": null,
    "message": "Error de validación",
    "errors": {
        "name": ["El campo nombre es obligatorio"],
        "price": ["El precio debe ser un número positivo"],
        "brand_id": ["La marca seleccionada no existe"]
    }
}
```

---

## **Notas de Testing**

1. **IDs de prueba**: Asegúrate de que existan los IDs de brands, categories y suppliers que uses
2. **Precios**: Usa formato decimal con máximo 2 decimales
3. **Búsquedas**: Mínimo 2 caracteres para el parámetro `q`
4. **Relaciones**: Los suppliers deben existir antes de asociarlos
5. **Estados**: `is_active` acepta `true`/`false` o `1`/`0`