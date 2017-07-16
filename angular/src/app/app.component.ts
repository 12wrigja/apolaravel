import 'rxjs/add/operator/map';
import 'rxjs/add/operator/catch';
import 'rxjs/add/observable/empty';

import {Component, OnInit} from '@angular/core';
import {DomSanitizer, SafeHtml} from '@angular/platform-browser';
import {Observable} from 'rxjs/Observable';
import {Subject} from 'rxjs/Subject';

import {User, UserAPI, UserListAPIResponse} from './services/UserAPI.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  title = 'app works!';
  allUsers: Observable<User[]>;
  latestError: Subject<SafeHtml>;

  constructor(
      private readonly userAPI: UserAPI, private readonly ds: DomSanitizer) {
    this.latestError = new Subject<SafeHtml>();
  }

  ngOnInit() {
    this.allUsers =
        this.userAPI.getAllUsers()
            .map((resp: UserListAPIResponse) => resp.data)
            .catch((error: any) => {
              console.log('Error while retrieving users.');
              console.log(error);
              this.latestError.next(this.ds.bypassSecurityTrustHtml(error));
              return Observable.empty();
            });
  }
}