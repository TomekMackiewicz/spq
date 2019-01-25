import { Component, EventEmitter, Input, OnChanges, OnInit, Output } from "@angular/core";
import { FormGroup, FormBuilder, Validators, FormControl } from "@angular/forms";
import { FieldConfig, Validator } from "../../model/field.interface";

@Component({
    exportAs: "dynamicForm",
    selector: "dynamic-form",
    template: `
        <form [formGroup]="form" (submit)="onSubmit($event)">
            <ng-container *ngFor="let field of fields;" dynamicField [field]="field" [group]="form">
            </ng-container>
        </form>
    `
})

export class DynamicFormComponent implements OnInit {

    @Input() fields: FieldConfig[] = [];

    @Output() submit: EventEmitter<any> = new EventEmitter<any>();

    form: FormGroup;
    
    constructor(private fb: FormBuilder) {}    

    ngOnInit() {
        this.form = this.createControl();
    }

    get value() {
        return this.form.value;
    }    

    createControl() {
        const group = this.fb.group({});
        this.fields.forEach(field => {
            if (field.type === "button") return;

            const control = this.fb.control(
                field.value,
                this.bindValidations(field.validations || [])
            );

            group.addControl(field.name, control);
        });

        return group;
    }    

    bindValidations(validations: any) {
        if (validations.length > 0) {
            const validList = [];

            validations.forEach(valid => {
                validList.push(valid.validator);
            });

            return Validators.compose(validList);
        }

        return null;
    } 
    
    onSubmit(event: Event) {
        event.preventDefault();
        event.stopPropagation();

        if (this.form.valid) {
            this.submit.emit(this.form.value);
        } else {
            this.validateAllFormFields(this.form);
        }
    }       

    validateAllFormFields(formGroup: FormGroup) {
        Object.keys(formGroup.controls).forEach(field => {
            const control = formGroup.get(field);
            control.markAsTouched({ onlySelf: true });
        });
    }    
                        
}