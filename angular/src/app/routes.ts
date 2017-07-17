import {NgModule} from '@angular/core';
import {Route, Router, RouterModule} from '@angular/router';

import {HomepageComponent} from './homepage/homepage.component';
import {NeedsAuthGuard} from './services/NeedsAuthGuard';
import {UserlistComponent} from './userlist/userlist.component';

const routes: Route[] = [
  {
    path: '',
    component: HomepageComponent,
    pathMatch: 'full',
  },
  {
    path: 'users',
    component: UserlistComponent,
    canActivate: [NeedsAuthGuard],
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [
    RouterModule,
  ]
})
export class AppRoutesModule {
}