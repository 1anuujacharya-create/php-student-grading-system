<?php
// Author: Anuj Acharya
// Project: PHP Student Grading System
// Description: A PHP program to calculate averages, percentages, fails, probation status, and honor roll eligibility.
// Date: 2025-09-17

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ---------------------------
    // PART 1: SINGLE STUDENT CALCULATIONS
    // ---------------------------
    $score1 = $_POST['score1'];
    $score2 = $_POST['score2'];
    $score3 = $_POST['score3'];

    $average = ($score1 + $score2 + $score3) / 3;
    $totalMarks = 300;
    $obtainedMarks = $score1 + $score2 + $score3;
    $percentage = ($obtainedMarks / $totalMarks) * 100;

    // Subject marks for probation check
    $subjects = $_POST['subjects'];
    $failCount = 0;
    foreach ($subjects as $mark) {
        if ($mark < 50) {
            $failCount++;
        }
    }

    $resultMessage = ($average >= 50) ? "Pass" : "Fail";

    $honorRoll = "";
    if ($average > 90 && ($score1 > 95 || $score2 > 95 || $score3 > 95)) {
        $honorRoll = "Student qualifies for the Honor Roll!";
    }

    // ---------------------------
    // OUTPUT: PART 1
    // ---------------------------
    echo "<h2>Results for Single Student</h2>";
    echo "Exam Scores: $score1, $score2, $score3 <br>";
    echo "Average Score: $average <br>";
    echo "Percentage: $percentage% <br>";
    echo "Result: $resultMessage <br>";
    echo "Number of failed subjects: $failCount <br>";
    if ($failCount > 2) {
        echo "<b>Warning: Student is placed on academic probation.</b><br>";
    }
    if (!empty($honorRoll)) {
        echo "<b>$honorRoll</b><br>";
    }

    // ---------------------------
    // PART 2: PROCESSING 5 STUDENTS
    // ---------------------------
    echo "<h2>Results for 5 Students</h2>";
    for ($student = 1; $student <= 5; $student++) {
        $s1 = $_POST["student{$student}_score1"];
        $s2 = $_POST["student{$student}_score2"];
        $s3 = $_POST["student{$student}_score3"];

        $avg = ($s1 + $s2 + $s3) / 3;
        $status = ($avg >= 50) ? "Pass" : "Fail";

        echo "Student $student -> Scores: $s1, $s2, $s3 | Average: $avg | $status";

        if ($avg > 90 && ($s1 > 95 || $s2 > 95 || $s3 > 95)) {
            echo " | Honor Roll";
        }
        echo "<br>";
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>
<head>
    <title>PHP Student Grading System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        fieldset { margin-bottom: 20px; padding: 15px; border-radius: 8px; background: #f4f4f9; }
        legend { font-weight: bold; }
        label { display: block; margin: 5px 0; }
        button { padding: 10px 15px; background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #45a049; }
    </style>
</head>
<body>
    <h1>PHP Student Grading System</h1>
    <form method="post">
        
        <fieldset>
            <legend>Single Student - Exam Scores</legend>
            <label>Exam Score 1: <input type="number" name="score1" required></label>
            <label>Exam Score 2: <input type="number" name="score2" required></label>
            <label>Exam Score 3: <input type="number" name="score3" required></label>
        </fieldset>

        <fieldset>
            <legend>Five Subject Marks (Probation Check)</legend>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <label>Subject <?php echo $i; ?>: <input type="number" name="subjects[]" required></label>
            <?php endfor; ?>
        </fieldset>

        <fieldset>
            <legend>Enter Scores for 5 Students</legend>
            <?php for ($student = 1; $student <= 5; $student++): ?>
                <h4>Student <?php echo $student; ?></h4>
                <label>Exam 1: <input type="number" name="student<?php echo $student; ?>_score1" required></label>
                <label>Exam 2: <input type="number" name="student<?php echo $student; ?>_score2" required></label>
                <label>Exam 3: <input type="number" name="student<?php echo $student; ?>_score3" required></label>
                <hr>
            <?php endfor; ?>
        </fieldset>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
