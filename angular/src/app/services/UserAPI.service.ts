import 'rxjs/add/operator/publishReplay';

import {Injectable} from '@angular/core';
import {BehaviorSubject} from 'rxjs/BehaviorSubject';
import {Observable} from 'rxjs/Observable';

import {APIResponse, APOAPI} from './APOAPI.service';

@Injectable()
export class UserAPI {
  whoAmICache: Observable<string>;
  constructor(private readonly apoAPI: APOAPI) {
    this.whoAmICache = this.apoAPI.get('whoami')
                           .map((resp: APIResponse) => {
                             return resp.data as string;
                           })
                           .publishReplay(1)
                           .refCount();
  }

  getAllUsers(): Observable<UserListAPIResponse> {
    return this.apoAPI.get('users').map(
        (resp: APIResponse) => resp as UserListAPIResponse);
  }

  getWhoAmI(): Observable<string> {
    return this.whoAmICache;
  }
}


export interface User {
  id: string;
  href: string;
  firstName: string;
}

export interface UserListAPIResponse { data: User[], }