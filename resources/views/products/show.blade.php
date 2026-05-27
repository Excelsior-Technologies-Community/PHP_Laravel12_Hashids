<!DOCTYPE html>
<html>
<head>
    <title>Product Details - {{ $product->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/products">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Product Details
                    </h4>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Product Name</h6>
                            <h5 class="text-primary">{{ $product->name }}</h5>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Category</h6>
                            <h5>
                                @if($product->category)
                                    <span class="badge bg-info">{{ $product->category }}</span>
                                @else
                                    <span class="text-muted">Uncategorized</span>
                                @endif
                            </h5>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="text-muted">Description</h6>
                            <p class="text-secondary">{{ $product->description ?? 'No description added for this product.' }}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <h6 class="text-muted">Price</h6>
                            <h4 class="text-success">{{ $product->formatted_price }}</h4>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted">Stock Availability</h6>
                            @if($product->stock > 0)
                                <h5 class="text-success">
                                    <i class="fas fa-check-circle"></i> {{ $product->stock }} units
                                </h5>
                            @else
                                <h5 class="text-danger">
                                    <i class="fas fa-times-circle"></i> Out of Stock
                                </h5>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted">Status</h6>
                            @if($product->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                    </div>

                    <!-- Secure Shareable Link Section -->
                    <div class="mt-4 mb-4 p-3 bg-light border rounded">
                        <label class="form-label text-muted fw-bold small">
                            <i class="fas fa-link me-1"></i> Secure Shareable Link:
                        </label>
                        <div class="input-group">
                            <input type="text" id="shareLink" class="form-control" 
                                   value="{{ url('/products/' . $product->hashid) }}" readonly>
                            <button class="btn btn-primary" type="button" onclick="copyLink()">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                        <div id="copyMsg" class="text-success small mt-2 d-none">
                            <i class="fas fa-check-circle"></i> Link copied to clipboard!
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <a href="/products" class="btn btn-secondary w-100">
                                <i class="fas fa-arrow-left me-1"></i> Back to Products
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="/products/{{ $product->hashid }}/edit" class="btn btn-warning w-100">
                                <i class="fas fa-edit me-1"></i> Edit Product
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer text-muted">
                    <small>
                        <i class="fas fa-calendar-alt me-1"></i> Created: {{ $product->created_at->format('F d, Y H:i:s') }}
                        @if($product->created_at != $product->updated_at)
                            | <i class="fas fa-edit me-1"></i> Updated: {{ $product->updated_at->format('F d, Y H:i:s') }}
                        @endif
                    </small>
                </div>
            </div>
            
            <!-- Related Products -->
            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="card shadow mt-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Related Products</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($relatedProducts as $related)
                        <div class="col-md-6 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="/products/{{ $related->hashid }}" class="text-decoration-none">
                                    {{ $related->name }}
                                </a>
                                <span class="text-success">{{ $related->formatted_price }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
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