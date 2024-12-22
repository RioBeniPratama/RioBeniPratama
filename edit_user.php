<?php
session_start();
include 'db.php';

// Cek apakah parameter 'id' ada
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data user berdasarkan ID
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);

    // Periksa apakah ada user yang ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User tidak ditemukan!";
        exit();
    }
} else {
    echo "ID tidak ada!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Rajawali Motor Sport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #4d4747;
            color: white;
            font-weight: bold;
        }

        .form-control:focus {
            border-color: #FFD700;
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        }

        .btn-primary {
            background-color: #FFD700;
            border: none;
            color: #4d4747;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #ffbf00;
            color: #322b2c;
        }

        .btn-danger {
            background-color: #ff4d4d;
            border: none;
            color: white;
            font-weight: bold;
        }

        .btn-danger:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            Edit User
        </div>
        <div class="card-body">
            <form method="POST" action="update_user.php">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
