import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';

import {APIResponse, APOAPI} from './APOAPI.service';

@Injectable()
export class UserAPI {
  constructor(private readonly apoAPI: APOAPI) {}

  getAllUsers(): Observable<UserListAPIResponse> {
    return this.apoAPI.get('users').map(
        (resp: APIResponse) => resp as UserListAPIResponse);
  }
}


export interface User {
  id: string;
  href: string;
  firstName: string;
}

export interface UserListAPIResponse { data: User[], }