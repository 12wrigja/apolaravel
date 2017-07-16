import {NgModule} from '@angular/core';
import {RouterModule} from '@angular/router';

import {HomepageComponent} from './homepage.component';

@NgModule({
  declarations: [HomepageComponent],
  exports: [HomepageComponent],
  imports: [RouterModule]
})
export class HomepageModule {
}