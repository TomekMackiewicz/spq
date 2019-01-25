import { Component, OnInit } from "@angular/core";
import { FormGroup } from "@angular/forms";
import { FieldConfig } from "../../../model/field.interface";

@Component({
    selector: "app-multi",
    template: `
        <div [formGroup]="group">
            <label>{{field.label}}</label>
            <div *ngFor="let item of field.options">
                <input type="checkbox" [formControlName]="field.name">{{item}}
            </div>
        </div>
    `,
    styles: []
})

export class MultiComponent implements OnInit {
    field: FieldConfig;
    group: FormGroup;

    constructor() {}

    ngOnInit() {}
}
