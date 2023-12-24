<?php
    echo '
        <tr>
            <td>'.$number.'</td>
            <td>'.$person.'</td>
    ';
    foreach($scores as $wk => $values){
        echo '<td';
        if($values[1] == 1){
            ' class="missed-score"';
        }
        echo '>'.$scores[0].'</td>';
    }
    echo '
            <td>agg</td>
            <td>wks</td>
            <td>avg</td>
            <td>lya</td>
            <td>cl</td>
            <td>high</td>
        </tr>
    ';
?>