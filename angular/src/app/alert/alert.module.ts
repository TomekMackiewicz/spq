import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AlertComponent } from './alert.component';
import { AlertService } from './alert.service';
import { HttpClientModule } from '@angular/common/http';

@NgModule({
    imports: [
        CommonModule,
        HttpClientModule       
    ],
    declarations: [
        AlertComponent
    ],
    providers: [
        AlertService
    ],
    exports: [
        AlertComponent
    ]
})

export class AlertModule {}
