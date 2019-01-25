import { Component, OnInit } from "@angular/core";
import { FormGroup } from "@angular/forms";
import { FieldConfig } from "../../../model/field.interface";

@Component({
    selector: "app-radio",
    template: `
        <div [formGroup]="group">
            <label>{{field.label}}:</label>
            <div *ngFor="let item of field.options">
                <input type="radio" [formControlName]="field.name" [value]="item">
                    {{item}}
            </div>
        </div>
    `,
    styles: []
})

export class RadioComponent implements OnInit {
    field: FieldConfig;
    group: FormGroup;
    
    constructor() {}

    ngOnInit() {}
}

//        <div [formGroup]="group">
//            <label>{{field.label}}:</label>
//            <mat-radio-group [formControlName]="field.name">
//                <mat-radio-button *ngFor="let item of field.options" [value]="item">
//                    {{item}}
//                </mat-radio-button>
//            </mat-radio-group>
//        </div>