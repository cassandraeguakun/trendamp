import { Injectable, Injector } from '@angular/core';
import { HttpEvent, HttpInterceptor, HttpHandler, HttpRequest } from '@angular/common/http';
// import { Observable } from 'rxjs/Rx';
import 'rxjs/add/observable/throw';
import 'rxjs/add/operator/catch';
import {Observable} from 'rxjs/Observable';
import {Broadcaster} from './shared/services/broadcaster';


@Injectable()
export class MyHttpInterceptor implements HttpInterceptor {
    constructor(private broadcaster: Broadcaster) { }

    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {

        // INTERCEPTED REQUEST
        this.broadcaster.broadcast('REQUESTING_SERVER', {
            loading : true,
            message : 'sending request....'
        });

        const token = localStorage.getItem('authToken');
        var custom_headers: any;

        if(token) {
            custom_headers  = {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token,
            };

        } else {
            custom_headers  = {
                'Content-Type': 'application/json',
            };
        }

        // Clone the request to add the new header.
        const authReq = req.clone({
            setHeaders: custom_headers
        });



        // todo: Sending request with new header now ...

        // send the newly created request
        return next.handle(authReq)
            .catch((error, caught) => {
                console.log(error);
                // return the error to the method that called it
                return Observable.throw(error);
            }) as any;
    }
}