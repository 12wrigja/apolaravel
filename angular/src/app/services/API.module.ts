import {NgModule} from '@angular/core';
import {HttpModule} from '@angular/http';

import {APOAPI} from './APOAPI.service';
import {UserAPI} from './UserAPI.service';

@NgModule({
  imports: [HttpModule],
  providers: [
    UserAPI,
    APOAPI,
  ]
})
export class APIModule {
}
