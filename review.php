<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "bellelise"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle form submission (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['user_name']) && !empty($_POST['review'])) {
        $name = $conn->real_escape_string($_POST['user_name']);
        $review = $conn->real_escape_string($_POST['review']);

        // Insert into database
        $sql = "INSERT INTO review (user_name, review, created_at) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $review);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Review added successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color:red;'>Please fill out all fields.</p>";
    }
}

// Fetch reviews
$sql = "SELECT user_name, review, created_at FROM review ORDER BY created_at DESC";
$result = $conn->query($sql);

$reviews = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews | Bellelise & Co.</title>
    <link rel="icon" href="images/icon2.png">
</head>
<body>
<style>
    @import url("style.css");
    body {
        background-color: #f4f4f4;
        margin: auto 0;
        padding: 20px;
        overflow: hidden;

    }

    .container {
        max-width: 900px;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
    }

    /* Flexbox layout for form and reviews */
    .content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .review-form {
        flex: 1;
        background: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    #reviews {
        flex: 1;
        background: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-height: 400px;
        overflow-y: auto;
    }

    .review-form form {
        display: flex;
        flex-direction: column;
    }

    input, textarea {
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 95%;
    }

    button {
        padding: 10px;
        background: rgb(161, 124, 90);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background: rgb(94, 57, 22);
    }

    .review {
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 10px;
        border-radius: 5px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .content {
            flex-direction: column;
        }
        .review-form, #reviews {
            width: 100%;
        }
    }
</style>

<div class="container">
    <h1>Customer Reviews</h1>
    <div class="content">
        <!-- Review Form -->
        <div class="review-form">
            <form method="POST" action="">
                <input type="text" name="user_name" placeholder="Your Name" required>
                <textarea name="review" placeholder="Your Review" required></textarea>
                <button type="submit">Submit Review</button>
            </form>
        </div>

        <!-- Reviews Section -->
        <div id="reviews">
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <strong><?php echo htmlspecialchars($review['user_name']); ?></strong>
                    <p><?php echo htmlspecialchars($review['review']); ?></p>
                    <small><?php echo htmlspecialchars($review['created_at']); ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>
