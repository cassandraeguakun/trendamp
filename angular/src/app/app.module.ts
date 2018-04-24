import { AppRoutingModule } from './app-routing.module';
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import {NgbModule} from '@ng-bootstrap/ng-bootstrap';

import { AppComponent } from './app.component';
import {SharedModule} from './shared/shared.module';
import {SecurityModule} from './security/security.module';
import {HomePageComponent} from './home-page/home-page.component';
import {AppLayoutComponent} from './app-layout-component/app-layout-component.component';
import {HTTP_INTERCEPTORS} from '@angular/common/http';
import {MyHttpInterceptor} from './http.interceptor';
import {Broadcaster} from "./shared/services/broadcaster";


@NgModule({
  declarations: [
      AppComponent,
      HomePageComponent,
      AppLayoutComponent
  ],
  imports: [
      BrowserModule,
      AppRoutingModule,
      SharedModule,
      SecurityModule,
      NgbModule.forRoot()
  ],
  providers: [
      {
          provide: HTTP_INTERCEPTORS,
          useClass: MyHttpInterceptor,
          multi: true,
          deps: [Broadcaster]
      }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
