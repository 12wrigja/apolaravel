import 'rxjs/add/operator/do';

import {Injectable} from '@angular/core';
import {Headers, Http, RequestOptions, Response} from '@angular/http';
import camelcaseKeys from 'camelcase-keys';
import {Observable} from 'rxjs/Observable';


@Injectable()
export class APOAPI {
  private xsrfToken: string;
  private readonly API_BASE_STRING = '/api/v1/';
  constructor(private readonly http: Http) {
    this.xsrfToken =
        (document.querySelectorAll('[name="csrf-token"]')[0] as HTMLMetaElement)
            .content;
  }

  get(url: string): Observable<APIResponse> {
    return this.http.get(this.API_BASE_STRING + url, this.requestOptions())
        .map((resp: Response) => resp.json())
        .map((resp: any) => camelcaseKeys(resp, {deep: true}))
        .do((val) => console.log(val))
        .map((resp: any) => resp as APIResponse);
  }

  put(url: string, data: {}): Observable<APIResponse> {
    return this.http
        .put(this.API_BASE_STRING + url, data, this.requestOptions())
        .map((resp: Response) => resp.json())
        .map((resp: any) => camelcaseKeys(resp), {deep: true})
        .map((resp: any) => resp as APIResponse);
  }

  post(url: string, data: {}): Observable<APIResponse> {
    return this.http
        .post(this.API_BASE_STRING + url, data, this.requestOptions())
        .map((resp: Response) => resp.json())
        .map((resp: any) => camelcaseKeys(resp, {deep: true}))
        .map((resp: any) => resp as APIResponse);
  }

  delete(url: string): Observable<APIResponse> {
    return this.http.delete(this.API_BASE_STRING + url, this.requestOptions())
        .map((resp: Response) => resp.json())
        .map((resp: any) => camelcaseKeys(resp, {deep: true}))
        .map((resp: any) => resp as APIResponse);
  }

  unauth(): Observable<void> {
    const headers = new Headers();
    headers.append('X-CSRF-TOKEN', this.xsrfToken);
    headers.append('X-Requested-With', 'XMLHttpRequest');
    return this.http.post('/logout', [], new RequestOptions({headers}))
        .map(() => null);
  }

  private requestOptions(): RequestOptions {
    const headers = new Headers();
    headers.append('content-type', 'application/json');
    headers.append('Accept', 'application/json');
    headers.append('X-CSRF-TOKEN', this.xsrfToken);
    headers.append('X-Requested-With', 'XMLHttpRequest');
    return new RequestOptions({headers});
  }
}

export interface APIResponse { data: any; }