import {Injectable} from '@angular/core';
import {ActivatedRouteSnapshot, CanActivate, RouterStateSnapshot} from '@angular/router';

import {UserAPI} from './UserAPI.service';
@Injectable()
export class NeedsAuthGuard implements CanActivate {
  constructor(private readonly userAPI: UserAPI) {}

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    const authMetaElements = document.querySelectorAll('[name=\'auth\']');
    if (authMetaElements.length > 0) {
      const element = authMetaElements[0] as HTMLMetaElement;
      if (element.content !== null && element.content !== undefined &&
          element.content !== '') {
        return this.userAPI.getWhoAmI().map(
            (serverVal) => serverVal === element.content);
      }
    }
    window.location.href = '/login?redirect=' + state.url;
    return false;
  }
}