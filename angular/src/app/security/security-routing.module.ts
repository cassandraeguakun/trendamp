import {RouterModule, Routes} from '@angular/router';
import {NgModule} from '@angular/core';
import {SecurityComponent} from "./security-component/security-component.component";
import {SigninComponent} from "./signin/signin.component";

const securityRoutes: Routes = [
  {
    path: 'security',
    component: SecurityComponent,
    children: [
      {
        path: 'signin',
        component: SigninComponent
      },
    ]
  },

];

@NgModule({
  imports: [
    RouterModule.forChild(securityRoutes)
  ],
  exports: [
    RouterModule
  ]
})
export class SecurityRoutingModule { }
