declare var Pusher: any;

import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';

@Injectable()
export class PusherService {

  public pusher:any;
  public channel:any;

  constructor(public http: Http) { }

  initPusher() {
    this.pusher = new Pusher('123456789123456789', { cluster: 'eu', encrypted: false });
    this.channel = this.pusher.subscribe('test-channel');
  }
  getChannel() {
    return this.channel;
  }

}