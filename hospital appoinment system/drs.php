<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Doctor Details</title>
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
    </nav>
    <div><br>
        <h1>Doctor Details</h1><br><br>

        <?php

        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = "hospital";

        $conn = mysqli_connect($servername, $username, $password, $db);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch and display all queries (works whether POST or not)
        $sql = "SELECT * FROM doctors";
        $result = mysqli_query($conn, $sql);
        echo "<table border='1' cellpadding='8'>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone No</th>
            <th>Qualification</th>
            <th>Experience</th>
            <th>Specialization</th>
            <th>timing</th>
        </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['qualification']}</td>
            <td>{$row['experience']}</td>
            <td>{$row['specialization']}</td>
            <td>{$row['timing']}</td>
        </tr>";
        }
        echo "</table>";
        mysqli_close($conn);
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>
</html>
