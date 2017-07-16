import {NgModule} from '@angular/core';
import {HttpModule} from '@angular/http';
import {RouterModule} from '@angular/router';

import {APOAPI} from './APOAPI.service';
import {NeedsAuthGuard} from './NeedsAuthGuard';
import {UserAPI} from './UserAPI.service';

@NgModule({
  imports: [HttpModule, RouterModule],
  providers: [
    UserAPI,
    APOAPI,
    NeedsAuthGuard,
  ],
})
export class APIModule {
}
