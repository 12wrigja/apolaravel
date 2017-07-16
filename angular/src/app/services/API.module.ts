import { NgModule } from '@angular/core';
import { HttpModule } from '@angular/http';

import {UserAPI} from './UserAPI.service';
import {APOAPI} from './APOAPI.service';

@NgModule({imports: [
        HttpModule
    ],
    providers: [
        UserAPI,
        APOAPI,
    ]
})
export class APIModule { }
