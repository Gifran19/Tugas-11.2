<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Validasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #00aeff;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .error {
            color: #FF0000;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .radio-group {
            margin-bottom: 20px;
        }
        .radio-group input[type="radio"] {
            margin-right: 10px;
        }
        .radio-group label {
            display: inline-block;
            margin-right: 20px;
            font-weight: normal;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <?php
    $nameErr = $emailErr = $genderErr = $dobErr = "";
    $name = $email = $gender = $comment = $dob = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = test_input($_POST["name"]);
        $email = test_input($_POST["email"]);
        $dob = test_input($_POST["dob"]);
        $gender = test_input($_POST["gender"]);
        $comment = test_input($_POST["comment"]);

        if (empty($name)) {
            $nameErr = "Name is required";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }

        if (empty($email)) {
            $emailErr = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }

        if (empty($dob)) {
            $dobErr = "Date of birth is required";
        } else {
            $dobArr = explode('-', $dob);
            if (!checkdate($dobArr[1], $dobArr[2], $dobArr[0])) {
                $dobErr = "Invalid date format";
            }
        }

        if (empty($gender)) {
            $genderErr = "Gender is required";
        }

        if ($name === $email || $name === $dob || $name === $gender || $name === $comment || 
            $email === $dob || $email === $gender || $email === $comment || 
            $dob === $gender || $dob === $comment || 
            $gender === $comment) {
            $nameErr = $emailErr = $dobErr = $genderErr = "Fields must contain different values";
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <div class="container">
        <h2>Formulir Validasi PHP</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" value="<?php echo $name;?>">
                <span class="error">* <?php echo $nameErr;?></span>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $email;?>">
                <span class="error">* <?php echo $emailErr;?></span>
            </div>
            
            <div class="form-group">
                <label for="dob">Tanggal Lahir:</label>
                <input type="date" id="dob" name="dob" value="<?php echo $dob;?>">
                <span class="error">* <?php echo $dobErr;?></span>
            </div>
            
            <div class="form-group radio-group">
                <label>Jenis Kelamin:</label>
                <input type="radio" id="female" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">
                <label for="female">Perempuan</label>
                <input type="radio" id="male" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">
                <label for="male">Laki-laki</label>
                <span class="error">* <?php echo $genderErr;?></span>
            </div>
            
            <div class="form-group">
                <label for="comment">Komentar:</label>
                <textarea id="comment" name="comment" rows="5"><?php echo $comment;?></textarea>
            </div>
            
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($nameErr) && empty($emailErr) && empty($dobErr) && empty($genderErr)) {
            echo "<h2>Data yang Anda Masukkan:</h2>";
            echo "<p><strong>Nama:</strong> " . $name . "</p>";
            echo "<p><strong>Email:</strong> " . $email . "</p>";
            echo "<p><strong>Tanggal Lahir:</strong> " . $dob . "</p>";
            echo "<p><strong>Jenis Kelamin:</strong> " . $gender . "</p>";
            echo "<p><strong>Komentar:</strong> " . $comment . "</p>";
        }
        ?>
    </div>

</body>
</html>
