<?php
/**
 * Generates an HTML table with shooter information, scores, and statistics.
 *
 * This script takes input data about shooters and their scores, then outputs an HTML table
 * displaying relevant information such as shooter name, scores for each week, aggregate score,
 * number of weeks with positive scores, average score, last year's average, class, and highest score.
 * CSS classes are applied to indicate missed or changed scores in the output table.
 */
 // Start of PHP code block
    echo '
        <tr class="individual-row">
            <td>'.$number.'</td>
    ';
    // Output the table row and the first cell with the value of $number

    foreach($shooters as $name => $scores){
        // Loop through each shooter's name and scores in the $shooters array
        echo '<td>'.$name.'</td>';
        // Output a table cell with the shooter's name and exit the loop after the first iteration
        break;
    }
    foreach($shooters as $scores){
        // Loop through each shooter's scores in the $shooters array
        $wks = 0;
        // Initialize a variable to count the number of weeks with a positive score for a shooter

        for($wk=1;$wk<16;$wk++){
            // Loop through the weeks (from 1 to 15)
            echo '<td';
            // Output the opening tag of a table cell

            if($scores[$wk][2] == 1){
                // Check if the third element of the scores array for the current week is 1 (indicating a missed score)
                echo ' class="missed-score"';
                // Add a CSS class "missed-score" to the table cell
            }elseif($scores[$wk][1] == 1){
                // Check if the second element of the scores array for the current week is 1 (indicating a changed score)
                echo ' class="changed-score"';
                // Add a CSS class "changed-score" to the table cell
            }

            echo '>'.$scores[$wk][0].'</td>';
            // Output the score for the current week within the table cell
            
            if($scores[$wk][0] > 0){
                // Check if the score for the current week is greater than 0
                $wks++;
                // Increment the count of weeks with a positive score
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
        // Output the aggregate, number of weeks with positive scores, average, last year's average, class, and highest score for the shooter within the table row
    }
?>