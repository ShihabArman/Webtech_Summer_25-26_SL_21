<!DOCTYPE html>
<html>
<head>
    <title>Student Registration Form</title>
</head>
<body>

    <h2>Student Registration Form</h2>

<?php

$studentName = $username = $email = $phone = $age = $studentID = $website = $dob = "";
$nameErr = $usernameErr = $emailErr = $phoneErr = $ageErr = "";
$passwordErr = $confirmPasswordErr = $studentIdErr = $websiteErr = $dobErr = "";

$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // full name
    if (empty($_POST["name"])) {
        $nameErr = "Full Name is required";
    } else {
        $studentName = trim($_POST["name"]);

        if (!preg_match("/^[a-zA-Z ]+$/", $studentName)) {
            $nameErr = "Only letters and spaces are allowed";
        } elseif (strlen($studentName) < 3) {
            $nameErr = "Full Name must be at least 3 characters";
        } elseif (strlen($studentName) > 50) {
            $nameErr = "Full Name must not exceed 50 characters";
        }
    }

    // username
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = trim($_POST["username"]);

        if (!preg_match("/^[A-Za-z][A-Za-z0-9_]*$/", $username)) {
            $usernameErr = "Username must start with a letter and contain only letters, numbers, and underscore";
        } elseif (strlen($username) < 5 || strlen($username) > 15) {
            $usernameErr = "Username must be between 5 and 15 characters";
        }
    }

    // email
    if (empty($_POST["email"])) {
        $emailErr = "Email Address is required";
    } else {
        $email = trim($_POST["email"]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } elseif (!preg_match("/\.(com|org|edu)$/i", $email)) {
            $emailErr = "Email must end with .com, .org, or .edu";
        }
    }

    // phn No
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone Number is required";
    } else {
        $phone = trim($_POST["phone"]);

        if (!ctype_digit($phone)) {
            $phoneErr = "Phone Number must contain digits only";
        } elseif (substr($phone, 0, 2) !== "01") {
            $phoneErr = "Phone Number must start with 01";
        } elseif (strlen($phone) != 11) {
            $phoneErr = "Phone Number must be exactly 11 digits";
        }
    }

    // age
    if (empty($_POST["age"])) {
        $ageErr = "Age is required";
    } else {
        $age = trim($_POST["age"]);

        if (!is_numeric($age)) {
            $ageErr = "Age must be a numeric value";
        } elseif ($age < 18 || $age > 30) {
            $ageErr = "Age must be between 18 and 30";
        }
    }

    // password
    $password = "";
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];

        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters";
        } elseif (!preg_match("/[A-Z]/", $password)) {
            $passwordErr = "Password must contain at least one uppercase letter";
        } elseif (!preg_match("/[0-9]/", $password)) {
            $passwordErr = "Password must contain at least one digit";
        } elseif (!preg_match("/[@#$%]/", $password)) {
            $passwordErr = "Password must contain at least one of the characters @ # $ %";
        }
    }

    // confirm pass
    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Confirm Password is required";
    } else {
        $confirmPassword = $_POST["confirm_password"];

        if ($confirmPassword !== $password) {
            $confirmPasswordErr = "Confirm Password must match Password";
        }
    }

    // student id
    if (empty($_POST["student_id"])) {
        $studentIdErr = "Student ID is required";
    } else {
        $studentID = trim($_POST["student_id"]);

        if (!preg_match("/^\d{2}-\d{5}-\d{1}$/", $studentID)) {
            $studentIdErr = "Student ID must follow the format XX-XXXXX-X (e.g. 22-12345-1)";
        }
    }

    //website
    if (empty($_POST["website"])) {
        $websiteErr = "Personal Website is required";
    } else {
        $website = trim($_POST["website"]);

        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $websiteErr = "Website must be a valid URL";
        } elseif (!preg_match("#^https?://#i", $website)) {
            $websiteErr = "Website must begin with http:// or https://";
        }
    }

    //dob
    if (empty($_POST["dob"])) {
        $dobErr = "Date of Birth is required";
    } else {
        $dob = trim($_POST["dob"]);
    }

    if (
        empty($nameErr) && empty($usernameErr) && empty($emailErr) &&
        empty($phoneErr) && empty($ageErr) && empty($passwordErr) &&
        empty($confirmPasswordErr) && empty($studentIdErr) &&
        empty($websiteErr) && empty($dobErr)
    ) {
        $success = true;
    }
}
?>

<?php if ($success): ?>

    <h3>Registration Successful!</h3>
    <p>
        Full Name: <?php echo htmlspecialchars($studentName); ?><br>
        Username: <?php echo htmlspecialchars($username); ?><br>
        Student ID: <?php echo htmlspecialchars($studentID); ?><br>
        Email Address: <?php echo htmlspecialchars($email); ?>
    </p>

<?php else: ?>

<form method="post" action="">

    Full Name:
    <input type="text" name="name" value="<?php echo htmlspecialchars($studentName); ?>">
    <span style="color:black"><?php echo $nameErr; ?></span>
    <br><br>

    Username:
    <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
    <span style="color:black"><?php echo $usernameErr; ?></span>
    <br><br>

    Email Address:
    <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
    <span style="color:black"><?php echo $emailErr; ?></span>
    <br><br>

    Phone Number:
    <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
    <span style="color:black"><?php echo $phoneErr; ?></span>
    <br><br>

    Age:
    <input type="text" name="age" value="<?php echo htmlspecialchars($age); ?>">
    <span style="color:black"><?php echo $ageErr; ?></span>
    <br><br>

    Password:
    <input type="password" name="password" value="">
    <span style="color:black"><?php echo $passwordErr; ?></span>
    <br><br>

    Confirm Password:
    <input type="password" name="confirm_password" value="">
    <span style="color:black"><?php echo $confirmPasswordErr; ?></span>
    <br><br>

    Student ID:
    <input type="text" name="student_id" value="<?php echo htmlspecialchars($studentID); ?>">
    <span style="color:black"><?php echo $studentIdErr; ?></span>
    <br><br>

    Personal Website:
    <input type="text" name="website" value="<?php echo htmlspecialchars($website); ?>">
    <span style="color:black"><?php echo $websiteErr; ?></span>
    <br><br>

    Date of Birth:
    <input type="text" name="dob" value="<?php echo htmlspecialchars($dob); ?>">
    <span style="color:black"><?php echo $dobErr; ?></span>
    <br><br>

    <input type="submit" name="submit" value="Register">

</form>

<?php endif; ?>

</body>
</html>

<?php
// 1. htmlspecialchars() is used to convert special characters (such as
//    <, >, ", ') into HTML entities before echoing user input back into
//    the page. This prevents Cross-Site Scripting (XSS) attacks where a
//    submitted value like <script>...</script> could otherwise be
//    executed as real HTML/JavaScript in the browser.
// 2. Server-side validation is still necessary even when HTML validation
//    is available because client-side checks run inside the user's own
//    browser and can be bypassed — by disabling JavaScript, editing the
//    HTML, or sending a POST request directly to the server with a tool
//    like Postman or curl. Only validation that runs on the server can
//    be trusted, since the server has no control over the client.
// 3. Order of checks matters for the Age field: is_numeric($age) must be
//    checked before the range check ($age < 18 || $age > 30), because
//    comparing a non-numeric string with numeric operators can produce
//    incorrect or misleading results instead of a clean validation error.
?>