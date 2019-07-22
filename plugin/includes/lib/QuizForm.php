<?php

class QuizForm
{
    private $quiz;
    
    public function __construct($quiz)
    {
        $this->quiz = $quiz;
    }

    public function printQuizInfo()
    {
        $output = '<h2>'.$this->quiz->title.'</h2>';
        $output .= '<p>'.$this->quiz->description.'</p>';
        
        return $output;
    }
    
    public function printQuestions()
    {
        if ($this->quiz->shuffle_questions) {
            shuffle($this->quiz->questions);
        }
        $output = '';
        foreach ($this->quiz->questions as $question) { 
            $output .= $this->printQuestionHeader($question);
            switch ($question['type']) {
                case 'radio':
                    $output .= $this->printRadioAnswers($question['answers'], $question["id"]);
                    break;
                case 'multi':
                    $output .= $this->printMultiAnswers($question['answers'], $question["id"]);
                    break;
                default:
                    $output = 'Invalid question type';
                    break;
            }
        }

        return $output;
    }

    private function printQuestionHeader($question)
    {
        $output = '<h3>'.$question['label'].'</h3>';
        $output .= '<p>'.$question['description'].'</p>';
        $output .= '<p><small>'.$question['hint'].'</small></p>';
        
        return $output;
    }

    private function printRadioAnswers($answers, $name) 
    {
        if ($this->quiz->shuffle_answers) {
            shuffle($answers);
        }
        foreach ($answers as $key => $answer) {
            $output .= '<p><label><input type="radio" name="'.$name.'" value="'.$key.'"> '.$answer["label"].'</label></p>';
        }
        
        return $output;
    }

    private function printMultiAnswers($answers, $name) 
    {
        if ($this->quiz->shuffle_answers) {
            shuffle($answers);
        }
        foreach ($answers as $key => $answer) {
            $output .= '<p><label><input type="checkbox" name="'.$name.'" value="'.$key.'"> '.$answer["label"].'</label></p>';
        }

        return $output;
    }
    
}

$quizForm = new QuizForm($quiz);