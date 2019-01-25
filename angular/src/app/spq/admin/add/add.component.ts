import { Component, OnInit } from '@angular/core';
import { CdkDragDrop, moveItemInArray, transferArrayItem } from '@angular/cdk/drag-drop';
import { FormGroup, FormControl, FormArray, FormBuilder, Validators } from '@angular/forms';
import { SpqService } from '../../spq-service';
import { AlertService } from '../../../alert/alert.service';
import { Quiz } from '../../model/quiz';
import { Question } from '../../model/question';
import { Answer } from '../../model/answer';

@Component({
    selector: 'app-admin-add',
    templateUrl: './add.component.html',
    styleUrls: ['./add.component.css']
})
export class AddComponent implements OnInit {
    
    quiz = new Quiz();
    quizForm: FormGroup;
    question = new Question();
    answer = new Answer();
    answers: FormArray;
    questions: Array<Question> = [];  
    tmpQuestions: Array<Question> = [];
    listState: Array<number> = [];
    answerListState: Array<number> = [];
    quizSubmitted: boolean = false;
    questionSubmitted: boolean = false;
    
    constructor(
        private fb: FormBuilder,
        private spqService: SpqService,
        private alertService: AlertService
    ) { }

    ngOnInit(): void {
        this.quizForm = this.createQuiz();
        this.answers = this.quizForm.get('question.answers') as FormArray;
        localStorage.removeItem('id');
    }
  
    toogleQuestionChevron(id: number): void {
        if(this.listState[id] == 1) {
            this.listState[id] = 0;
        } else {
            this.listState[id] = 1;
        }
    }

    toogleAnswerChevron(id: number): void {
        if(this.answerListState[id] == 1) {
            this.answerListState[id] = 0;
        } else {
            this.answerListState[id] = 1;
        }
    }

    addAnswer(): void {
        this.answers.push(this.createAnswer());
    }

    get f() { 
        return this.quizForm.controls; 
    }

    createQuiz(): FormGroup {
        return this.fb.group({
            title: new FormControl(
                this.quiz.title, 
                [Validators.required]
            ),
            description: new FormControl(
                this.quiz.description
            ),
            duration: new FormControl(
                this.quiz.duration, 
                [Validators.pattern("^[0-9]*$")]
            ),
            summary: new FormControl(
                this.quiz.summary
            ),
            paginated: new FormControl(
                this.quiz.paginated
            ),
            perPage: new FormControl(
                this.quiz.perPage, 
                [Validators.pattern("^[0-9]*$")]
            ),
            shuffleQuestions: new FormControl(
                this.quiz.shuffleQuestions
            ),
            shuffleAnswers: new FormControl(
                this.quiz.shuffleAnswers
            ),
            immediateAnswers: new FormControl(
                this.quiz.immediateAnswers
            ),
//            marksType: new FormControl(
//                this.quiz.marksType
//            ),
            restrictSubmissions: new FormControl(
                this.quiz.restrictSubmissions
            ),
            allowedSubmissions: new FormControl(
                this.quiz.allowedSubmissions, 
                [Validators.pattern("^[0-9]*$")]
            ),
            nextSubmissionAfter: new FormControl(
                this.quiz.nextSubmissionAfter, 
                [Validators.pattern("^[0-9]*$")]
            ),
            timeActive: new FormControl(
                this.quiz.timeActive, 
                [Validators.pattern("^[0-9]*$")]
            ),
            question: this.fb.group({
                label: new FormControl(
                    this.question.label, 
                    [Validators.required]
                ),
                description: new FormControl(
                    this.question.description
                ),
                type: new FormControl(
                    this.question.type, 
                    [Validators.required]
                ),
                hint: new FormControl(
                    this.question.hint
                ),
                isObligatory: new FormControl(
                    this.question.isObligatory
                ),                                
                answers: this.fb.array([]) 
            })            
        });
    }

    createAnswer(): FormGroup {
        return this.fb.group({
            label: new FormControl(
                this.answer.label, 
                [Validators.required]
            ),
            isCorrect: new FormControl(
                this.answer.isCorrect
            ),
            message: new FormControl(
                this.answer.message
            ),
            points: new FormControl(
                this.answer.points
            )                        
        });
    }

    addQuestion() { 
        this.questionSubmitted = true;       
//        if (this.quizForm.invalid) {
//            return;
//        } 
        //console.log(this.quizForm);
        // Assign unique ID on create question
        if (!this.question.id) {
            this.quizForm.value.question.id = Math.random().toString(36).substring(7);
        }
        
        // On create - append question, on update, replace question in array
        if (this.question.id) {
          var current = this.questions.find(x => x.id == this.question.id);
          let index = this.questions.indexOf(current);
          this.questions.splice(index, 1, this.quizForm.value.question);           
        } else {
          this.questions.push(this.quizForm.value.question);  
        }
        
//        this.quizForm.value.question.reset('');
//        Object.keys(this.questionForm.controls).forEach(key => {
//            this.questionForm.controls[key].setErrors(null)
//        });
        this.answers.controls.splice(0);
        this.question.id = '';
    }
    
    onQuizSubmit() {
        this.quizSubmitted = true;
        this.quizForm.markAsPristine();
        
        this.quiz = this.quizForm.value;
        this.quiz.questions = this.questions;
        this.quiz.id = localStorage.getItem('id');
       
        if (this.quiz.id) {
            this.spqService.updateQuiz(this.quiz).subscribe(
                data => { this.alertService.success(data, true) },
                errors => { this.alertService.error(errors.error) }
            );            
        } else {
            this.spqService.createQuiz(this.quiz).subscribe(
                data => {
                    localStorage.setItem('id', data.id);
                    this.alertService.success(data.message, true);
                },
                errors => { this.alertService.error(errors.error) }
            );            
        }
        
      
    }

  // updateTitle() {
  //   this.questionForm.title.setValue('Example title');
  // }

//    edit(event: MouseEvent, item: any) {
//        this.question = item;
//        this.quizForm = this.createQuestion();
//        this.answers = this.questionForm.get('answers') as FormArray;
//        for (let a of item.answers) {
//            this.answer = a;
//            this.addAnswer();
//        }
//    }

    cloneQuestion(event: MouseEvent, item: any) {
        this.questions.push(item);
    }    

    deleteQuestion(event: MouseEvent, list: string, index: number) {
        if (list == 'questions') {
            this.questions.splice(index, 1);
        } else if (list == 'tmpQuestions') {
            this.tmpQuestions.splice(index, 1);
        }    
    }

    deleteAnswer(event: MouseEvent, index: number) {      
        this.answers.controls.splice(index, 1);
        if (this.answers.controls.length == 0) {
            this.answers.reset();        
        }  
    }

    drop(event: CdkDragDrop<string[]>) {
        if (event.previousContainer === event.container) {
            moveItemInArray(
                event.container.data, 
                event.previousIndex, 
                event.currentIndex
            );
        } else {
            transferArrayItem(
                event.previousContainer.data,
                event.container.data,
                event.previousIndex,
                event.currentIndex
            );
        }
    }
}

