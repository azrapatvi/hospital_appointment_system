<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>Appointment Booking</title>
    <style>
        .navbar a {
            text-decoration: none;

        }

        .navbar .active {
            text-decoration: underline;
            font-size: 21px;
        }
    </style>
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "hospital";

    $conn = mysqli_connect($servername, $username, $password, $db);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $appointment_date = $_POST['appointment_date'];
        $address = $_POST['address'];
        $appointment_types = isset($_POST['appointment_type']) ? $_POST['appointment_type'] : [];
        $doctor = isset($_POST['doctor']) ? $_POST['doctor'] : '';

        // ✅ Join multiple checkbox values into a single string
        $appointment_type_str = implode(", ", $appointment_types);

        // ✅ Check if doctor already has 10 appointments on that date
        $check_sql = "SELECT COUNT(*) AS total FROM appointments2 WHERE doctor = ? AND appointment_date = ?";
        $stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($stmt, "ss", $doctor, $appointment_date);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $count = mysqli_fetch_assoc($result)['total'];

        if ($count >= 10) {
            echo "<div style='color:red;font-weight:bold;'>❌ Cannot accept more patients. Doctor is fully booked for this date.</div>";
            exit;
        }

        // ✅ Insert the appointment with appointment_type_str
        $insert_sql = "INSERT INTO appointments2 (name, phone, appointment_date, address, appointment_type, doctor) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $name, $phone, $appointment_date, $address, $appointment_type_str, $doctor);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('✅ Appointment booked successfully for $appointment_type_str with $doctor on $appointment_date.');</script>";
        } else {
            echo "<script>alert('❌ Booking failed. Please try again.');</script>";
        }


        mysqli_close($conn);
    }
    ?>



    <nav class="main_nav">
        <div class="logo-title">
            <a href="index.html"><img src="logo.jpg" width="90px" height="90px" class="logo"></a>
            <h1 class="title">Medical Care</h1>
        </div>
        <ul class="navbar">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About us</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="dr.html">Doctors</a></li>
            <li><a href="book.php" class="active">Booking</a></li>
        </ul>

    </nav>

    <div class="booking_appoinment">
        <div class="doc_img">
            <img src="booking5_green_replaced.png" alt="Doctor Image" class="booking_img">
        </div>
        <form id="myform" class="booking_form" action="" method="POST">
            <h2 class="label_book_appoinment">Book Your Appointment</h2>

            <input class="input_tags" type="text" id="name" name="name" placeholder="Enter your name" required>
            <input class="input_tags" type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
            <input class="input_tags" type="date" id="appointment_date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>"  required>
            <textarea class="input_tags" id="address" name="address" placeholder="Enter your Address" required></textarea><br>

            <p class="app_type">Select which appointment type(s) you require</p>
            <div class="checkbox_option">
                <input class="input_tags_check" type="checkbox" name="appointment_type[]" value="General Checkup"> General Checkup
            </div>
            <div class="checkbox_option">
                <input class="input_tags_check" type="checkbox" name="appointment_type[]" value="Heart Checkup"> Heart Checkup
            </div>
            <div class="checkbox_option">
                <input class="input_tags_check" type="checkbox" name="appointment_type[]" value="Eye Checkup"> Eye Checkup
            </div>
            <div class="checkbox_option">
                <input class="input_tags_check" type="checkbox" name="appointment_type[]" value="Dental Checkup"> Dental Checkup
            </div>
            <div class="checkbox_option">
                <input class="input_tags_check" type="checkbox" name="appointment_type[]" value="Mental Health Counseling"> Mental Health Counseling
            </div>

            <!-- Dynamic Doctor Section -->
            <div id="doctor-section" style="display:none;">
                <p class="app_type">Select Doctor:</p>

                <div id="general-doctors" class="doctor-group" style="display:none;">
                    <label><input type="radio" name="doctor" value="Dr. A Sharma (9am - 12pm)"> Dr. A Sharma (9am - 12pm)</label><br>
                    <label><input type="radio" name="doctor" value="Dr. R Mehta (1pm - 4pm)"> Dr. R Mehta (1pm - 4pm)</label>
                </div>

                <div id="heart-doctors" class="doctor-group" style="display:none;">
                    <label><input type="radio" name="doctor" value="Dr. K Patel (10am - 1pm)"> Dr. K Patel (10am - 1pm)</label>
                </div>

                <div id="eye-doctors" class="doctor-group" style="display:none;">
                    <label><input type="radio" name="doctor" value="Dr. L Khan (2pm - 5pm)"> Dr. L Khan (2pm - 5pm)</label>
                </div>

                <div id="dental-doctors" class="doctor-group" style="display:none;">
                    <label><input type="radio" name="doctor" value="Dr. S Roy (11am - 2pm)"> Dr. S Roy (11am - 2pm)</label>
                </div>

                <div id="mental-doctors" class="doctor-group" style="display:none;">
                    <label><input type="radio" name="doctor" value="Dr. N Desai (10am - 1pm)"> Dr. N Desai (10am - 1pm)</label>
                </div>

                <div id="slot_info" style="font-weight:bold; color: green;">Select a doctor to see available slots.</div>
            </div>


            <input type="submit" value="Book Appointment" class="submit_button">
        </form>
    </div>



    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 MedCare Hospital. All rights reserved.</p>
            <p>Contact us: <a href="mailto:info@healthylife.com">info@healthylife.com</a> | +1-800-123-4567</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script>
        $(function() {
            $("#myform").validate();
        });
    </script>
    <!-- JavaScript to handle doctor section visibility -->
    <script>
        // Show relevant doctors based on appointment type
        const checkboxes = {
            'General Checkup': 'general-doctors',
            'Heart Checkup': 'heart-doctors',
            'Eye Checkup': 'eye-doctors',
            'Dental Checkup': 'dental-doctors',
            'Mental Health Counseling': 'mental-doctors'
        };

        $(".input_tags_check").on("change", function() { //whenever usser checks or unchecks the checkbox this function will run
            $("#doctor-section").hide();
            $(".doctor-group").hide();

            let anyChecked = false;
            $(".input_tags_check:checked").each(function() { //input_tags_check is basically a class of checkboxes in the form
                const label = $(this).val(); //gets the value of checkbox
                const sectionId = checkboxes[label]; //the dictionary defined above..  like iif you select heart check up checkboxes['heart checkup] has value heart-doctors so now sectionId becomes heart-doctors

                if (sectionId) {
                    $("#" + sectionId).show(); //adds # to sectionid before sectionid=heart-doctors so now it becomes #heart-doctors which will then visble using show() 
                    anyChecked = true;
                }
            });

            if (anyChecked) {
                $("#doctor-section").show();
            }
        });
    </script>

    <script>
        // Fetch available slots when a doctor is selected
        document.querySelectorAll('input[name="doctor"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedDoctor = this.value;
                const appointmentDate = document.getElementById("appointment_date").value;

                if (!appointmentDate) {
                    document.getElementById("slot_info").textContent = "Please select appointment date first.";
                    return;
                }

                fetch("check_slots.php", { //ajax request to check_slots.php
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body: `doctor=${encodeURIComponent(selectedDoctor)}&appointment_date=${encodeURIComponent(appointmentDate)}` //to safely send the data to check_slots.php
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById("slot_info").textContent = `${selectedDoctor} has ${data.slots} slots available on ${appointmentDate}`;
                        } else {
                            document.getElementById("slot_info").textContent = "Doctor not available or slots full.";
                        }
                    })
                    .catch(error => {
                        document.getElementById("slot_info").textContent = "Error fetching slot info.";
                        console.error("Error:", error);
                    });
            });
        });

        // Optional: Refresh slot info if date is changed (jquery used here little bit)
        $('#appointment_date').change(function() {
            $('input[name="doctor"]:checked').trigger('change');
        });
    </script>



</body>

</html>