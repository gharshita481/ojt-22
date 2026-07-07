<?php
// Database connection
$host = "localhost"; // Change if needed
$user = "root"; // Change if needed
$pass = ""; // Change if needed
$db = "bellelise"; // Change if needed

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch age distribution data
$sql = "
    SELECT 
        CASE 
            WHEN TIMESTAMPDIFF(YEAR, user_dob, CURDATE()) BETWEEN 10 AND 19 THEN '10-19'
            WHEN TIMESTAMPDIFF(YEAR, user_dob, CURDATE()) BETWEEN 20 AND 29 THEN '20-29'
            WHEN TIMESTAMPDIFF(YEAR, user_dob, CURDATE()) BETWEEN 30 AND 39 THEN '30-39'
            WHEN TIMESTAMPDIFF(YEAR, user_dob, CURDATE()) BETWEEN 40 AND 49 THEN '40-49'
            ELSE '50+' 
        END AS age_group,
        COUNT(*) AS count
    FROM users
    GROUP BY age_group
    ORDER BY age_group;
";

$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[$row['age_group']] = $row['count'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Age Distribution</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .chart-container {
            width: 50%;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            margin-bottom: 10px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="chart-container">
        <h2>Users Age Distribution</h2>
        <canvas id="ageChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('ageChart').getContext('2d');
        const ageData = {
            labels: <?php echo json_encode(array_keys($data)); ?>,
            datasets: [{
                label: 'Number of Users',
                data: <?php echo json_encode(array_values($data)); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        new Chart(ctx, {
            type: 'bar',
            data: ageData,
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
</body>
</html>