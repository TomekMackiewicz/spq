import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AddComponent } from './spq/admin/add/add.component';
import { QuizComponent } from './spq/front/quiz/quiz.component';

const routes: Routes = [
    { path: 'front', component: QuizComponent },
    { path: '', component: AddComponent }   
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
