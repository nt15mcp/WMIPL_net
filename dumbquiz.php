<!DOCTYPE html>
<html lang="fr"> 
    <head> 
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Quizz PHP</title> 
        <style> 
            body { background-color: #cfe2f3; /* Fond bleu clair */ font-family: Arial, sans-serif; margin: 20px; }

            form { margin-bottom: 20px;  }
        </style>
    </head> 
    <body>

    <?php 
        // Fonction pour afficher le formulaire de nom/prénom 
        function displayNameForm() { 
            echo "<form method='post' action='quizz.php'>"; 
            echo "<label for='firstname'>Prénom:</label>"; 
            echo "<input type='text' name='firstname' required>"; 
            echo "<br>"; 
            echo "<label for='lastname'>Nom:</label>"; 
            echo "<input type='text' name='lastname' required>"; 
            echo "<br>"; 
            echo "<button type='submit'>Commencer le quizz</button>"; 
            echo "</form>"; 
        } 
        // Fonction pour afficher le formulaire du quizz 
        function displayQuestion($questionNumber, $question, $type, $options = array()) { 
            echo "<h3>Question $questionNumber:</h3>"; 
            echo "<p>$question</p>"; 
            echo "<form method='post' action='quizz.php'>"; 
            if ($type === 'text') { 
                echo "<input type='text' name='q$questionNumber_answer'>"; 
            } elseif ($type === 'select') { 
                echo "<select name='q$questionNumber_answer'>"; 
                foreach ($options as $option) { 
                    echo "<option value='$option'>$option</option>"; 
                } 
                echo "</select>"; 
            } elseif ($type === 'radio') { 
                foreach ($options as $value => $label) { 
                    echo "<input type='radio' name='q$questionNumber_answer' value='$value'>$label "; 
                } 
            } elseif ($type === 'checkbox') { 
                foreach ($options as $value => $label) { 
                    echo "<input type='checkbox' name='q$questionNumber_answer' value='$value'>$label "; 
                } 
            } 
            echo "</form>"; 
        } 
        // Fonction pour afficher le bouton "Répondre" à la fin 
        function displaySubmitButton() { 
            echo "<form method='post' action='quizz.php'>"; 
            echo "<button type='submit' name='submit'>Répondre</button>"; 
            echo "</form>"; 
        } 
        // Variables pour le nom, le prénom et le score 
        $firstname = isset($_COOKIE['firstname']) ? $_COOKIE['firstname'] : ''; 
        $lastname = isset($_COOKIE['lastname']) ? $_COOKIE['lastname'] : ''; 
        $score = isset($_COOKIE['score']) ? $_COOKIE['score'] : 0; 
        // Page 1: Saisie du nom et du prénom 
        if (empty($firstname) || empty($lastname)) { 
            displayNameForm(); 
        } 
        // Page 2: Rappel de l'ancien score et quizz si les cookies sont présents 
        elseif ($score > 0) { 
            echo "<h1>Bienvenue de nouveau, $firstname $lastname !</h1>"; 
            echo "<p>Votre score précédent était : $score / 4</p>"; 
            echo "<p>Vous pouvez réessayer le quizz :</p>"; 
            // Questions 
            $questions = array( 
                array("Combien de continents y a-t-il sur Terre ?", 'text'), 
                array("Quelle est la capitale de la France ?", 'select', array('Paris', 'Londres', 'Berlin')), 
                array("Quelle est la réponse à la vie, l'univers et tout le reste ?", 'radio', array('42' => '42', '24' => '24', '12' => '12')), 
                array("Quel est le plus grand océan sur Terre ?", 'checkbox', array('pacific' => 'Pacifique', 'atlantic' => 'Atlantique', 'indian' => 'Indien')), 
                ); 
                // Afficher le formulaire du quizz 
                foreach ($questions as $index => $questionData) { 
                    displayQuestion($index + 1, $questionData[0], $questionData[1], isset($questionData[2]) ? $questionData[2] : array());
                } 
                // Afficher le bouton "Répondre" à la fin 
                displaySubmitButton(); 
        } 
        // Page 3: Afficher le quizz directement si les cookies sont absents 
        else { 
            echo "<h1>Bienvenue $firstname $lastname !</h1>"; 
            echo "<p>Commencez le quizz :</p>"; 
            // Questions 
            $questions = array( 
                array("Combien de continents y a-t-il sur Terre ?", 'text'), 
                array("Quelle est la capitale de la France ?", 'select', array('Paris', 'Londres', 'Berlin')), 
                array("Quelle est la réponse à la vie, l'univers et tout le reste ?", 'radio', array('42' => '42', '24' => '24', '12' => '12')), 
                array("Quel est le plus grand océan sur Terre ?", 'checkbox', array('pacific' => 'Pacifique', 'atlantic' => 'Atlantique', 'indian' => 'Indien')), 
            ); 
            // Afficher le formulaire du quizz 
            foreach ($questions as $index => $questionData) { 
                displayQuestion($index + 1, $questionData[0], $questionData[1], isset($questionData[2]) ? $questionData[2] : array()); 
            } 
            // Afficher le bouton "Répondre" à la fin 
            displaySubmitButton(); 
        } 
        // Vérifier les réponses après soumission 
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) { 
            // Vérifier si les cookies du nom/prénom existent 
            if (empty($firstname) || empty($lastname)) { 
                // Si les cookies du nom/prénom n'existent pas, les créer 
                setcookie('firstname', $_POST['firstname'], time() + (86400 * 30), "/"); 
                // 86400 = 1 jour 
                setcookie('lastname', $_POST['lastname'], time() + (86400 * 30), "/"); 
                // Rediriger pour éviter la réémission du formulaire 
                header("Location: quizz.php"); 
                exit(); 
            } 
            // Vérifier les réponses et calculer le score 
            $score = 0; 
            foreach ($questions as $index => $questionData) { 
                $questionNumber = $index + 1; 
                $answerKey = "q$questionNumber" . ($questionData[1] === 'checkbox' ? '_answer' : '_answer'); 
                $userAnswer = isset($_POST[$answerKey]) ? $_POST[$answerKey] : ''; 
                // Vérifier la réponse 
                if ($questionData[1] === 'checkbox') { 
                    $correctAnswers = isset($questionData[2]) ? array_keys($questionData[2]) : array(); 
                    if (count(array_diff($userAnswer, $correctAnswers)) === 0) { 
                        $score++; 
                    } 
                } else { 
                    $correctAnswer = strtolower($questionData[2]); 
                    if (strtolower($userAnswer) === $correctAnswer) { 
                        $score++; 
                    } 
                } 
            } 
            // Enregistrer le score dans un cookie 
            setcookie('score', $score, time() + (86400 * 30), "/"); 
            // 86400 = 1 jour 
            // Rediriger pour éviter la réémission du formulaire 
            header("Location: quizz.php"); 
            exit(); 
        } 
    ?>

    </body> 
</html>