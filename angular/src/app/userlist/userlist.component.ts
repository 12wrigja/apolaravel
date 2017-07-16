import 'rxjs/add/operator/map';
import 'rxjs/add/observable/empty';
import 'rxjs/add/operator/catch';

import {Component, OnInit} from '@angular/core';
import {DomSanitizer, SafeHtml} from '@angular/platform-browser';
import {Observable} from 'rxjs/Observable';
import {Subject} from 'rxjs/Subject';

import {User, UserAPI, UserListAPIResponse} from '../services/UserAPI.service';

@Component({
  selector: 'app-userlist',
  templateUrl: './userlist.component.html',
  styleUrls: ['./userlist.component.css']
})
export class UserlistComponent implements OnInit {
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
