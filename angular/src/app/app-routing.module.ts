import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { SpqComponent } from './spq/spq/spq.component';

const routes: Routes = [
    //{ path: '', redirectTo: 'admin.php/:page', pathMatch: 'full' },
    { path: '', component: SpqComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
