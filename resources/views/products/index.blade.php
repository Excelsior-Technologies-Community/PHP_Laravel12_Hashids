<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📦 Product List</h2>
        <a href="/products/create" class="btn btn-primary">+ Add Product</a>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>₹{{ $product->price }}</td>
                        <td>
                            <a href="/products/{{ $product->hashid }}" class="btn btn-sm btn-info text-white">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

</body>
</html>