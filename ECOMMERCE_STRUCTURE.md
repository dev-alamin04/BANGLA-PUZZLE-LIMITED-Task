# E-Commerce Platform - Project Structure Guide

## Overview
This document outlines the complete structure and location of all e-commerce related files and folders in the BANGLA PUZZLE LIMITED project. The e-commerce module implements a full CRUD system for Categories, Subcategories, and Products with a clean admin dashboard interface.

---

## 📁 Project Structure

### 1. **Database Layer**

#### Migrations
Location: `database/migrations/`

| File | Purpose |
|------|---------|
| `2026_06_07_000001_create_categories_table.php` | Creates `categories` table with fields: id, name, slug, description |
| `2026_06_07_000002_create_subcategories_table.php` | Creates `subcategories` table with FK to categories |
| `2026_06_07_000003_create_products_table.php` | Creates `products` table with FK to both categories and subcategories (no image_path) |
| `2026_06_07_000004_create_media_table.php` | Creates polymorphic `media` table for storing multiple images per model |

**Key Fields in Products Table:**
- `id`, `category_id`, `subcategory_id`, `name`, `slug`, `description`, `old_price`, `new_price`, `timestamps`
- ⚠️ `image_path` removed — images are now stored in the `media` table

**Key Fields in Media Table:**
- `id`, `mediable_id`, `mediable_type` (polymorphic), `path`, `collection`, `order`, `timestamps`

---

### 2. **Models**

Location: `app/Models/`

| Model | Relationships | Key Features |
|-------|---|---|
| `Category.php` | `hasMany(Subcategory)`, `hasMany(Product)` | Main category entity |
| `Subcategory.php` | `belongsTo(Category)`, `hasMany(Product)` | Nested under categories |
| `Product.php` | `belongsTo(Category)`, `belongsTo(Subcategory)`, `morphMany(Media)`, `morphOne(Media)` | Multiple images via polymorphic media |
| `Media.php` | `morphTo()` | Polymorphic — reusable across any model |

**Product image relationships:**
- `images()` — all images ordered by `order` column
- `thumbnail()` — first image only (for listings)

---

### 3. **Form Requests**

Location: `app/Http/Requests/`

| File | Purpose |
|------|---------|
| `ProductRequest.php` | Validates product create/update including multiple image files |

**Key Features of ProductRequest:**
- `prepareForValidation()` — auto-generates and injects `slug` before validation
- `generateSlug()` — unique slug generation with collision handling
- `images` field: required on create, nullable on update
- `images.*` validates each file individually as image/mimes/max

---

### 4. **Controllers**

Location: `app/Http/Controllers/Web/Backend/Ecommerce/`

| Controller | Methods | Functionality |
|------------|---------|---|
| `CategoryController.php` | index (AJAX), create, store, edit, update, destroy | Manage product categories |
| `SubcategoryController.php` | index (AJAX), create, store, edit, update, destroy | Manage subcategories within categories |
| `ProductController.php` | index (AJAX), create, store, show, edit, update, destroy, destroyMedia | Full product management with multiple image upload |

**Key Features:**
- AJAX-enabled index methods using Yajra DataTables for server-side rendering
- Form validation via `ProductRequest` (dedicated Form Request class)
- `$request->validated()` used directly for clean model create/update
- Multiple image upload via `uploadProductImages()` private method using `uploadFile()` helper
- **Append strategy** on update: new images are added without deleting existing ones
- `destroyMedia()` — deletes a single image from media table and disk
- Image files cleaned up on product `destroy()` via `deleteFile()` helper

---

### 5. **Routes**

Location: `routes/backend.php`

```php
Route::resource('categories', CategoryController::class);
Route::resource('subcategories', SubcategoryController::class);
Route::resource('products', ProductController::class);
Route::delete('products/media/{media}', [ProductController::class, 'destroyMedia'])->name('products.media.destroy');
```

**Generated Routes (Admin Prefix: `/admin`):**

| Method | Route | Controller Method | Purpose |
|--------|-------|-------------------|---------|
| GET | `/admin/products` | index | List products (AJAX DataTable) |
| GET | `/admin/products/create` | create | Create form |
| POST | `/admin/products` | store | Save product + upload images |
| GET | `/admin/products/{product}` | show | View product details |
| GET | `/admin/products/{product}/edit` | edit | Edit form with existing images |
| PUT/PATCH | `/admin/products/{product}` | update | Update product + append new images |
| DELETE | `/admin/products/{product}` | destroy | Delete product + all images |
| DELETE | `/admin/products/media/{media}` | destroyMedia | Delete a single product image |

---

### 6. **Views (Blade Templates)**

Location: `resources/views/backend/layouts/ecommerce/`

#### Products
```
ecommerce/products/
├── index.blade.php          # DataTable listing
├── create.blade.php         # Add product form with native multi-image input + JS preview
├── edit.blade.php           # Edit form — existing images with delete buttons + add more images
├── show.blade.php           # Product details page showing all images
└── partials/
    └── _productsJS.blade.php    # DataTable init + AJAX delete handler
```

---

### 7. **Frontend Components Used**

Location: `resources/views/components/`

| Component | Usage |
|-----------|-------|
| `breadcrumbs.blade.php` | Navigation breadcrumbs (e.g., Dashboard > Products) |
| `action-buttons.blade.php` | View/Edit/Delete action buttons in tables |

**Modal:**
- Shared `#deletemodal` used for both product delete and individual image delete

---

### 8. **Admin Navigation**

Location: `resources/views/backend/partials/_sidenav.blade.php`

**Added Menu Structure:**
```
Ecommerce (expandable)
├── Categories
├── Subcategories
└── Products
```

---

### 9. **Helper Functions**

Location: `app/Helpers/helper.php`

| Function | Purpose |
|----------|---------|
| `uploadFile($file, $folder, $customName)` | Upload files to public directory, returns relative path |
| `deleteFile($filePath)` | Delete file from public directory |

---

## 🔄 Workflow

### Product Management
```
/admin/products
  ↓ (DataTable AJAX)
  ├── /admin/products/create
  │   ├── Select Category → Subcategory (JS filtered)
  │   ├── Enter: name, description, old_price, new_price
  │   ├── Upload multiple images (native file input)
  │   └── store → slug auto-generated, images saved to media table
  │
  ├── /admin/products/{product} → show (all images displayed)
  │
  ├── /admin/products/{product}/edit
  │   ├── Existing images shown with individual delete (AJAX + modal)
  │   ├── Add more images (appended, existing kept)
  │   └── update → slug regenerated, new images appended to media table
  │
  └── Delete via AJAX → removes product + all media records + image files
```

---

## 📊 Data Relationships

```
Category (1)
  └── Subcategory (Many)
        └── Product (Many)
              └── Media (Many) ← polymorphic, collection: 'images'

Product belongs to:
  ├── Category
  └── Subcategory

Media morphs to:
  └── Product (mediable_type = App\Models\Product)
```

---

## 🔑 Key Technologies

- **Backend Framework:** Laravel 11
- **Database:** MySQL (via migrations)
- **AJAX Tables:** Yajra DataTables (server-side rendering)
- **Frontend:** Blade Templates, Bootstrap 5
- **Image Upload:** Built-in `uploadFile()` helper
- **Multiple Images:** Polymorphic `media` table

---

## 📋 Database Schema

### categories
```sql
id (PK) | name (unique) | slug (unique) | description | created_at | updated_at
```

### subcategories
```sql
id (PK) | category_id (FK) | name | slug | description | created_at | updated_at
```

### products
```sql
id (PK) | category_id (FK) | subcategory_id (FK) | name | slug (unique) |
description | old_price | new_price | created_at | updated_at
```

### media (polymorphic)
```sql
id (PK) | mediable_id | mediable_type | path | collection | order | created_at | updated_at
```

---

## ✨ Special Features

1. **Polymorphic Media Table**
   - Images stored separately from products in a `media` table
   - Reusable for any other model (e.g., Banner, Blog) without schema changes
   - Each product can have unlimited images with ordering support

2. **Multiple Image Upload**
   - Native HTML file input with `multiple` attribute — 100% reliable with Laravel validation
   - JS preview shows selected images before form submission
   - Edit page supports append strategy — new images added without removing old ones
   - Individual image delete via AJAX using shared delete confirmation modal

3. **Clean Form Request**
   - `ProductRequest` handles all validation including per-file image rules
   - Slug auto-generated in `prepareForValidation()` — included in `$validated`
   - Controller uses `$request->validated()` directly for clean `create()`/`update()`

4. **Slug-based Routing for Products**
   - Products use slug for route binding instead of ID
   - Unique slug generation with collision counter in `ProductRequest`

5. **Cascading Image Cleanup**
   - Deleting a product removes all its media records and physical image files
   - Individual image delete removes both the DB record and the file from disk

6. **AJAX DataTables**
   - Server-side rendering for performance
   - Pagination, search, and sorting
   - Delete confirmation modal
   - Auto-reload after operations
