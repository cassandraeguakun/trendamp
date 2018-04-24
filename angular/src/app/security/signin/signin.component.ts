import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Params, Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { AuthService } from '../../shared/services/auth.service';
import { Broadcaster } from '../../shared/services/broadcaster';
import { UtilityService } from '../../shared/services/utility.service';



@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.scss']
})
export class SigninComponent implements OnInit {

  loggingIn = false;
  redirectUrl;
  result: any;
  public form: FormGroup;
  constructor(private fb: FormBuilder,
    private router: Router,
    private authService: AuthService,
    private route: ActivatedRoute,
    private broadcaster: Broadcaster,
    private utilityService: UtilityService,
  ) { }

  ngOnInit() {
    this.form = this.fb.group({
      uname: [null, Validators.compose([Validators.required])],
      password: [null, Validators.compose([Validators.required])]
    });

    this.route.params
      .subscribe((params: Params) => {
        this.redirectUrl = params['r'];
      });
  }

    onSubmit() {

        this.utilityService.appNotify('Signing in...');

        this.authService.login(this.form.value.uname, this.form.value.password)
            .subscribe(
                token => {
                    this.loggingIn = false;
                    console.log('token from signin compo', token);

                    if (token) {
                        this.authService.getAuthUser().subscribe(
                            data => {
                                if (this.redirectUrl) localStorage.setItem('r', this.redirectUrl);
                                this.broadcaster.broadcast('USER_LOGGED_IN', data.user);

                                this.utilityService.appNotify('', false);
                            }
                        );
                    } else {
                        this.utilityService.ukNotify('Incorrect login details.', 'danger');
                        // alert('Incorrect login');
                    }
                },
                error => {
                    console.log(error);
                    this.loggingIn = false;
                    alert('Incorrect login details.');
                }
            );
    }

  signIn(provider) {

  }
}
