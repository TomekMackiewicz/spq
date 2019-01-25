import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { DragDropModule } from '@angular/cdk/drag-drop';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatExpansionModule } from '@angular/material/expansion';
import { MatIconModule } from '@angular/material/icon';

//import { SpqRoutingModule } from './spq-routing.module';

import { AddComponent } from './admin/add/add.component';
import { QuizComponent } from './front/quiz/quiz.component';

import { SelectComponent } from './front/fields/select/select.component';
import { RadioComponent } from './front/fields/radio/radio.component';
import { MultiComponent } from './front/fields/multi/multi.component';
import { SubmitComponent } from './front/fields/submit/submit.component'; // remove?

import { DynamicFieldDirective } from "./front/fields/dynamic-field/dynamic-field.directive";
import { DynamicFormComponent } from './front/dynamic-form/dynamic-form.component';

import { SpqService } from './spq-service';

@NgModule({
    declarations: [
        AddComponent,
        QuizComponent,
        SelectComponent,
        RadioComponent,
        MultiComponent,
        SubmitComponent,
        DynamicFieldDirective,
        DynamicFormComponent        
    ],
    imports: [
        CommonModule,
        HttpClientModule,
        BrowserModule, 
        FormsModule,
        ReactiveFormsModule, 
        DragDropModule, 
        BrowserAnimationsModule, 
        MatExpansionModule, 
        MatIconModule    
    ],
    providers: [
        SpqService
    ],
    entryComponents: [
        SelectComponent,
        RadioComponent,
        MultiComponent,
        SubmitComponent
    ]      
})
export class SpqModule { }
