import {Component, OnInit} from '@angular/core';
import {Broadcaster} from './shared/services/broadcaster';
import {Router} from '@angular/router';
import {UtilityService} from './shared/services/utility.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit{
  title = 'app';

  authUser;
  appLoader = {
    loading: false,
    message: 'loading...'
  };

    constructor(private broadcaster: Broadcaster, private router: Router, private utilityService: UtilityService) {
    }

    ngOnInit(){
        this.broadcaster.on('APP_LOADER').subscribe(
            (data: AppLoader) => {
                this.appLoader.loading = data.loading;
                this.appLoader.message  =  data.message;
            }
        );

        this.broadcaster.on('USER_LOGGED_IN').subscribe(
            (user: any) => {
                const redirectUrl = localStorage.getItem('r');

                if(redirectUrl) {
                    this.router.navigateByUrl(redirectUrl);
                    localStorage.removeItem('r');
                } else {
                    this.router.navigate(['/app/dashboard']);
                    this.utilityService.ukNotify('Welcome ' + user.fullName);
                    this.authUser = user;
                }
            }
        );

        this.broadcaster.on('USER_LOGGED_OUT').subscribe(
            () => {
                this.utilityService.appNotify('You are logged out!');
                window.location.href = '/';
                // this.router.navigate(['/security/signin']);

            }
        );

    }
}

export interface AppLoader {
  loading: boolean;
  message: string;
}
