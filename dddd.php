
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
    table tr td{
        border: 1px solid black;

    }
    .m{
        background-color: cadetblue;
    }
</style>
<body>









<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>بيانات الجامعة</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    font-weight: bold;
  }

  </style>
</head>
<body dir="rtl">
  <?php include "header.php";?>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h2 class="mb-4">بيانات الجامعة</h2>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>اسم الجامعة</th>
                <th>اسم الكلية</th>
                <th>معلومات عن الجامعة</th>
                <th>الدرجة</th>
                <th>البرنامج</th>
                <th>رقم المقرر</th>
                <th>رمز المقرر</th>
                <th>اسم المقرر</th>
                <th>رقم الشعبة</th>
              </tr>
            </thead>
            <tbody>
              <?php

include"connn.php";       
       $query = mysqli_query($conn, "SELECT * FROM university LIMIT 1"); // يفترض أنك تحتاج فقط إلى صف واحد لملء النموذج
              $data = mysqli_fetch_assoc($query);
              ?>
              <tr>
                <td><?php echo $data['university_name']; ?></td>
                <td><?php echo $data['college_name']; ?></td>
                <td><?php echo $data['body']; ?></td>
                <td><?php echo $data['degree']; ?></td>
                <td><?php echo $data['program']; ?></td>
                <td><?php echo $data['course_number']; ?></td>
                <td><?php echo $data['course_code']; ?></td>
                <td><?php echo $data['course_name']; ?></td>
                <td><?php echo $data['section_number']; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<!-- Bootstrap JS (optional, for certain Bootstrap components) -->












<?php

include "connn.php";

$sql = "SELECT * FROM AssessmentActivities"; // Query only the AssessmentActivities table
$result = $conn->query($sql);
if ($result->num_rows > 0) {
?>
<div class="container mt-5">
    <h4 align="center" class="mb-4">توزيع درجات أنشطة التقييم</h4> 
    <div class="row justify-content-center">
        <div class="col-md-4" style='padding: 0;'>
            <div id="responseMessage" class="mt-3">
                <?php
                    echo "<table border='1'>";
                    echo "<tbody>";

                    // Display activity names
                    echo "<tr style='background-color: #12703d;color:white'>";
                    while ($rowm = mysqli_fetch_assoc($result)) {
                        echo "<td>{$rowm['ActivityName']}</td>"; 
                    }
                    echo "</tr>";

                    // Display percentages beneath activity names
                    echo "<tr style='background-color:#c9e059;'>";
                    $result->data_seek(0); // Reset pointer to fetch the data again from the beginning
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<td>{$row['PercentageOfTotalGrade']}%</td>"; 
                    } 
                    echo "</tr>";

                    // Fetch percentages from LearningOutcomeAssessment table
                    $sqlt = "SELECT * FROM AssessmentActivities"; // Query only the AssessmentActivities table
                    $resultt = $conn->query($sqlt);
                    while ($roww = mysqli_fetch_array($resultt)) {
                ?>
                        <td>
                            <table>
                                <?php 
                                $saql = "SELECT * FROM LearningOutcomeAssessment where AssessmentActivityID= $roww[AssessmentActivityID]";
                                $aresult = $conn->query($saql);
                                while ($arow = $aresult->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td style='text-align: right;'><?php echo $arow["Percentage"]; ?>%</td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                <?php 
                    }
                ?>
                    </tr>
                <?php
                    echo "</tbody>";
                    echo "</table>";
                ?>
         
 
<?php
} else {
    echo "No data found";
}
?>

</div></div>
<div class="col-md-4" style='    padding: 0;'>
<table dir="rtl" border="1">

<tr style=' background-color: #12703d;'>  . </tr>

<tr >
<h4 style='    padding: 25px;
    background-color: #12703d;
    color: white;margin-bottom: .0rem;margin: top 4px;
'>انشطةالتقييم</h4>

</tr>

<?php
include "connn.php";

$sqlt = "SELECT ID, Name FROM learningoutcomecategories";
$resultt = $conn->query($sqlt);
?>

    <tr style='  background-color: #12703d;color:white'> <td>coed</td>
   <td>المخرج التعليمي للمقرر الدراسي </td> </tr>
<?php
     while($rowt = $resultt->fetch_assoc()) {
        echo " <tr class='m'><td>". $rowt['ID']."</td> <td>" .    $rowt["Name"]. "</td><tr>";

    $sql = "SELECT * FROM learningOutcomes where  ID_LearningOutcomeCategories= $rowt[ID] ";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<tr><td>" . $row["LearningOutcomeID"] . "</td>";


       
$sqltl = "SELECT ID, Name FROM learningoutcomecategories where ID= $row[ID_LearningOutcomeCategories] ";
$resulttl = $conn->query($sqltl);

     while($rowtl = $resulttl->fetch_assoc()) {

            echo "<td>" .    $rowtl["Name"]. "</td>";
    

    //        $sqlkk = "SELECT * FROM AssessmentActivities";
          //  $resultkk = $conn->query($sqlkk);    
        //    while($rowx = $resultkk->fetch_assoc()) {
      //     $saql = "SELECT * FROM LearningOutcomeAssessment where AssessmentActivityID= $rowx[AssessmentActivityID] ";

          //  $saql = "SELECT * FROM LearningOutcomeAssessment where LearningOutcomeID= $row[LearningOutcomeID] ";
            //$aresult = $conn->query($saql);
            
            //while ($arow= $aresult->fetch_assoc()) {
            ?>
    <?php
            }
    

            
            echo " </tr>";
     }
        
    echo "</tr>";}

      
       ?></table>

<br>       
<a href="add_stusdents.php" class="btn btn-primary">ادارة الطلاب  والدرجات</a>
<a href="dddd.php" class="btn btn-primary"> توزيع درجات أنشطة التقييم </a>
       </div>

</div></div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
