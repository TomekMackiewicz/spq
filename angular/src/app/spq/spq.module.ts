import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';
import { BrowserModule } from '@angular/platform-browser';
import { ReactiveFormsModule } from '@angular/forms';
import { DragDropModule } from '@angular/cdk/drag-drop';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatExpansionModule } from '@angular/material/expansion';
import { MatIconModule } from '@angular/material/icon';

//import { SpqRoutingModule } from './spq-routing.module';

import { SpqComponent } from './spq/spq.component';
import { SpqService } from './spq/spq-service';

@NgModule({
  declarations: [SpqComponent],
  imports: [
    CommonModule,
    HttpClientModule,
    BrowserModule, 
    ReactiveFormsModule, 
    DragDropModule, 
    BrowserAnimationsModule, 
    MatExpansionModule, 
    MatIconModule    
  ],
    providers: [
        SpqService
    ]  
})
export class SpqModule { }
