<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif
</head>

<body class="bg-white p-4">
    <div class="container">
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
            </div>
        </nav>
    </div>
    <div class="container mx-auto mt-5">
        <div class="bg-white">
            <h1 class="text-center">Product Inventory</h1>
            <form id="product-form" class="mt-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="product_name" class="form-control" placeholder="Product name"
                            required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="quantity" class="form-control" placeholder="Quantity in stock"
                            required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" name="price" class="form-control"
                            placeholder="Price per item" required>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">Add</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bg-white mt-5">
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Datetime</th>
                        <th>Total Value</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id="productTable">
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
