import { Injectable } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/catch';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/do';
import { Router } from '@angular/router';
import { UtilityService } from './utility.service';
import { Broadcaster } from './broadcaster';
import {HttpClient} from '@angular/common/http';
import {AppConfig} from '../AppConfig';

@Injectable()
export class AuthService {

  constructor(private http: HttpClient, private router: Router,
    private utilityService: UtilityService,
    private broadcaster: Broadcaster) {

  }

  logout() {
    this.utilityService.appNotify('Signing out...');
    return this.http.post(AppConfig.serverApi + '/account/logout', {})
      .map(
      (response: any) => {
        if (response.ok) {
          return response.json();
        }
      }
      ).catch(
      (error) => { return Observable.throw(error); }
      )
      .subscribe(
      () => {
        localStorage.clear();
        this.broadcaster.broadcast('USER_LOGGED_OUT');
        // this.utilityService.appNotify('', false);
      }
      );

  }

  isLoggedIn(): boolean {
    if (localStorage.getItem('authToken')) return true;
    return false;
  }

    login(username: string, password: string): Observable<any> {
        return this.http.post(AppConfig.serverApi + '/account/login',
            { email: username.length ? username : null, password: password.length ? password : null })
            .map(
                (response: any) => {
                  console.log('logged in response', response);

                    const token = response.access_token;
                    if (token) {
                        // set auth token
                        this.setAuthToken(token);

                        return token;
                    }
                }
            ).catch(
                (error) => { return Observable.throw(error); }
            );
    }

    getAuthUser(): Observable<any> {
        // check if we have a user object in local storage
        const token = this.getAuthToken();

        if (token) {
            const user = this.decodeToken(token);

            return new Observable(
                observer => {
                    observer.next(user);
                }
            );
        } else {
            // user has not been logged in (no auth token found)
            return Observable.throw('Guest user!');
        }
    }

  getAuthToken() {
    return localStorage.getItem('authToken');
  }

  setAuthToken(token) {
    localStorage.setItem('authToken', token);
  }

  decodeToken(token: any) {
    if (token) {
      const base64Url = token.split('.')[1];
      const base64 = base64Url.replace('-', '+').replace('_', '/');
      return JSON.parse(window.atob(base64));
    }

    return null;
  }
}
