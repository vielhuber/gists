import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { PusherService } from '../../providers/pusher-service';

@Component({
  selector: 'page-game',
  templateUrl: 'game.html'
})
export class GamePage {
  constructor(public navCtrl: NavController, public navParams: NavParams, private pusherService: PusherService) { }
  ionViewDidEnter() {
    this.pusherService.getChannel().bind('App\\Events\\GameEvent', (result) => {
      console.log(result);
    });
  }
  ionViewDidLeave() {
    this.pusherService.getChannel().unbind('App\\Events\\GameEvent');
  }
}
