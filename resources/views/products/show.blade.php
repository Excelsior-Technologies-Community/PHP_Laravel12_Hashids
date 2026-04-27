<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">📄 Product Details</h4>
                </div>

                <div class="card-body">
                    <h5 class="mb-3">Name: <span class="text-primary">{{ $product->name }}</span></h5>

                    <h5 class="mb-4">Price: <span class="text-success">₹{{ $product->price }}</span></h5>

                    <a href="/products" class="btn btn-secondary w-100">
                        ← Back to Products
                    </a>
                </div>

            </div>

        </div>
    </div>

</div>

</body>
</html>