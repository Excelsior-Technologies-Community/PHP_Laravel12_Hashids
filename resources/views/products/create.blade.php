<!DOCTYPE html>
<html>
<head>
    <title>Create Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">➕ Add Product</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="/products">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" placeholder="Enter price" required>
                        </div>

                        <button class="btn btn-success w-100">Save Product</button>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="/products" class="btn btn-link">← Back to Products</a>
            </div>

        </div>
    </div>
</div>

</body>
</html>