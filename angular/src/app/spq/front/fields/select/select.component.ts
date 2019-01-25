import { Component, OnInit } from "@angular/core";
import { FormGroup } from "@angular/forms";
import { FieldConfig } from "../../../model/field.interface";

@Component({
    selector: "app-select",
    template: `
        <div [formGroup]="group">
            <select [formControlName]="field.name">
                <option value="" disabled selected>Type</option>
                <option *ngFor="let item of field.answers" [value]="item">{{item}}</option>
            </select>
        </div>
    `,
    styles: []
})

export class SelectComponent implements OnInit {
    field: FieldConfig;
    group: FormGroup;

    constructor() {}

    ngOnInit() {}
}
