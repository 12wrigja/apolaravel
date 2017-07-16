import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {RouterModule} from '@angular/router';

import {APIModule} from '../services/API.module';

import {UserlistComponent} from './userlist.component';

@NgModule({
  declarations: [UserlistComponent],
  exports: [UserlistComponent],
  imports: [RouterModule, APIModule, FormsModule, CommonModule]
})
export class UserlistModule {
}