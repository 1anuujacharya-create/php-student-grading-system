<?php
// Author: Anuj Acharya
// Project: PHP Student Grading System
// Description: A PHP program to calculate averages, percentages, fails, probation status, and honor roll eligibility.
// Date: 2025-09-17

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ---------------------------
    // PART 1: SINGLE STUDENT CALCULATIONS
    // ---------------------------

    // Collect three exam scores from user input (to evaluate performance in 3 exams)
    $score1 = $_POST['score1'];
    $score2 = $_POST['score2'];
    $score3 = $_POST['score3'];

    // Calculate the average score across three exams to determine overall performance
    $average = ($score1 + $score2 + $score3) / 3;

    // Each exam is out of 100, so the total possible marks is 300
    $totalMarks = 300;
    $obtainedMarks = $score1 + $score2 + $score3;

    // Calculate percentage based on marks obtained out of 300
    $percentage = ($obtainedMarks / $totalMarks) * 100;

    // Collect subject marks for probation check (5 subjects entered separately)
    $subjects = $_POST['subjects'];
    $failCount = 0;

    // Count how many subjects have marks below 50 (fail condition)
    foreach ($subjects as $mark) {
        if ($mark < 50) {
            $failCount++;
        }
    }

    // Determine Pass/Fail result based on average score threshold (50)
    $resultMessage = ($average >= 50) ? "Pass" : "Fail";

    // Check eligibility for Honor Roll:
    // Student must have an average > 90 AND scored above 95 in at least one exam
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

    // Display probation warning if student has failed more than 2 subjects
    if ($failCount > 2) {
        echo "<b>Warning: Student is placed on academic probation.</b><br>";
    }

    // Display Honor Roll message if student meets the conditions
    if (!empty($honorRoll)) {
        echo "<b>$honorRoll</b><br>";
    }

    // ---------------------------
    // PART 2: PROCESSING 5 STUDENTS
    // ---------------------------
    // Loop through data for 5 students.
    // For each student, calculate average, decide Pass/Fail, and check Honor Roll eligibility.
    echo "<h2>Results for 5 Students</h2>";
    for ($student = 1; $student <= 5; $student++) {
        $s1 = $_POST["student{$student}_score1"];
        $s2 = $_POST["student{$student}_score2"];
        $s3 = $_POST["student{$student}_score3"];

        // Calculate average for the student
        $avg = ($s1 + $s2 + $s3) / 3;

        // Determine pass/fail status
        $status = ($avg >= 50) ? "Pass" : "Fail";

        // Display results for each student
        echo "Student $student -> Scores: $s1, $s2, $s3 | Average: $avg | $status";

        // Additional check for Honor Roll (same condition as single student)
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
        
        <!-- Input section for a single student (3 exam scores) -->
        <fieldset>
            <legend>Single Student - Exam Scores</legend>
            <label>Exam Score 1: <input type="number" name="score1" required></label>
            <label>Exam Score 2: <input type="number" name="score2" required></label>
            <label>Exam Score 3: <input type="number" name="score3" required></label>
        </fieldset>

        <!-- Input section for 5 subjects (probation check) -->
        <fieldset>
            <legend>Five Subject Marks (Probation Check)</legend>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <label>Subject <?php echo $i; ?>: <input type="number" name="subjects[]" required></label>
            <?php endfor; ?>
        </fieldset>

        <!-- Input section for 5 students (loop processing of averages and pass/fail) -->
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

        <!-- Submit button to process the grading system -->
        <button type="submit">Submit</button>
    </form>
</body>
</html>
