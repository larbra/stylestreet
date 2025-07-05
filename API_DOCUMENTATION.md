# API Documentation - Sneaker E-commerce Platform

## Table of Contents
1. [Overview](#overview)
2. [Authentication](#authentication)
3. [Models](#models)
4. [Controllers & APIs](#controllers--apis)
5. [Routes](#routes)
6. [Frontend Components](#frontend-components)
7. [Usage Examples](#usage-examples)

## Overview

This is a Laravel-based e-commerce platform specifically designed for selling branded sneakers. The application provides user authentication, product catalog management, shopping cart functionality, and administrative controls.

### Key Features
- User registration and authentication
- Product catalog with categories and colors
- Shopping cart management
- Administrative panel for product/category management
- Multiple product images support
- User profile management

---

## Authentication

### Authentication System
The application uses Laravel's built-in authentication system with custom controllers.

#### Middleware
- `auth`: Requires user authentication
- `admin`: Requires administrative privileges

---

## Models

### User Model
**File**: `app/Models/User.php`

#### Attributes
- `name` (string, fillable): User's full name
- `email` (string, fillable, unique): User's email address
- `password` (string, fillable, hashed): User's password
- `email_verified_at` (datetime, cast): Email verification timestamp
- `remember_token` (string, hidden): Remember token for "remember me" functionality

#### Relationships
```php
// Has many cart items
public function cartItems()
{
    return $this->hasMany(CartItem::class);
}
```

#### Usage Example
```php
// Create a new user
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => bcrypt('password123')
]);

// Get user's cart items
$cartItems = $user->cartItems()->with('tovar')->get();
```

---

### Tovar Model (Product)
**File**: `app/Models/Tovar.php`

#### Attributes
- `name` (string, fillable): Product name
- `price` (decimal, fillable): Product price
- `description` (text, fillable): Product description
- `category` (string, fillable): Product category
- `image` (string, fillable): Main product image filename

#### Relationships
```php
// Has many additional images
public function images()
{
    return $this->hasMany(ProductImage::class, 'product_id');
}

// Belongs to many colors (many-to-many)
public function colors()
{
    return $this->belongsToMany(Color::class);
}
```

#### Usage Example
```php
// Create a new product
$product = Tovar::create([
    'name' => 'Nike Air Jordan 1',
    'price' => 199.99,
    'description' => 'Classic basketball sneaker',
    'category' => 'Basketball',
    'image' => 'jordan1.jpg'
]);

// Get product with images and colors
$product = Tovar::with(['images', 'colors'])->find(1);
```

---

### CartItem Model
**File**: `app/Models/CartItem.php`

#### Attributes
- `user_id` (integer, fillable): Foreign key to users table
- `tovar_id` (integer, fillable): Foreign key to tovars table  
- `quantity` (integer, fillable): Quantity of items

#### Relationships
```php
// Belongs to user
public function user()
{
    return $this->belongsTo(User::class);
}

// Belongs to product (tovar)
public function tovar()
{
    return $this->belongsTo(Tovar::class);
}
```

#### Usage Example
```php
// Add item to cart
$cartItem = CartItem::create([
    'user_id' => 1,
    'tovar_id' => 5,
    'quantity' => 2
]);

// Get cart item with product details
$cartItem = CartItem::with('tovar')->find(1);
```

---

### Category Model
**File**: `app/Models/Category.php`

#### Attributes
- `name` (string, fillable): Category name

#### Usage Example
```php
// Create a new category
$category = Category::create([
    'name' => 'Running Shoes'
]);

// Get all categories
$categories = Category::all();
```

---

### Color Model
**File**: `app/Models/Color.php`

#### Attributes
- `name` (string, fillable): Color name
- `code` (string, fillable): Color hex code

#### Relationships
```php
// Belongs to many products (many-to-many)
public function tovars()
{
    return $this->belongsToMany(Tovar::class);
}
```

#### Usage Example
```php
// Create a new color
$color = Color::create([
    'name' => 'Red',
    'code' => '#FF0000'
]);

// Get color with associated products
$color = Color::with('tovars')->find(1);
```

---

### ProductImage Model
**File**: `app/Models/ProductImage.php`

#### Attributes
- `product_id` (integer, fillable): Foreign key to tovars table
- `image_path` (string, fillable): Image filename

#### Relationships
```php
// Belongs to product
public function product()
{
    return $this->belongsTo(Tovar::class, 'product_id');
}
```

#### Usage Example
```php
// Add additional image to product
$productImage = ProductImage::create([
    'product_id' => 1,
    'image_path' => 'jordan1_side.jpg'
]);
```

---

## Controllers & APIs

### UserController
**File**: `app/Http/Controllers/UserController.php`

#### Public Methods

##### `showLogin()`
**Purpose**: Display login form
**Route**: `GET /login`
**Returns**: `users.login` view

##### `showRegister()`
**Purpose**: Display registration form
**Route**: `GET /register`
**Returns**: `users.register` view

##### `register(Request $request)`
**Purpose**: Handle user registration
**Route**: `POST /register`
**Validation**:
- `name`: required, minimum 3 characters
- `email`: required, valid email, minimum 3 characters, unique
- `password`: required, minimum 3 characters, confirmed

**Example Request**:
```php
POST /register
{
    "name": "John Doe",
    "email": "john@example.com", 
    "password": "password123",
    "password_confirmation": "password123"
}
```

##### `login(Request $request)`
**Purpose**: Handle user login
**Route**: `POST /login`
**Validation**:
- `email`: required, valid email, minimum 3 characters
- `password`: required, minimum 3 characters

**Example Request**:
```php
POST /login
{
    "email": "john@example.com",
    "password": "password123"
}
```

##### `logout(Request $request)`
**Purpose**: Handle user logout
**Route**: `GET /logout`
**Authentication**: Required

##### `profile($id)`
**Purpose**: Display user profile
**Route**: `GET /profile/{id}`
**Authentication**: Required
**Authorization**: Users can only view their own profile

---

### CartController
**File**: `app/Http/Controllers/CartController.php`

#### Public Methods

##### `add(Request $request, Tovar $product)`
**Purpose**: Add product to cart
**Route**: `POST /cart/add/{product}`
**Authentication**: Required
**Parameters**:
- `quantity` (optional): Number of items to add (default: 1)

**Example Request**:
```php
POST /cart/add/5
{
    "quantity": 2
}
```

##### `remove(CartItem $item)`
**Purpose**: Remove item from cart
**Route**: `DELETE /cart/remove/{item}`
**Authentication**: Required

##### `index()`
**Purpose**: Display cart contents
**Route**: `GET /cart`
**Authentication**: Required
**Returns**: Cart items with total price calculation

##### `update(Request $request, CartItem $cartItem)`
**Purpose**: Update cart item quantity
**Route**: `PUT /cart/update/{cartItem}`
**Authentication**: Required
**Validation**:
- `quantity`: required, integer, minimum 1

**Example Request**:
```php
PUT /cart/update/3
{
    "quantity": 5
}
```

**Response**:
```json
{
    "success": true,
    "cart_total": 599.97
}
```

---

### TovarController
**File**: `app/Http/Controllers/TovarController.php`

#### Public Methods

##### `catalog()`
**Purpose**: Display product catalog
**Route**: `GET /catalog`
**Returns**: All products and categories

##### `showTovar($id)`
**Purpose**: Display single product details
**Route**: `GET /tovar/{id}`
**Returns**: Product with images

##### `admin()`
**Purpose**: Display admin panel
**Route**: `GET /admin`
**Authentication**: Required (admin middleware)
**Returns**: All products and categories for management

##### `createTovar(Request $request)`
**Purpose**: Create new product
**Route**: `POST /create/tovar`
**Authentication**: Required (admin middleware)
**Validation**:
- `name`: required, 3-255 characters
- `price`: required, numeric, minimum 1
- `description`: required, minimum 10 characters
- `category`: required
- `main_image`: required, image file, max 2MB
- `images.*`: optional additional images, max 2MB each
- `colors`: optional array of color IDs

**Example Request**:
```php
POST /create/tovar
Content-Type: multipart/form-data

{
    "name": "Nike Air Max 90",
    "price": 149.99,
    "description": "Classic running shoe with Air Max technology",
    "category": "Running",
    "main_image": [image file],
    "images": [additional image files],
    "colors": [1, 2, 3]
}
```

##### `updateTovar(Request $request, $id)`
**Purpose**: Update existing product
**Route**: `POST /tovar/update/{id}`
**Authentication**: Required (admin middleware)

##### `deleteTovar(Request $request, $id)`
**Purpose**: Delete product
**Route**: `POST /tovar/delete/{id}`
**Authentication**: Required (admin middleware)

##### `createCategory(Request $request)`
**Purpose**: Create new category
**Route**: `POST /create/category`
**Authentication**: Required (admin middleware)
**Validation**:
- `name`: required, minimum 3 characters

##### `updateCategory(Request $request, $id)`
**Purpose**: Update category
**Route**: `POST /category/update/{id}`
**Authentication**: Required (admin middleware)

##### `deleteCategory(Request $request, $id)`
**Purpose**: Delete category
**Route**: `POST /category/delete/{id}`
**Authentication**: Required (admin middleware)

---

### HomeController
**File**: `app/Http/Controllers/HomeController.php`

#### Public Methods

##### `index()`
**Purpose**: Display home page
**Route**: `GET /`
**Returns**: Welcome page with 3 latest products

**Example Usage**:
```php
// Get latest products for homepage
$latestProducts = Tovar::orderBy('created_at', 'desc')->take(3)->get();
```

---

## Routes

### Web Routes
**File**: `routes/web.php`

#### Public Routes
- `GET /` - Home page
- `GET /delivery` - Delivery information page
- `GET /about` - About page
- `GET /orderuniqe` - Order unique page
- `GET /catalog` - Product catalog
- `GET /tovar/{id}` - Product details
- `GET /login` - Login form
- `GET /register` - Registration form
- `POST /login` - Handle login
- `POST /register` - Handle registration

#### Authenticated Routes
- `GET /logout` - Logout
- `GET /profile/{id}` - User profile
- `GET /cart` - Shopping cart
- `POST /cart/add/{product}` - Add to cart
- `DELETE /cart/remove/{item}` - Remove from cart
- `PUT /cart/update/{cartItem}` - Update cart item

#### Admin Routes
- `GET /admin` - Admin panel
- `GET /create/tovar` - Create product form
- `POST /create/tovar` - Handle product creation
- `GET /create/category` - Create category form
- `POST /create/category` - Handle category creation
- `GET /tovar/update/{id}` - Update product form
- `POST /tovar/update/{id}` - Handle product update
- `GET /tovar/delete/{id}` - Delete product form
- `POST /tovar/delete/{id}` - Handle product deletion
- `GET /category/update/{id}` - Update category form
- `POST /category/update/{id}` - Handle category update
- `GET /category/delete/{id}` - Delete category form
- `POST /category/delete/{id}` - Handle category deletion

### API Routes
**File**: `routes/api.php`

#### Authenticated API Routes
- `GET /api/user` - Get authenticated user details (requires Sanctum authentication)

---

## Frontend Components

### Views Structure

#### User Authentication Views
- `resources/views/users/login.blade.php` - Login form
- `resources/views/users/register.blade.php` - Registration form  
- `resources/views/users/profile.blade.php` - User profile page

#### Product Views
- `resources/views/pages/catalog.blade.php` - Product catalog page
- `resources/views/pages/tovar.blade.php` - Individual product page
- `resources/views/pages/cart.blade.php` - Shopping cart page

#### Admin Views
- `resources/views/pages/admin.blade.php` - Admin dashboard
- `resources/views/pages/create.blade.php` - Create product form
- `resources/views/pages/update.blade.php` - Update product form
- `resources/views/pages/delete.blade.php` - Delete product confirmation
- `resources/views/pages/addcatagory.blade.php` - Create category form
- `resources/views/pages/updatecategory.blade.php` - Update category form
- `resources/views/pages/deletecategory.blade.php` - Delete category confirmation

#### Static Pages
- `resources/views/welcome.blade.php` - Home page
- `resources/views/pages/delivery.blade.php` - Delivery information
- `resources/views/pages/about.blade.php` - About page
- `resources/views/pages/orderuniqe.blade.php` - Order unique page

---

## Usage Examples

### Complete User Registration Flow
```php
// 1. Display registration form
Route::get('/register', [UserController::class, 'showRegister']);

// 2. Handle registration submission
Route::post('/register', [UserController::class, 'register']);

// 3. User data validation and creation
$user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => bcrypt($request->password)
]);
```

### Shopping Cart Management
```php
// 1. Add product to cart
$cartItem = CartItem::firstOrNew([
    'user_id' => auth()->id(),
    'tovar_id' => $product->id
]);
$cartItem->quantity += $request->quantity;
$cartItem->save();

// 2. Calculate cart total
$total = $user->cartItems()->with('tovar')->get()->sum(function ($item) {
    return $item->tovar->price * $item->quantity;
});

// 3. Update cart item quantity
$cartItem->update(['quantity' => $request->quantity]);
```

### Product Management (Admin)
```php
// 1. Create product with images
$tovar = Tovar::create([
    'name' => $request->name,
    'price' => $request->price,
    'description' => $request->description,
    'category' => $request->category,
    'image' => $mainImageName
]);

// 2. Add additional images
foreach ($request->file('images') as $image) {
    ProductImage::create([
        'product_id' => $tovar->id,
        'image_path' => $imageName
    ]);
}

// 3. Associate colors
$tovar->colors()->sync($request->colors);
```

### Product Catalog Display
```php
// 1. Get all products and categories
$tovars = Tovar::all();
$categories = Category::all();

// 2. Get product with relationships
$tovar = Tovar::with('images')->findOrFail($id);

// 3. Display latest products on homepage
$latestProducts = Tovar::orderBy('created_at', 'desc')->take(3)->get();
```

---

## Error Handling

### Validation Error Messages
The application includes Russian language validation messages:

#### User Registration Errors
- `name.required` - "Поле "Имя" обязательно для заполнения"
- `email.unique` - "Этот email уже зарегистрирован"
- `password.confirmed` - "Пароли не совпадают"

#### Product Creation Errors
- `name.required` - "Поле "Название товара" обязательно для заполнения"
- `price.numeric` - "Цена должна быть числом"
- `main_image.required` - "Основное изображение обязательно для загрузки"

### Authorization
- Cart items can only be accessed by their owners
- Admin routes require admin middleware
- Profile pages can only be viewed by the profile owner

---

## File Storage

### Image Storage
- Product images are stored in `storage/app/public/products/`
- Images are accessible via `storage/products/` URL
- Supported formats: jpeg, png, jpg, gif, svg, webp
- Maximum file size: 2MB per image

### Image Naming Convention
- Main images: `{timestamp}_main.{extension}`
- Additional images: `{timestamp}_{original_name}`

---

## Security Features

1. **CSRF Protection**: All forms include CSRF tokens
2. **Password Hashing**: Passwords are hashed using bcrypt
3. **Input Validation**: All user inputs are validated
4. **File Upload Security**: Image uploads are validated for type and size
5. **Authentication Middleware**: Protected routes require authentication
6. **Authorization**: Users can only access their own data

---

## Database Relationships Summary

```
Users (1) ←→ (∞) CartItems (∞) ←→ (1) Tovars
                                     ↓
Tovars (1) ←→ (∞) ProductImages      (∞) ←→ (∞) Colors
       ↓
    Categories
```

This documentation provides a comprehensive overview of all public APIs, functions, and components in the sneaker e-commerce platform. Each section includes practical examples and usage instructions to help developers understand and work with the codebase effectively.