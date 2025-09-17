<?php
// Author: Anuj Acharya
// Project: PHP Student Grading System
// Description: This script calculates student averages, percentages, failed subjects,
//              and identifies honor roll eligibility using PHP form input, arithmetic,
//              conditionals, and loops.
// Date: 2025-09-17
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ---------------------------
    // PART 1: Basic Arithmetic
    // ---------------------------

    // Collect exam scores from form input
    $score1 = $_POST['score1'];
    $score2 = $_POST['score2'];
    $score3 = $_POST['score3'];

    // Task 1: Calculate average
    $average = ($score1 + $score2 + $score3) / 3;

    // Task 2: Calculate percentage (total 300 marks)
    $totalMarks = 300;
    $obtainedMarks = $score1 + $score2 + $score3;
    $percentage = ($obtainedMarks / $totalMarks) * 100;

    // Task 3: Count failed subjects (marks below 50 in 5 subjects)
    $subjects = $_POST['subjects']; // array of 5 subject marks
    $failCount = 0;

    foreach ($subjects as $mark) {
        if ($mark < 50) {
            $failCount++;
        }
    }

    // ---------------------------
    // PART 2: Conditional Logic
    // ---------------------------
    $resultMessage = ($average >= 50) ? "Pass" : "Fail";

    $honorRoll = "";
    if ($average > 90 && ($score1 > 95 || $score2 > 95 || $score3 > 95)) {
        $honorRoll = "Student qualifies for the Honor Roll!";
    }

    // ---------------------------
    // OUTPUT
    // ---------------------------
    echo "<h2>Results</h2>";
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

    // Task 2(c): Process grades for 5 students
    echo "<h3>Processing 5 Students</h3>";
    for ($student = 1; $student <= 5; $student++) {
        // Example: random exam scores between 30 and 100 for demonstration
        $s1 = rand(30, 100);
        $s2 = rand(30, 100);
        $s3 = rand(30, 100);

        $avg = ($s1 + $s2 + $s3) / 3;
        echo "Student $student -> Scores: $s1, $s2, $s3 | Average: $avg | ";

        echo ($avg >= 50) ? "Pass" : "Fail";

        if ($avg > 90 && ($s1 > 95 || $s2 > 95 || $s3 > 95)) {
            echo " | Honor Roll";
        }
        echo "<br>";
    }
}
?>

<!-- HTML Form for User Input -->
<h2>Enter Student Scores</h2>
<form method="post">
    <label>Exam Score 1: <input type="number" name="score1" required></label><br>
    <label>Exam Score 2: <input type="number" name="score2" required></label><br>
    <label>Exam Score 3: <input type="number" name="score3" required></label><br><br>

    <h3>Enter 5 Subject Marks</h3>
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <label>Subject <?php echo $i; ?>: <input type="number" name="subjects[]" required></label><br>
    <?php endfor; ?>

    <br><button type="submit">Submit</button>
</form>
