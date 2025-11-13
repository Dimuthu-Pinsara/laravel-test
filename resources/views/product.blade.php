<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Product Inventory</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                <a class="navbar-brand" href="#">Product Inventory</a>
            </div>
        </nav>
    </div>
    <div class="container mx-auto mt-5">
        <div class="bg-white">
            <h1 class="text-center">Product Inventory</h1>
            <form id="product-form" class="mt-4">
                @csrf
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
            <table class="table table-bordered overflow-x-auto d-block overflow-sm-hidden">
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
                <tbody id="product-table">
                    @include('partials.product-rows', ['products' => $products])
                </tbody>
            </table>
        </div>
    </div>

    {{-- product edit modal --}}
    <div class="modal" id="product-edit-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edit-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-index">
                        <div class="mb-3">
                            <label>Product Name</label>
                            <input type="text" id="edit-name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Quantity</label>
                            <input type="number" id="edit-quantity" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Price</label>
                            <input type="number" step="0.01" id="edit-price" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {

        addProduct();
        closeModal();
        editModalOpen();
        editProduct();

    });

    function closeModal(){
        $('#product-edit-modal').removeClass("show").hide();
    }

    function editModalOpen(){
        $(document).on('click', '.edit-btn', function() {
            const index = $(this).data('index');
            const row = $(`tr[data-index="${index}"]`);

            $('#edit-index').val(index);
            $('#edit-name').val(row.find('td:eq(0)').text());
            $('#edit-quantity').val(row.find('td:eq(1)').text());
            $('#edit-price').val(row.find('td:eq(2)').text());

            $('#product-edit-modal').show();
        });
    }

    function editProduct(){
        $('#edit-form').submit(function(e) {
            e.preventDefault();

            const index = $('#edit-index').val();
            const updatedData = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                index: index,
                product_name: $('#edit-name').val(),
                quantity: $('#edit-quantity').val(),
                price: $('#edit-price').val(),
            };

            $.post('/update', updatedData, function(response) {

                $('#product-edit-modal').removeClass("show").hide();
                $('#product-table').html(response.html);
                window.location.reload();

            }).fail(function(xhr) {
                console.error('Failed to update product: ' + xhr.responseText);
            });
        });
    }


    function addProduct() {
        $('#product-form').submit(function(e) {

            e.preventDefault();

            $.post('/save', $(this).serialize(), function(data) {
                $('#product-table').html(data.html);
            });

            window.location.reload();
        });

    }
</script>

</html>
