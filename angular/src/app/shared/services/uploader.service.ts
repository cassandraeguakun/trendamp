import { Injectable } from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {AppConfig} from '../../shared/AppConfig';
import {Subject} from 'rxjs/Subject';

@Injectable()
export class UploaderService {

  constructor() {}

  readImage(file): Observable<any> {
    const imageObservable = new Subject();

    imageObservable.next(null);

    if(file){
      const reader = new FileReader();

      if(file.type.indexOf('image') !== -1) {
        reader.onload = (e: any) => {
          imageObservable.next({
            preview : e.target.result,
            file : file
          });
        }
      }

      reader.readAsDataURL(file);
    }

    return imageObservable;
  }

  uploadImage(file: File, url: string, method: string = 'POST', fileName = 'image'){
    url = AppConfig.serverApi + url + '?token=' + localStorage.getItem('authToken');

    return new Promise((resolve, reject) => {
      const formData: any = new FormData();
      const xhr = new XMLHttpRequest();

      formData.append(fileName, file, file.name);

      xhr.onreadystatechange = () => {
        {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
               resolve(JSON.parse(xhr.responseText));
            } else {
              reject(xhr.response);
            }
          }
        }
      }

      xhr.upload.onprogress = (event) => {
        if (event.lengthComputable) {
          const progress = Math.round(event.loaded / event.total * 100);

          console.log('progress:');
          console.log(event.loaded);
        }
      };

      xhr.open(method, url, true);
      xhr.send(formData);
    });
  }

}
