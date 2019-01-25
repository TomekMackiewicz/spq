import {
    ComponentFactoryResolver, 
    ComponentRef, 
    Directive, 
    Input, 
    OnInit,
    ViewContainerRef
} from "@angular/core";

import { FormGroup } from "@angular/forms";
import { FieldConfig } from "../../../model/field.interface";
import { SelectComponent } from "../select/select.component";
import { RadioComponent } from "../radio/radio.component";
import { MultiComponent } from "../multi/multi.component";

const componentMapper = {
    select: SelectComponent,
    radio: RadioComponent,
    multi: MultiComponent
};

@Directive({
    selector: '[dynamicField]'
})

export class DynamicFieldDirective implements OnInit {   
    @Input() field: FieldConfig;
    @Input() group: FormGroup;
    
    componentRef: any;

    constructor(
        private resolver: ComponentFactoryResolver,
        private container: ViewContainerRef    
    ) { }

    ngOnInit() {
        const factory = this.resolver.resolveComponentFactory(
            componentMapper[this.field.type]
        );

        this.componentRef = this.container.createComponent(factory);
        this.componentRef.instance.field = this.field;
        this.componentRef.instance.group = this.group;
    }

}