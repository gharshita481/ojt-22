<?php
// Include the database connection
include("connection.php");


// Add Product
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_type = $_POST['product_type'];
    $f_category = $_POST['f_category'];
    $product_price = $_POST['product_price'];

    // Handle image upload
    $product_image = $_FILES['product_image']['name'];
    $image2 = $_FILES['image2']['name'];

    $target1 = "uploads/" . basename($product_image);
    $target2 = "uploads/" . basename($image2);

    // Move uploaded files
    if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target1) && move_uploaded_file($_FILES['image2']['tmp_name'], $target2)) {
        // Insert product into the database
        $sql = "INSERT INTO product (product_name, product_description, product_type, f_category, product_price, product_image, image2) 
                VALUES ('$product_name', '$product_description', '$product_type', '$f_category', '$product_price', '$target1', '$target2')";

        if ($conn->query($sql)) {
            echo "<script>alert('Product Added Successfully'); window.location.href='admin-product.php';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Failed to upload images.');</script>";
    }
}



// Update Product
if (isset($_POST['edit_product'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_type = $_POST['product_type'];
    $f_category = $_POST['f_category'];
    $product_price = $_POST['product_price'];

    $update_query = "UPDATE product SET 
                        product_name='$product_name', 
                        product_description='$product_description', 
                        product_type='$product_type', 
                        f_category='$f_category', 
                        product_price='$product_price'";

    // Handle optional image uploads
    if (!empty($_FILES['product_image']['name'])) {
        $target1 = "uploads/" . basename($_FILES['product_image']['name']);
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target1)) {
            $update_query .= ", product_image='$target1'";
        }
    }

    if (!empty($_FILES['image2']['name'])) {
        $target2 = "uploads/" . basename($_FILES['image2']['name']);
        if (move_uploaded_file($_FILES['image2']['tmp_name'], $target2)) {
            $update_query .= ", image2='$target2'";
        }
    }

    $update_query .= " WHERE product_id='$product_id'";

    if ($conn->query($update_query)) {
        echo "<script>alert('Product Updated Successfully'); window.location.href='admin-product.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Delete Product
if (isset($_GET['delete_id'])) {
    $product_id = $_GET['delete_id'];
    $sql = "DELETE FROM product WHERE product_id='$product_id'";
    if ($conn->query($sql)) {
        echo "<script>alert('Product Deleted Successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    echo '<meta http-equiv="refresh" content="0;url=admin-product.php">';
    exit();
}

// Fetch Products
$sql = "SELECT * FROM product";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.2/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin-add-product.css">
    
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Product Collection</h2>
            <button onclick="showModal('addProductModal')">Add Product</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Feature</th>
                    <th>Price</th>                    
                    <th>Image</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['product_id']}</td>
                            <td>{$row['product_name']}</td>
                            <td>{$row['product_description']}</td>
                            <td>{$row['product_type']}</td>
                            <td>{$row['f_category']}</td>
                            <td>{$row['product_price']}</td>
                            <td><img src='{$row['product_image']}' alt='Image' style='width: 50px;'></td>
                            <td><img src='{$row['image2']}' alt='Image' style='width: 50px;'></td>
                            <td>
                                <button onclick=\"editProduct({$row['product_id']}, '{$row['product_name']}', '{$row['product_description']}', '{$row['product_type']}','{$row['f_category']}','{$row['product_price']}', '{$row['product_image']}','{$row['image2']}')\">Edit</button>
                                <button onclick=\"window.location.href='?delete_id={$row['product_id']}'\">Delete</button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

 <!-- Add Product Modal -->
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <form method="POST" enctype="multipart/form-data">
            <h3>Add Product</h3>
            <input type="text" name="product_name" placeholder="Product Name" required>
            <textarea name="product_description" placeholder="Description" required></textarea>
            <select name="product_type" required>
                <option value="" disabled selected>Select Category</option>
                <option value="Necklace">Necklace</option>
                <option value="Earrings">Earrings</option>
                <option value="Bracelet">Bracelet</option>
                <option value="Ring">Ring</option>
                <option value="Anklet">Anklet</option>
            </select>
            <select name="f_category">
                <option value="" disabled selected>Select Category</option>
                <option value="Titanic">Titanic</option>
                <option value="Bridgerton">Bridgerton</option>
                <option value="Rapunzel">Rapunzel</option>
            </select>

            <input type="number" name="product_price" placeholder="Price" step="0.01" required>
            <input type="file" name="product_image" accept="image/*" required>
            <input type="file" name="image2" accept="image/*" required>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="submit" name="add_product" style="background: rgb(167, 108, 53); color: #fff; border: none; padding: 10px; border-radius: 4px; cursor: pointer;">
                    Add Product
                </button>
                <button type="button" class="cancel" onclick="closeModal('addProductModal')" style="background: #ccc; color: #000; border: none; padding: 10px; border-radius: 4px; cursor: pointer;">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

   <!-- Edit Product Modal -->
<div id="editProductModal" class="modal">
    <div class="modal-content">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" id="edit_id">
            <h3>Edit Product</h3>
            <input type="text" name="product_name" id="edit_name" placeholder="Product Name" required>
            <textarea name="product_description" id="edit_description" placeholder="Description" required></textarea>
            
            <select name="product_type" id="edit_category"required>
                <option value="" disabled selected>Select Product Type</option>
                <option value="Necklace">Necklace</option>
                <option value="Earrings">Earrings</option>
                <option value="Bracelet">Bracelet</option>
                <option value="Ring">Ring</option>
                <option value="Anklet">Anklet</option>
            </select>
            <select name="f_category" id="edit_category">
                <option value="" disabled selected>Select Featured Category</option>
                <option value="Titanic">Titanic</option>
                <option value="Bridgerton">Bridgerton</option>
                <option value="Rapunzel">Rapunzel</option>
            </select required>
            <input type="number" name="product_price" id="edit_price" placeholder="Price" step="0.01" required>
            <input type="file" name="product_image" accept="image/*">
            <input type="file" name="image2" accept="image/*">
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="submit" name="edit_product" style="background: rgb(167, 108, 53); color: #fff; border: none; padding: 10px; border-radius: 4px; cursor: pointer;">
                    Update Product
                </button>
                <button type="button" class="cancel" onclick="closeModal('editProductModal')" style="background: #ccc; color: #000; border: none; padding: 10px; border-radius: 4px; cursor: pointer;">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

    <script>
        function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
        function showModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
         // Function to populate Edit Product modal and display it
    function editProduct(id, name, description, category, price) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_price').value = price;

        document.getElementById('editProductModal').style.display = 'flex';
    }

    // Function to close the modal
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
    </script>
</body>
</html>