<?php include 'app/views/shares/header.php'; ?>

<h1>Chi tiết sản phẩm</h1>

<div class="card">
    <div class="card-header">
        <h2><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h2>
    </div>
    <div class="card-body">
        <p><strong>Mô tả:</strong></p>
        <p><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
        
        <p><strong>Giá:</strong> 
            <span class="badge badge-success"><?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ</span>
        </p>
        
        <?php if (isset($product->category_id)): ?>
        <p><strong>Mã danh mục:</strong> <?php echo htmlspecialchars($product->category_id, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        
        <div class="mt-3">
            <a href="/webbanhang/product/edit/<?php echo $product->id; ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Sửa sản phẩm
            </a>
            <a href="/webbanhang/product/delete/<?php echo $product->id; ?>" 
               class="btn btn-danger" 
               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                <i class="fas fa-trash"></i> Xóa sản phẩm
            </a>
            <a href="/webbanhang/product" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách
            </a>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>