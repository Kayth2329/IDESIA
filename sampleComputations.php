<?php
// samplecomputation.php

// Database connection parameters
$host = '127.0.0.1'; // Change as necessary
$db = 'idesia'; // Change to your database name
$user = 'root'; // Change to your database username
$pass = ''; // Change to your database password

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch house model prices
$sql = "SELECT model1_price AS gaia_price, model2_price AS talia_price, model3_price AS aria_price FROM settings LIMIT 1"; 
$result = $conn->query($sql);

// Initialize model costs
$modelCostsPHP = [];

if ($result->num_rows > 0) {
    // Fetch associative array
    $row = $result->fetch_assoc();
    $modelCostsPHP = [
        "gaia" => $row['gaia_price'],
        "talia" => $row['talia_price'],
        "aria" => $row['aria_price'],
    ];
} else {
    // Handle the case where there are no results
    echo "No models found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Model Sample Computation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7efe0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0;
            padding: 5px;
            font-size: larger;
        }
        .top-nav {
            display: flex;
            justify-content: flex-end; 
            align-items: center;
            gap: 15px; 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #D2B48C;
            padding: 10px;
            z-index: 1000;
        }
        .contact-us {
            background-color: #F0E6D2; 
            padding: 10px 20px; 
            border-radius: 20px;
            margin: 20px;
        }
        .contact-us a {
            text-decoration: none;
            color: black;
        }

        .title {
            display: flex; 
            align-items: center; 
            margin-right: auto; 
        }
        .title-img {
            width: 50px; 
            height: auto; 
        }
        .nav {
            display: flex;
            gap: 15px;
        }
        .schedule {
            background-color: #F0E6D2; 
            padding: 10px 20px; 
            border-radius: 20px;
            margin: 20px;
        }
        .schedule a {
            text-decoration: none;
            color: black;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            text-align: center;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            text-align: left;
        }
        #results {
            margin-top: 20px;
            text-align: left;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            font-weight: bold;
        }
        button {
            margin-top: 20px; 
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #45a049;
        }
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .header {
        background-color: #333;
        color: white;
        padding: 10px 0;
        text-align: center;
    }

        .title {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .title-text {
            margin: 0;
            padding: 0;
        }

        .title-img {
            width: 50px; 
            height: auto;
            margin-left: 10px; 
        }

        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }

        .nav {
            display: flex;
        }

        .nav a {
            color: white;
            text-decoration: none;
            margin-right: 10px; 
        }

        .nav a:hover {
            text-decoration: underline;
        }

        .contact-us a {
            color: white;
            text-decoration: none;
        }

        .contact-us a:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <div class="header">
            <div class="top-nav">
                <div class="title">
                    <h1 class="title-text">IDESIA</h1>
                    <img class="title-img" src="C:/Users/mark justin/Downloads/c80c4daa-1aea-4126-91c0-5f0002d7fcf4.jpg" alt="Title Image">
                </div>
                <nav class="nav">
                    <a href="login.php">Login</a>
                </nav>
                <div class="schedule">
                    <a href="http://localhost:3000/Schedule.php">Schedule A Tripping</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <h1>House Model Sample Computation</h1>
        
        <form id="calculatorForm">
            <label for="houseModel">Choose a House Model:</label>
            <select id="houseModel" name="houseModel">
                <option value="aria">Gaia</option>
                <option value="talia">Talia</option>
                <option value="gaia">Aria</option>
            </select><br><br>
            
            <label for="installmentYears">Installment Years:</label>
            <input type="number" id="installmentYears" name="installmentYears" required><br><br>
            
            
            <button type="button" onclick="calculate()">Calculate</button>
        </form>
        
        <div id="results"></div>
    </div>

    <script>
        document.getElementById("houseModel").addEventListener("change", function() {
            document.getElementById("positionOptions").style.display = this.value === "aria" ? "block" : "none";
        });

        function calculate() {
            // Retrieve user inputs
            let selectedModel = document.getElementById("houseModel").value;
            let installmentYears = parseInt(document.getElementById("installmentYears").value);
            let position = null; // Initialize position variable for "Aria"

            let modelCostsPHP = <?php echo json_encode($modelCostsPHP); ?>; // Get model costs from PHP

            let reservationFeesPHP = {
                "gaia": 30000,
                "talia": 20000,
                "aria": 10000
            };

            let totalCostPHP;
            let reservationFee;

            if (selectedModel === "aria") {
                position = document.querySelector('input[name="position"]:checked')?.value;
                totalCostPHP = modelCostsPHP["aria"]; // Adjusted for 3 models
                reservationFee = reservationFeesPHP["aria"];
            } else {
                totalCostPHP = modelCostsPHP[selectedModel];
                reservationFee = reservationFeesPHP[selectedModel];
            }

            // Calculate downpayment as 10% of total cost
            let downpaymentPHP = totalCostPHP * 0.1;

            // Calculate loanable amount (90% of total cost)
            let loanableAmountPHP = totalCostPHP * 0.9;

            // Calculate total months for downpayment
            let totalMonthsDownpayment = 15; // Fixed for downpayment

            // Calculate total months for remaining 90% based on user input installment years
            let totalMonthsRemaining = installmentYears * 12;

            // Calculate monthly installment for remaining 90%
            let monthlyInstallmentPHP = loanableAmountPHP / totalMonthsRemaining;

            // Calculate monthly downpayment installment
            let downpaymentInstallmentPHP = downpaymentPHP / totalMonthsDownpayment;

            // Display results in Philippine Pesos (PHP) in a table
            let resultsDiv = document.getElementById("results");
            resultsDiv.innerHTML = `
                <h2>Sample Computation</h2>
                <table>
                    <tr>
                        <th colspan="2">House Purchase Details</th>
                    </tr>
                    <tr>
                        <td>House Model</td>
                        <td>${selectedModel.toUpperCase()}</td>
                    </tr>
                    <tr>
                        <td>Total Cost</td>
                        <td>₱ ${totalCostPHP.toLocaleString()}</td>
                    </tr>
                    <tr>
                        <td>Reservation Fee</td>
                        <td>₱ ${reservationFee.toLocaleString()}</td>
                    </tr>
                    <tr>
                        <td>Downpayment (10%)</td>
                        <td>₱ ${downpaymentPHP.toLocaleString()}</td>
                    </tr>
                    <tr>
                        <td>Loanable Amount (90%)</td>
                        <td>₱ ${loanableAmountPHP.toLocaleString()}</td>
                    </tr>
                    <tr>
                        <td>Monthly Downpayment Installment</td>
                        <td>₱ ${downpaymentInstallmentPHP.toLocaleString()}</td>
                    </tr>
                    <tr>
                        <td>Monthly Installment for 90%</td>
                        <td>₱ ${monthlyInstallmentPHP.toLocaleString()}</td>
                    </tr>
                </table>
            `;
        }
    </script>
</body>
</html>
