import {Route, Router, RouterModule} from '@angular/router';

import {HomepageComponent} from './homepage/homepage.component';
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
  }
];

export const ROUTES_MODULE = RouterModule.forRoot(routes);