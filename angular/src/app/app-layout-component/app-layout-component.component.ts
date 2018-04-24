import { Component, OnInit, OnDestroy} from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { Subscription } from 'rxjs/Subscription';
import 'rxjs/add/operator/filter';
import {AuthService} from '../shared/services/auth.service';

@Component({
  selector: 'app-layout',
  templateUrl: './app-layout-component.component.html',
  styleUrls: ['./app-layout-component.component.scss']
})
export class AppLayoutComponent implements OnInit, OnDestroy {

  private _router: Subscription;

  constructor (
    private router: Router,
    private route: ActivatedRoute,
    private authService: AuthService) {

  }

  ngOnInit(): void {
  }

  ngOnDestroy() {
    this._router.unsubscribe();
  }


  logout() {
    this.authService.logout();
  }
}
