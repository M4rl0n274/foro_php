<?php
include 'connect.php';
include 'header.php';

echo `<tr>`;
    echo '<td class="leftpart">';
        echo '<h3><a href = "category.php?id=">category name</a></h3> category description goes here';
    echo '</td>';
    echo '<td class="rightpart">';
            echo '<a href= "topic.php"?id=">Topic subject</a> at 10-10';
    echo '</td>';
echo '</tr>';
include '../views/footer.php';

?>

