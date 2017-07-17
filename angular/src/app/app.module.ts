import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {BrowserModule} from '@angular/platform-browser';

import {AppComponent} from './app.component';
import {HomepageModule} from './homepage/homepage.module';
import {AppRoutesModule} from './routes';
import {APIModule} from './services/API.module';
import {UserlistModule} from './userlist/userlist.module';

@NgModule({
  declarations: [
    AppComponent,
  ],
  imports: [
    BrowserModule,
    FormsModule,
    APIModule,
    AppRoutesModule,
    HomepageModule,
    UserlistModule,
    CommonModule,
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {
}
