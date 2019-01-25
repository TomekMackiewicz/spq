import { Component, OnInit } from "@angular/core";
import { FormGroup } from "@angular/forms";
import { FieldConfig } from "../../../model/field.interface";
@Component({
    selector: "app-submit",
    template: `
        <div [formGroup]="group">
            <button type="submit">{{field.label}}</button>
        </div>
  `,
    styles: []
})
export class SubmitComponent implements OnInit {
    field: FieldConfig;
    group: FormGroup;
    constructor() {}
    ngOnInit() {}
}

