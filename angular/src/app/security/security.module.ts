import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SecurityComponent } from './security-component/security-component.component';
import {SharedModule} from '../shared/shared.module';
import {SecurityRoutingModule} from './security-routing.module';
import {SigninComponent} from './signin/signin.component';

@NgModule({
  imports: [
    CommonModule,
    SharedModule,
    SecurityRoutingModule
  ],
  declarations: [
    SecurityComponent,
    SigninComponent
  ]
})
export class SecurityModule { }
