<?php echo $quizForm->printQuizInfo() ?>
<p id="timer"></p>
<form class='spq_form' method='post'>
    <?php echo $quizForm->printQuestions() ?>
    <button type="submit" value="Submit">Submit</button>
</form>


<pre>
    <?php var_dump($quiz) ?>
</pre>