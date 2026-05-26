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
        <a href="/products/create" class="btn btn-primary shadow-sm">+ Add Product</a>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="fw-bold">{{ $product->name }}</td>
                        <td class="text-muted">{{ $product->description ?? 'No description added' }}</td>
                        <td class="text-success fw-bold">₹{{ $product->price }}</td>
                        <td>
                            <a href="/products/{{ $product->hashed_id }}" class="btn btn-sm btn-info text-white shadow-sm">
                                View
                            </a>
                            <a href="/products/{{ $product->hashed_id }}/edit" class="btn btn-sm btn-warning shadow-sm">
                                Edit
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