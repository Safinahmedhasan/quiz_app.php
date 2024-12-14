<?php
class Question {
    public string $text;
    public string $correctAnswer;

    public function __construct(string $text, string $correctAnswer) {
        $this->text = $text;
        $this->correctAnswer = strtolower(trim($correctAnswer));
    }
}

function evaluateQuiz(array $questions, array $answers): int {
    if (count($questions) !== count($answers)) {
        throw new InvalidArgumentException(
            "Number of answers must match number of questions"
        );
    }

    $score = 0;
    foreach ($questions as $index => $question) {
        if (!($question instanceof Question)) {
            throw new InvalidArgumentException(
                "All questions must be Question objects"
            );
        }
        
        $userAnswer = strtolower(trim($answers[$index]));
        if ($userAnswer === $question->correctAnswer) {
            $score++;
        }
    }
    
    return $score;
}

function runQuiz(array $questions): array {
    $answers = [];
    
    echo "Welcome to the Quiz!\n";
    echo "Answer each question and press Enter.\n\n";
    
    foreach ($questions as $index => $question) {
        $questionNumber = $index + 1;
        echo "Question {$questionNumber}: {$question->text}\n";
        echo "Your answer: ";

        $answer = trim(fgets(STDIN));
        $answers[] = $answer;
        
        echo "\n";
    }
    
    return $answers;
}

function displayResults(int $score, int $total): void {
    $percentage = ($score / $total) * 100;
    
    echo "Quiz Complete!\n";
    echo "Your Score: {$score}/{$total} ({$percentage}%)\n\n";
    
    if ($percentage >= 90) {
        echo "Excellent work! Outstanding performance!\n";
    } elseif ($percentage >= 70) {
        echo "Good job! You did well!\n";
    } elseif ($percentage >= 50) {
        echo "Not bad, but there's room for improvement.\n";
    } else {
        echo "You might want to study more and try again.\n";
    }
}

$quizQuestions = [
    new Question("What is the capital of France?", "paris"),
    new Question("Which planet is known as the Red Planet?", "mars"),
    new Question("What is 2 + 2?", "4")
];

$userAnswers = runQuiz($quizQuestions);

try {
    $score = evaluateQuiz($quizQuestions, $userAnswers);
    displayResults($score, count($quizQuestions));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Second 
$questions = [
    ['question' => 'What is 2 + 2?', 'correct' => '4'],
    ['question' => 'What is the capital of France?', 'correct' => 'Paris'],
    ['question' => 'Who wrote "Hamlet"?', 'correct' => 'Shakespeare'],
];


function collectAnswers($questions) {
    $answers = [];
    foreach ($questions as $index => $question) {
        echo ($index + 1) . ". " . $question['question'] . "\n";
        echo "Your answer: ";
        $answers[] = trim(readline());
    }
    return $answers;
}


function assessQuiz($questions, $answers) {  
    $score = 0;
    foreach ($questions as $index => $question) {
        if (strtolower($answers[$index]) === strtolower($question['correct'])) {
            $score++;
        }
    }
    return $score;
}


function provideFeedback($score, $total) {
    echo "You scored $score out of $total.\n";
    
    if ($score === $total) {
        echo "Excellent job!\n";
    } elseif ($score > $total / 2) {
        echo "Good effort!\n";
    } else {
        echo "Better luck next time!\n";
    }
}

$answers = collectAnswers($questions);
$score = assessQuiz($questions, $answers);  
provideFeedback($score, count($questions));

?>


