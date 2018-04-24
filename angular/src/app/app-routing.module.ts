import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import {AuthGuardService} from './shared/services/auth-guard.service';
import {HomePageComponent} from './home-page/home-page.component';
import {AppLayoutComponent} from './app-layout-component/app-layout-component.component';

const appRoutes: Routes = [

    {
        path: '',
        component: AppLayoutComponent,
        canActivate: [AuthGuardService],
        children: [
            // {
            //     path: '',
            //     component: HomePageComponent,
            // },
            {
                path: '',
                loadChildren: './dashboard/dashboard.module#DashboardModule'
            }
        ]
    },
    {
        path: '',
        redirectTo: '/',
        pathMatch: 'full'
    },

];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forRoot(appRoutes),
  ],
  exports : [
    RouterModule
  ],
  declarations: []
})
export class AppRoutingModule { }
