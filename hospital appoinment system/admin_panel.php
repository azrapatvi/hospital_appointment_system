<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin_panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            padding: 0;
            margin: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 0 auto;
            background-color: #fff;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #1e90ff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .search_date {

            margin-top: 50px;
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="date"],
        select {
            font-size: 14px;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            font-size: 14px;
            padding: 10px 20px;
            background-color: #1e90ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .reset {
            text-decoration: none;
            font-size: 15px;
            padding: 11px 20px;
            background-color: #1e90ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin_panel.php">Booked Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="drs.php">Doctor Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="queries.php">Queries </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav><br>

    <?php
    $conn = mysqli_connect("localhost", "root", "", "hospital");

    $filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
    $filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : '';

    // Get types for dropdown
    $type_result = mysqli_query($conn, "SELECT DISTINCT appointment_type FROM appointments2");

    echo '<h1>Booked Appointments</h1>';
    echo '<form class="search_date" method="GET">
            <label for="filter_date"><b>Search by Date:</b></label>
            <input type="date" id="filter_date" name="filter_date" value="' . htmlspecialchars($filter_date) . '">

            <label for="filter_type" style="margin-left: 20px;"><b>Search by Type:</b></label>
            <select name="filter_type" id="filter_type">
                <option value="">-- All Types --</option>';

    while ($row = mysqli_fetch_assoc($type_result)) {
        $selected = ($filter_type === $row['appointment_type']) ? "selected" : "";
        echo "<option value='{$row['appointment_type']}' $selected>{$row['appointment_type']}</option>";
    }

    echo '  </select>
            <input type="submit" value="Search">
            <a href="admin_panel.php" class="reset">Reset</a>
        </form><br>';

    // Dynamic query based on filters
    if (!empty($filter_date) && !empty($filter_type)) {
        $query = "SELECT * FROM appointments2 WHERE appointment_date = '$filter_date' AND appointment_type = '$filter_type' ORDER BY appointment_date ASC, id ASC";
        $result = mysqli_query($conn, $query);
    } elseif (!empty($filter_date)) {
        $query = "SELECT * FROM appointments2 WHERE appointment_date = '$filter_date' ORDER BY appointment_date ASC, id ASC";
        $result = mysqli_query($conn, $query);
    } elseif (!empty($filter_type)) {
        $query = "SELECT * FROM appointments2 WHERE appointment_type = '$filter_type' ORDER BY appointment_date ASC, id ASC";
        $result = mysqli_query($conn, $query);
    } else {
        $query = "SELECT * FROM appointments2 ORDER BY appointment_date ASC, id ASC";
        $result = mysqli_query($conn, $query);
    }


    // Display table
    echo "<table border='1' cellpadding='8'>
        <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Phone</th>
            <th>Date</th>
            <th>Address</th>
            <th>Type</th>
            <th>Doctor</th>
        </tr>";
    $i = 1; // Initialize visible serial number
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$i}</td>
            <td>{$row['name']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['appointment_date']}</td>
            <td>{$row['address']}</td>
            <td>{$row['appointment_type']}</td>
            <td>{$row['doctor']}</td>
        </tr>";
        $i++; // Increment counter
    }
    echo "</table><br><br>";


    mysqli_close($conn);
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>