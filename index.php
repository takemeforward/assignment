<?php
// Checking weather form is submitted or not
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // taking all form data into variable to process it later
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $noOfMembers = $_POST['noOfMember'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    // name validationg so that only letters and spaces should be captured
    $namePattern = '/^[A-Za-z\s]+$/';
    if (!preg_match($namePattern, $name)) {
        echo "Please enter a valid name with only letters and spaces.";
        exit;
    }

    // Eamil pattern validation
    $emailPattern = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    if (!preg_match($emailPattern, $email)) {
        echo "Please enter a valid email address.";
        exit;
    }

    // validation phone number so that len should be exactly 10 and should not start with '0'
    $phonePattern = '/^\d{10}$/';
    if (!preg_match($phonePattern, $phone)) {
        echo "Please enter a valid phone number (exactly 10 digits).";
        exit;
    }


    // Validate dates
    $tomorrow = date('Y-m-d', strtotime('+0 day'));
    $max_date = date('Y-m-d', strtotime('+20 days'));

    if ($from_date < $tomorrow || $from_date > $max_date || $to_date > $max_date || $to_date < $tomorrow) {
        echo "Invalid dates. Dates should be from today to a maximum of 20 days.";
        exit;
    }

    // Validate number of members (Should be a positive integer and less than 20)
    if (!ctype_digit($noOfMembers) || $noOfMembers <= 0 || $noOfMembers >= 20) {
        echo "Please enter a valid number of members (a positive integer less than 20).";
        exit;
    }

    // Save data to database
    $conn = new mysqli('localhost', 'root', '', 'family_trip');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape input data to prevent SQL injection
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $phone = $conn->real_escape_string($phone);
    $noOfMembers = $conn->real_escape_string($noOfMembers);
    $from_date = $conn->real_escape_string($from_date);
    $to_date = $conn->real_escape_string($to_date);

    $sql = "INSERT INTO `family_trip`.`family_trip` (name, email, phone, from_date, to_date, noOfMembers) 
            VALUES ('$name', '$email', '$phone', '$from_date', '$to_date', '$noOfMembers')";

    if ($conn->query($sql) === TRUE) {
        echo "Travel record saved successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
