<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['web_url'])) {
    $url = filter_var($_POST['web_url'], FILTER_SANITIZE_URL);

    if (filter_var($url, FILTER_VALIDATE_URL)) {
        // Path to JMeter and the test plan
        $jmeterPath = "/path/to/jmeter/bin/jmeter";
        $testPlanPath = "/path/to/test-plan.jmx";
        
        // Replace the placeholder in the test plan with the URL
        $command = "$jmeterPath -n -t $testPlanPath -JwebURL=$url -l results.jtl";
        
        // Run JMeter command
        $output = shell_exec($command);

        if ($output) {
            $message = "JMeter test started successfully for the URL: " . htmlspecialchars($url);
        } else {
            $message = "Failed to start the JMeter test.";
        }
    } else {
        $message = "Invalid URL. Please enter a valid web application URL.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JMeter Performance Test</title>
    <style type="text/css">
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            border: 1px solid #e7e7e7;
            background-color: #f3f3f3;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: #666;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover:not(.active) {
            background-color: #ddd;
        }

        li a.active {
            color: white;
            background-color: #4CAF50;
        }

        .input-container {
            margin: 50px auto;
            max-width: 500px;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 10px;
        }

        .input-container input[type="text"] {
            width: 96%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .input-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .input-container input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <!-- URL Input Form -->
    <div class="input-container">
        <h2>Enter the Web Application URL for JMeter Test</h2>
        <form method="POST" action="">
            <input type="text" name="web_url" placeholder="Enter web application URL" required>
            <input type="submit" value="Send to JMeter">
        </form>
    </div>

    <!-- PHP Logic to Handle the Web Application URL -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['web_url'])) {
        $url = filter_var($_POST['web_url'], FILTER_SANITIZE_URL);

        // Validate the URL
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            // Here, you can trigger a shell script to run JMeter with the provided URL
            $message = "Sending the URL to JMeter: " . htmlspecialchars($url);
            // You would add the logic to send this to JMeter, explained below.
        } else {
            $message = "Invalid URL. Please enter a valid web application URL.";
        }
    }
    ?>

    <!-- Display Result -->
    <?php if (isset($message)): ?>
        <div class="message-container">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

</body>
</html>
