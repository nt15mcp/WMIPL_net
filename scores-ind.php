<?php
    echo '
        <tr>
            <td>'.$number.'</td>
    ';
    foreach($shooters as $name => $scores){
        echo '<td>'.$name.'</td>';
        break;
    }
    foreach($shooters as $scores){
        $wks = 0;
        for($wk=1;$wk<16;$wk++){
            echo '<td';
            if($scores[$wk][1] == 1){
                ' class="missed-score"';
            }
            echo '>'.$scores[$wk][0].'</td>';
            if($scores[$wk][0] > 0){
                $wks++;
            }
        }
        echo '
            <td>'.$scores['agg'].'</td>
            <td>'.$wks.'</td>
            <td>'.number_format($scores['avg'],1,'.','').'</td>
            <td>'.number_format($scores['lya'],1,'.','').'</td>
            <td>'.$scores['class'].'</td>
            <td>'.$scores['high'].'</td>
        </tr>
    ';
    }
    
?>