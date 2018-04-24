import { Injectable } from '@angular/core';
import {Subject} from 'rxjs/Subject';
import {Broadcaster} from './broadcaster';
import {HttpClient} from '@angular/common/http';

declare var UIkit: any;
declare var _: any;

@Injectable()
export class UtilityService {

  constructor(private http: HttpClient, private broadcaster: Broadcaster) { }

  appNotify(message: string, show: boolean = true) {
    this.broadcaster.broadcast('APP_LOADER', {
      loading : show,
      message : message
    });
  }

  ukNotify(message: string, type: string = 'success') {
    UIkit.notification.closeAll();

    UIkit.notification({
      message : message,
      status: type,
      pos: 'top-center',
      timeout: 5000
    });
  }

  public getAuthUser(){
    let user: any = localStorage.getItem('authUser');

    if(user){
      user = JSON.parse(user);

      if(user.id) {
        return user;
      }
    }

    return null;
  }

  public getLocation(){
    const locationObservable = new Subject();
    const nav = navigator.geolocation;

    locationObservable.next(null);

    if (nav) {
      navigator.geolocation.getCurrentPosition((coord) => {
        locationObservable.next(coord);
      });
    }

    return locationObservable.asObservable();
  }

  public byteToMB(byte: number){
    return _.round((byte / 1024 / 1024), 2);
  }

  getUserByUsername(username: any) {
    return this.http.get('/users/find-username/' + username)
      .map((response: any) => {
        if(response.ok) {
          return response.json();
        }
      })
      .catch((error) => {
        return error;
      })
      ;
  }

  updateUserBasicProfile(user){
    return this.http.post('/users/update-basic-profile', user)
      .map(
        (response: any) => {
          const res = response.json();

          if(res.id){
            return res;
          }
        }
      ).catch(
        error => { return error; }
      );
  }

  requestExternalUrl(url: string, method: string = 'post', data?: Array<Object>){
    const requestSubject = new Subject();

    const formData: any = new FormData();

    if(data && data.length){
      data.forEach((dt: any) => {
        formData.append(dt.name, dt.value);
      });
    }

    const xhr = new XMLHttpRequest();

    xhr.onreadystatechange = () => {
      {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            requestSubject.next(JSON.parse(xhr.responseText));
          } else {
            requestSubject.error(xhr.response);
          }
        }
      }
    }

    xhr.open(method, url, true);
    xhr.send(formData);

    return requestSubject.asObservable();
  }
}
