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

?>