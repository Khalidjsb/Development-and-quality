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
        <th>الحاله</th>
        <th></th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["StudentID"] . "</td>";
            echo "<td>" . $row["StudentName"] . "</td>";
            echo "<td>" . $row["state"] . "</td>";
          
            if ($row["state"] == "محروم") {
                echo "<td> لا يمكن الاضافة لطالب محروم</td>";
            } else {
                // Link to add grades only if the student's state is not "محروم"
                echo "<td><a href='add_grade.php?ids=" . $row['StudentID'] . "'>اضافة درجات</a></td>";
            }
            
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'>لا توجد بيانات</td></tr>";
    }
    ?>
</table>

</body>
</html>