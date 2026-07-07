<?php
include 'connection.php';

// Fetch product category data
$sql = "SELECT product_type, COUNT(*) as count FROM product GROUP BY product_type";
$result = $conn->query($sql);

$categories = [];
$counts = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['product_type'];
    $counts[] = $row['count'];
}

// Convert PHP arrays to JSON for JavaScript
$categories_json = json_encode($categories);
$counts_json = json_encode($counts);
?>

<canvas id="productChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('productChart').getContext('2d');
    var productChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $categories_json; ?>,
            datasets: [{
                label: 'Number of Products',
                data: <?php echo $counts_json; ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>