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
                    
                    <h5 class="mb-3">Description: <span class="text-secondary fw-normal">{{ $product->description ?? 'No description added' }}</span></h5>

                    <h5 class="mb-4">Price: <span class="text-success">₹{{ $product->price }}</span></h5>

                    <div class="mt-4 mb-4 p-3 bg-light border rounded">
                        <label class="form-label text-muted fw-bold small">🔗 Secure Shareable Link:</label>
                        <div class="input-group">
                            <input type="text" id="shareLink" class="form-control" value="{{ url('/products/' . $product->hashed_id) }}" readonly>
                            <button class="btn btn-primary" type="button" onclick="copyLink()">Copy</button>
                        </div>
                        <div id="copyMsg" class="text-success small mt-2 d-none">✅ Link copied to clipboard!</div>
                    </div>

                    <a href="/products" class="btn btn-secondary w-100">
                        ← Back to Products
                    </a>
                </div>

            </div>

        </div>
    </div>

</div>

<script>
    function copyLink() {
        var copyText = document.getElementById("shareLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        
        var msg = document.getElementById("copyMsg");
        msg.classList.remove("d-none");
        setTimeout(() => {
            msg.classList.add("d-none");
        }, 2000);
    }
</script>

</body>
</html>