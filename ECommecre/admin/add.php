<?php

include('../template/nav.php');
include('../database.php');
include('../functions.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $price = $_POST['price'] ?? '';
    $category_id = $_POST['category'] ?? '';

    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';

    if (isset($_FILES['image'])) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($image_tmp, "../images/$image");
    }

    $query = "INSERT INTO products (name, price, description, image, created_at, category_id)
              VALUES ('$name', '$price', '$description', '$image', NOW(), '$category_id')";

    $result = mysqli_query($connection, $query);

    if ($result) {
        echo '<div class="alert alert-success">The product has been saved successfully!</div>';
        header('Location: add.php');

    }
    else {
        echo '<div class="alert alert-danger">Error: Failed to save the product.</div>';
   
    }

}
?>

<main class="container">
    <div class="row mb-2">
        <div class="col-7 p-4">
            <a href="products.php" class="btn btn-primary">Show Products</a>

            <h4 class="title p-3">Add New Product</h4>
            <hr>

            <form method="post" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" required id="name" name="name" aria-describedby="Name">
                </div>
               
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">Select Category</option>
                        
                        <?php 
                        $categories=getAllCategories();                        
                        while ($category = mysqli_fetch_assoc($categories)) : ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
           
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" required class="form-control" id="price" name="price" aria-describedby="price">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="image">Image Of Product</label>
                    <input type="file" id="image" required name="image" class="form-control">
                </div>
                <div class="mb-3">
                    
                <label class="form-label" for="description">Description
                        
                    </label>
                    <textarea id="description" rows="4" required name="description" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="Add">Add</button>
            </form>
        </div>
    </div>
</main>

<?php
include('../template/footer.php');
?>