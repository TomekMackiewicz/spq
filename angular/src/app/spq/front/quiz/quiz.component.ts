import { Component, OnInit, ViewChild } from '@angular/core';

//import { Observable } from 'rxjs';
import { ActivatedRoute, Params } from '@angular/router';
import { switchMap } from 'rxjs/operators';
import { FormGroup, FormControl, FormArray, FormBuilder, Validators } from '@angular/forms';
import { SpqService } from '../../spq-service';
import { AlertService } from '../../../alert/alert.service';
import { Quiz } from '../../model/quiz';
import { Question } from '../../model/question';
import { Answer } from '../../model/answer';

import { FieldConfig } from "../../model/field.interface";
import { DynamicFormComponent } from "../dynamic-form/dynamic-form.component";

@Component({
    selector: 'app-quiz',
    templateUrl: './quiz.component.html',
    styleUrls: ['./quiz.component.css']
})

export class QuizComponent implements OnInit {
    
    @ViewChild(DynamicFormComponent) form: DynamicFormComponent; 

    quiz: Quiz;
    regConfig: FieldConfig[] = [];

    constructor(
        private route: ActivatedRoute,
        private fb: FormBuilder,
        private spqService: SpqService,
        private alertService: AlertService
    ) { }

    ngOnInit(): void {
        this.getQuiz();      
    }    
            
    prepareQuestions(questions: any) { // Array<Question>      
        for (let question of questions) {
            let options: Array<string> = [];
            for (let answer of question.answers) {
                options.push(answer.label);
            }
                                   
            this.regConfig.push({ 
                type: question.type,
                label: question.label,
                name: question.id, // quiz id, question type + rand ?
                answers: options,
                value: null     
            });
        }
    }

    submit(value: any) {}
       
    getQuiz() {
        this.route.params.pipe(switchMap((params: Params) =>
            this.spqService.getQuiz(+params['id'])))
        .subscribe(
            (data: Quiz) => {
                this.quiz = data;
                this.prepareQuestions(this.quiz.questions);
            },
            error => { 
                console.log(error) 
            }        
        );
    }
}
