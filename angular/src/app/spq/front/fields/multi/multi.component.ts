import { Component, OnInit } from "@angular/core";
import { FormGroup } from "@angular/forms";
import { FieldConfig } from "../../../model/field.interface";

@Component({
    selector: "app-multi",
    template: `
        <div [formGroup]="group">
            <input type="checkbox" [formControlName]="field.name">{{field.label}}
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
