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
            
    prepareQuiz(questions: any) { // Array<Question>  
        let test: FieldConfig[] = [];     
        for (let question of questions) {
            let options: Array<string> = [];
            for (let answer of question.answers) {
                options.push(answer.title);
            }
                       
            if (question.type == 'multi') {
                test.push({ 
                    type: question.type,
                    label: question.title,
                    name: question.id,
                    options: options,
                    value: null    
                });                
            } else {
                test.push({ 
                    type: question.type,
                    label: question.title,
                    name: question.id,
                    options: options,
                    value: null     
                });                
            }
        }
        
        return test;
    }

    submit(value: any) {}
       
    getQuiz() {
        this.route.params.pipe(switchMap((params: Params) =>
            this.spqService.getQuiz(+params['id'])))
        .subscribe(
            (data: Quiz) => {
                this.quiz = data;
                this.regConfig = this.prepareQuiz(this.quiz.questions);
                //console.log(this.regConfig);
            },
            error => { 
                console.log(error) 
            }        
        );
    }
}
