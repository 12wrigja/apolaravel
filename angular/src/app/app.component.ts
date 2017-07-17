import 'rxjs/add/observable/of';
import 'rxjs/add/operator/catch';

import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {Observable} from 'rxjs/Observable';

import {APOAPI} from './services/APOAPI.service';
import {UserAPI} from './services/UserAPI.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  title = 'app works!';
  me: Observable<string>;
  constructor(
      private readonly userAPI: UserAPI, private readonly apoAPI: APOAPI,
      private readonly router: Router) {}

  ngOnInit() {
    this.refreshWhoAmI();
  }

  private refreshWhoAmI() {
    this.me = this.userAPI.getWhoAmI().catch(
        (error: Response, caught: Observable<string>) => {
          console.log(error);
          return Observable.of(' not logged in.');
        });
  }

  logout() {
    console.log('logging out... ');
    this.apoAPI.unauth().subscribe(() => this.refreshWhoAmI());
  }

  goHome() {
    this.router.navigateByUrl('');
  }
}