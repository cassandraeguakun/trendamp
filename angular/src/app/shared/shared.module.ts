import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {Broadcaster} from './services/broadcaster';
import {AuthGuardService} from './services/auth-guard.service';
import {AuthService} from './services/auth.service';
import {UtilityService} from './services/utility.service';
import {UploaderService} from './services/uploader.service';
import {HttpClient, HttpClientModule} from '@angular/common/http';
import {SidebarComponent} from "./sidebar/sidebar";
import {RouterModule} from "@angular/router";

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
      HttpClientModule,
      RouterModule
  ],
  exports : [
    FormsModule,
    ReactiveFormsModule,
      SidebarComponent
  ],
  declarations: [
      SidebarComponent
  ],
  providers: 	[
    Broadcaster,
    AuthGuardService,
    AuthService ,
    UtilityService,
    UploaderService,
      HttpClient
  ]
})
export class SharedModule { }
