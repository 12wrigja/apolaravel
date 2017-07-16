import {Injectable} from '@angular/core';
import {CanActivate, RouterStateSnapshot} from '@angular/router';

@Injectable()
export class NeedsAuthGuard implements CanActivate {
  constructor(private readonly state: RouterStateSnapshot) {}

  canActivate() {
    const authMetaElements = document.querySelectorAll('[name=\'auth\']');
    if (authMetaElements.length > 0) {
      const element = authMetaElements[0] as HTMLMetaElement;
      if (element.content !== null && element.content !== undefined &&
          element.content !== '') {
        return true;
      }
    }
    window.location.href = '/login?redirect=' + this.state.url;
    return false;
  }
}