import { Component, ContentChild, OnInit, ViewChild } from '@angular/core';
import { MatTabChangeEvent } from '@angular/material/tabs';
import { StatsComponent } from '../stats/stats.component';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  @ViewChild(StatsComponent) appStats: StatsComponent | undefined; 
  
  constructor() { }

  ngOnInit(): void {
  }

  onChange(event: MatTabChangeEvent) {
    this.appStats?.refresh();
  }
}
