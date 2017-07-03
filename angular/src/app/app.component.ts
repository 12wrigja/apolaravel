import { Component } from '@angular/core';
import { Http, Response, RequestOptions, Headers } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import { Subject } from 'rxjs/Subject';
import { camelcaseKeys } from 'camelcase-keys';
import { SafeHtml, DomSanitizer } from '@angular/platform-browser';

import 'rxjs/add/operator/map';
import 'rxjs/add/operator/catch';
import 'rxjs/add/observable/empty';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app works!';
  allUsers: Observable<User>;
  latestError: Subject<SafeHtml>;

  constructor(private readonly http: Http, private readonly ds: DomSanitizer) {
    this.latestError = new Subject<SafeHtml>();
  }

  ngOnInit() {
    const headers = new Headers();
    headers.append("content-type", "application/json");
    headers.append("Accept", 'application/json');
    // headers.append("XSRF-TOKEN", document.querySelector('[name=""]'))
    const rq = new RequestOptions({headers});
    this.allUsers = this.http.get('/api/v1/users', rq).map((resp: Response) => resp.json()).map((resp: any) => camelcaseKeys(resp)).map((resp: any) => resp as UserListAPIResponse).map((resp: UserListAPIResponse) => resp.users).catch((error: any) => {
      console.log("Error while retrieving users.");
      console.log(error);
      this.latestError.next(this.ds.bypassSecurityTrustHtml(error));
      return Observable.empty();
    });
  }
}

interface User {
  name: string;
  firstName: string;

}

interface UserListAPIResponse {
  users: User[],
}

interface APIResponse {
  data: any;
}