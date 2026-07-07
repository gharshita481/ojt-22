<?php include("connection.php");?>
<?php
    // Check cookie
    if(isset($_COOKIE['token'])){
       // echo "Logged";
        $user_id = $_COOKIE['user_id'];
    }
    else{
        //echo ' <meta http-equiv="refresh" content="0;url=login.php">';
        echo "Please login to use panel";
        exit(0);
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="admin-style.css">
  <link rel="stylesheet" href="admin-add-product.css">
  
</head>
<style>
     .team-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .team-card {
    width: 30%; /* Ensures 3 cards per row */
    min-width: 180px; /* Prevents cards from shrinking too much */
    background: white;
    height: 400px;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border: 2px solid #d38b5d;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
}

.team-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    border: 2px solid #a34523;
}
        .team-card img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .team-card {
            margin: 10px 0;
            font-size: 18px;
        }
        .team-card .role h2{
            color: #555;
            font-style: italic;
        }
        .team-card .contact h4 {
            font-size: 14px;
            color: #777;
        }

</style>
<body>
  <div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <div class="brand">
        <i class="fas fa-gem"></i>
        <span>Bellelise</span>
      </div>
        <div class="user-info"> 
            
            <?php
                // Fetch user details
                $sql = "SELECT * FROM users WHERE user_id=$user_id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $user_name = $row["user_name"];
                    echo '<h1 style="color:#fff;font-size:20px">Hello, '.$user_name.'</h1>';
                }
            }
            ?>
           </div>
     
      <ul class="nav-links">
        <li><a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="admin-product.php"><i class="fas fa-box"></i> Product</a></li>
        <li><a href="admin-order.php" ><i class="fas fa-list"></i> Order List</a></li>
        <li><a href="admin-analytics.php"><i class="fas fa-chart-line"></i> Analytics</a></li>
        <li><a href="#"><i class="fas fa-warehouse"></i> Stock</a></li>    
        <li><a href="admin-team.php" class="active"><i class="fas fa-users"></i> Team</a></li>
        <li><a href="admin-message.php"><i class="fas fa-envelope"></i> Messages</a></li>
        <li><a href="#"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
      </ul>
    </div>
        </div>
        
    <!-- Main Content -->
    <div class="main-content">
      <div class="header">
        <div class="menu-icon" id="menu-icon">
          <i class="fas fa-bars"></i>
        </div>
        <div class="search-bar">
          <input type="text" placeholder="Search...">
          <button><i class="fas fa-search"></i></button>
        </div>
        
      </div>
      <div class="content">
        <h1>Team Management </h1>
            <br>
            <?php

// Add Team Member
if (isset($_POST['add_team'])) {
    $team_name = $_POST['team_name'];
    $team_role = $_POST['team_role'];
    $team_contact = $_POST['team_contact'];
    $team_email = $_POST['team_email'];

    // Handle image upload
    $team_image = $_FILES['team_image']['name'];
    $target = "uploads/" . basename($team_image);

    if (move_uploaded_file($_FILES['team_image']['tmp_name'], $target)) {
        // Insert data into the database
        $sql = "INSERT INTO team (team_name, team_role, team_contact, team_email, team_image) 
                VALUES ('$team_name', '$team_role', '$team_contact', '$team_email', '$target')";

        if ($conn->query($sql)) {
            echo "<script>alert('Team Member Added Successfully'); </script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Failed to upload image.');</script>";
    }
}

// Edit Team Member
if (isset($_POST['edit_team'])) {
    $team_id = $_POST['team_id'];
    $team_name = $_POST['team_name'];
    $team_role = $_POST['team_role'];
    $team_contact = $_POST['team_contact'];
    $team_email = $_POST['team_email'];

    $update_query = "UPDATE team SET 
                        team_name='$team_name', 
                        team_role='$team_role', 
                        team_contact='$team_contact', 
                        team_email='$team_email'";

    // Handle image update (optional)
    if (!empty($_FILES['team_image']['name'])) {
        $team_image = $_FILES['team_image']['name'];
        $target = "uploads/" . basename($team_image);
        if (move_uploaded_file($_FILES['team_image']['tmp_name'], $target)) {
            $update_query .= ", team_image='$target'";
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
        }
    }

    $update_query .= " WHERE team_id='$team_id'";

    if ($conn->query($update_query)) {
        echo "<script>alert('Team Member Updated Successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Delete Team Member
if (isset($_GET['delete_id'])) {
    $team_id = $_GET['delete_id'];
    $sql = "DELETE FROM team WHERE team_id='$team_id'";
    if ($conn->query($sql)) {
        echo "<script>alert('Team Member Deleted Successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    echo '<meta http-equiv="refresh" content="0;url=admin-team.php">';
    exit();
}

// Fetch Team Members
$sql = "SELECT * FROM team";
$result = $conn->query($sql);

if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

    <div class="container">
        <div class="header">
            <h2>Team Members</h2>
            <button onclick="showModal('addTeamModal')">Add Member</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['team_id']}</td>
                            <td>{$row['team_name']}</td>
                            <td>{$row['team_role']}</td>
                            <td>{$row['team_contact']}</td>
                            <td>{$row['team_email']}</td>
                            <td><img src='{$row['team_image']}' alt='Image' style='width: 50px;'></td>
                            <td>
                                <button onclick=\"editTeam({$row['team_id']}, '{$row['team_name']}', '{$row['team_role']}', '{$row['team_contact']}', '{$row['team_email']}', '{$row['team_image']}')\">Edit</button>
                                <button onclick=\"window.location.href='?delete_id={$row['team_id']}'\">Delete</button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No team members found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

<!-- Add Team Member Modal -->
<div id="addTeamModal" class="modal">
    <div class="modal-content">
        <form method="POST" enctype="multipart/form-data">
            <h3>Add Team Member</h3>
            <input type="text" name="team_name" placeholder="Name" required>
            <input type="text" name="team_role" placeholder="Role" required>
            <input type="text" name="team_contact" placeholder="Contact" required>
            <input type="email" name="team_email" placeholder="Email" required>
            <input type="file" name="team_image" accept="image/*" required>
            <button type="submit" name="add_team">Add Member</button>
            <button type="button" class="cancel" onclick="closeModal('addTeamModal')">Cancel</button>
        </form>
    </div>
</div>

<!-- Edit Team Member Modal -->
<div id="editTeamModal" class="modal">
    <div class="modal-content">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="team_id" id="edit_team_id">
            <h3>Edit Team Member</h3>
            <input type="text" name="team_name" id="edit_team_name" placeholder="Name" required>
            <input type="text" name="team_role" id="edit_team_role" placeholder="Role" required>
            <input type="text" name="team_contact" id="edit_team_contact" placeholder="Contact" required>
            <input type="email" name="team_email" id="edit_team_email" placeholder="Email" required>
            <input type="file" name="team_image" accept="image/*">
            <button type="submit" name="edit_team">Update Member</button>
            <button type="button" class="cancel" onclick="closeModal('editTeamModal')">Cancel</button>
        </form>
    </div>
</div>

<script>
    function showModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function editTeam(id, name, role, contact, email, image) {
        document.getElementById('edit_team_id').value = id;
        document.getElementById('edit_team_name').value = name;
        document.getElementById('edit_team_role').value = role;
        document.getElementById('edit_team_contact').value = contact;
        document.getElementById('edit_team_email').value = email;
        document.getElementById('editTeamModal').style.display = 'flex';
    }
</script>
<?php


// Fetch Team Members
$sql = "SELECT * FROM team";
$result = $conn->query($sql);
?>

    <h2 style="text-align: center;">Meet Our Team</h2>
    <div class="team-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='team-card'>
                    <img src='{$row['team_image']}' alt='Team Member'>
                    <h3>{$row['team_name']}</h3>
                    <p class='role'>{$row['team_role']}</p>
                    <p class='contact'>📧 {$row['team_email']}</p>
                    <p class='contact'>📞 {$row['team_contact']}</p>
                </div>";
            }
        } else {
            echo "<p style='text-align: center;'>No team members found.</p>";
        }
        ?>
    </div>            
      </div>
  
  

  <!-- Embedded JavaScript -->
  <script>
    const menuIcon = document.getElementById("menu-icon");
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.querySelector(".main-content");

    menuIcon.addEventListener("click", () => {
      sidebar.classList.toggle("hidden");
      mainContent.classList.toggle("expanded");
    });
  </script>
</body>
</html>