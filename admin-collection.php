<?php
// Include the database connection
include("connection.php");

// Add Product
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $f_category = $_POST['f_category'];
    $price = $_POST['price'];

    // Image upload
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO product (name, description, category, f_category,price,  image) VALUES ('$name', '$description', '$category','$f_category','$price', '$target')";
        if ($conn->query($sql)) {
            echo "<script>alert('Product Added Successfully');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Failed to upload image');</script>";
    }
    echo ' <meta http-equiv="refresh" content="0;url=product.php">';
    exit();
}

// Update Product
if (isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $f_category = $_POST['f_category'];
    $price = $_POST['price'];

    // Image upload
    $image = $_FILES['image']['name'];
    if (!empty($image)) {
        $target = "uploads/" . basename($image);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $sql = "UPDATE product SET name='$name', description='$description', category='$category', f_category='$f_category', price='$price', image='$target' WHERE id='$id'";
        }
    } else {
        $sql = "UPDATE product SET name='$name', description='$description',category='$category',f_category='$f_category', price='$price' WHERE id='$id'";
    }

    if ($conn->query($sql)) {
        echo "<script>alert('Product Updated Successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    echo ' <meta http-equiv="refresh" content="0;url=product.php">';
    exit();
}

// Delete Product
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM product WHERE id='$id'";
    if ($conn->query($sql)) {
        // Reset IDs
        $resetSql = "SET @count = 0;
                     UPDATE product SET id = @count := @count + 1;
                     ALTER TABLE product AUTO_INCREMENT = 1;";
        if ($conn->multi_query($resetSql)) {
            do {
                // Consume all results
            } while ($conn->next_result());
        }
        echo "<script>alert('Product Deleted Successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    echo ' <meta http-equiv="refresh" content="0;url=product.php">';
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color:rgb(136, 117, 91);
            color: #fff;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        button {
            padding: 10px 15px;
            background:rgb(138, 96, 56);
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background:rgb(94, 57, 22);
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .modal-content input, .modal-content textarea {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .modal-content button {
            background:rgb(167, 108, 53);
        }
        .modal-content button:hover {
            background:rgb(179, 72, 0);
        }
    </style>
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['category']}</td>
                            <td>{$row['f_category']}</td>
                            <td>{$row['price']}</td>
                            <td><img src='{$row['image']}' alt='Image' style='width: 50px;'></td>
                            <td>
                                <button onclick=\"editProduct({$row['id']}, '{$row['name']}', '{$row['description']}', '{$row['category']}','{$row['f_category']}','{$row['price']}', '{$row['image']}')\">Edit</button>
                                <button onclick=\"window.location.href='?delete_id={$row['id']}'\">Delete</button>
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
            <input type="text" name="name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <select name="category" required>
                <option value="" disabled selected>Select Category</option>
                <option value="Necklace">Necklace</option>
                <option value="Earrings">Earrings</option>
                <option value="Bracelet">Bracelet</option>
                <option value="Ring">Ring</option>
                <option value="Anklet">Anklet</option>
            </select>
            <select name="f_category" required>
                <option value="" disabled selected>Select Category</option>
                <option value="Titanic">Titanic</option>
                <option value="Bridgerton">Bridgerton</option>
                <option value="Rapunzel">Rapunzel</option>
            </select>

            <input type="number" name="price" placeholder="Price" step="0.01" required>
            <input type="file" name="image" accept="image/*" required>
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
            <input type="hidden" name="id" id="edit_id">
            <h3>Edit Product</h3>
            <input type="text" name="name" id="edit_name" placeholder="Product Name" required>
            <textarea name="description" id="edit_description" placeholder="Description" required></textarea>
            <input type="text" name="category" id="edit_category" placeholder="Category Name" required>
            <input type="number" name="price" id="edit_price" placeholder="Price" step="0.01" required>
            <input type="file" name="image" accept="image/*">
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
