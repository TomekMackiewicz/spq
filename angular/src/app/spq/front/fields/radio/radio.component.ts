import { Component, OnInit } from "@angular/core";
import { FormGroup } from "@angular/forms";
import { FieldConfig } from "../../../model/field.interface";

@Component({
    selector: "app-radio",
    template: `
        <div [formGroup]="group">
            <label>{{field.label}}</label>
            <div *ngFor="let item of field.answers">
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
