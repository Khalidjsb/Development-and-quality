<?php include"header.php";?>

<?php
include "connn.php";
$sql = "SELECT * FROM Students";
$result = $conn->query($sql);
?>
<h2>بيانات الطلاب</h2>

<table border="1">
    <tr>
        <th>رقم الطالب</th>
        <th>اسم الطالب</th>
        <th>الحالة</th>
        <th></th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["StudentID"] . "</td>";
            echo "<td>" . $row["StudentName"] . "</td>";
            echo "<td>" . $row["state"] . "</td>";
            echo "<td>";
            
            // Check if the student's state is "محروم" (deprived)
            if ($row["state"] == "محروم") {
                echo "لا يمكن الاضافة لطالب محروم";
            } else {
                // Link to add grades only if the student's state is not "محروم"
                echo "<a href='add_grade.php?ids=" . $row['StudentID'] . "'>اضافة درجات</a>";
            }
            
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>لا توجد بيانات</td></tr>";
    }
    ?>
</table>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-5">
    <h4 align="center" class="mb-4"> درجات </h4> 
    <div class="row justify-content-center">
        <div class="col-md-3"></div>  
        <div class="col-md-6" style='padding: 0;'>

            <?php
            include "connn.php";
            $sql = "SELECT * FROM LearningOutcomeAssessment";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
//                echo "<h6> مخرجات التعلم للمقرر مع أنشطة التقييم </h6>";
                echo "<table class='table table-striped'>";
                echo "<thead><tr>
                    <th style='text-align: right;'>id </th>
                    <th style='text-align: right;'>مخرج التعلم للمقرر</th>
                    <th style='text-align: right;'>معرف نشاط التقييم</th>
                    <th style='text-align: right;'>النسبة من اجمالي درجة التقييم</th>
                    <th style='text-align: right;'>النسبة المتبقية</th>
                    <th style='text-align: right;'>إضافة درجة</th>
                    <th></th>
                    </tr></thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    // استعلام للحصول على النسبة المتبقية لنشاط التقييم
                    $sql_remaining_percentage = "SELECT (SELECT PercentageOfTotalGrade FROM assessmentActivities WHERE AssessmentActivityID = LearningOutcomeAssessment.AssessmentActivityID) - SUM(Percentage) AS remaining_percentage FROM LearningOutcomeAssessment WHERE AssessmentActivityID = " . $row['AssessmentActivityID'];
                    $result_remaining_percentage = $conn->query($sql_remaining_percentage);
                    $remaining_percentage = 0;
                    if ($result_remaining_percentage->num_rows > 0) {
                        $row_remaining_percentage = $result_remaining_percentage->fetch_assoc();
                        $remaining_percentage = $row_remaining_percentage['remaining_percentage'];
                    }
                    echo "<tr>
                        <td style='text-align: right;'>" . $row["ID"] . "</td>";

                    $sqlg = "SELECT * FROM learningOutcomes  where LearningOutcomeID=$row[LearningOutcomeID] ";
                    $resulth = $conn->query($sqlg);
                    while($robw = $resulth->fetch_assoc()) {

                        $sqlt = "SELECT ID, Name FROM learningoutcomecategories where ID= $robw[ID_LearningOutcomeCategories] ";
                        $resultt = $conn->query($sqlt);
                        while($rowt = $resultt->fetch_assoc()) {
                            echo "<td style='text-align: right;'>" .$rowt["Name"]  . "</td>";
                            $sqlmm = "SELECT * FROM AssessmentActivities where AssessmentActivityID =$row[AssessmentActivityID]";
                            $resultm = $conn->query($sqlmm);
                            while($rowm = $resultm->fetch_assoc()) {
                                echo "
                                    <td style='text-align: right;'>" .$rowm['ActivityName']."</td>
                                    <td style='text-align: right;'>" . $row["Percentage"] ."% </td>
                                    <td style='text-align: right;'>" . $remaining_percentage ."%</td>
                                    <td id='grade_td_" . $row["ID"] . "'>";
                                        
                                            // Check if a grade exists for this row
                                            $sql_check_grade = "SELECT * FROM grade WHERE ID = " . $row['ID'] . " AND StudentID = " . $_GET['ids'];
                                            $result_check_grade = $conn->query($sql_check_grade);
                                            if ($result_check_grade->num_rows > 0) {
                                                $grade_row = $result_check_grade->fetch_assoc();
                                                echo "<span id='grade_span_" . $row["ID"] . "'>" . $grade_row["Grade"] . "</span>";
                                            } else {
                                                echo "<form id='grade_form_" . $row["ID"] . "'>
                                                    <input type='hidden' name='id' value='" . $row["ID"] . "'>
                                                    <input type='hidden' name='ids' value='" . $_GET["ids"] . "'>
                                                    <input type='text' name='grade' placeholder='أدخل الدرجة' required>
                                                    <button type='button' class='btn btn-primary submit-grade'>إضافة</button>
                                                </form>";
                                            }
                                        ?>
                                    </td>
                                </tr><?php
                            }
                        }
                    }

}                }
       
            ?>

            
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.submit-grade').click(function(event) {
        event.preventDefault();
        var form = $(this).closest('form');
        var formData = form.serialize(); // This will include all form data including 'ids'
        var id = form.find('input[name="id"]').val();
        $.ajax({
            type: 'POST',
            url: 'insert_grade.php',
            data: formData,
            success: function(response) {
                $('#grade_td_' + id).html('<span id="grade_span_' + id + '">' + response + '</span>');
            },
            error: function(xhr, status, error) {
                console.error("Error: " + xhr.status);
            }
        });
    });
});
</script>
