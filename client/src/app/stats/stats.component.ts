import { Component, Inject, OnInit } from '@angular/core';
import { InventoryWrapper } from '../wrapper/InventoryWrapper';
import { Inventory } from '../wrapper/Models';

@Component({
  selector: 'app-stats',
  templateUrl: './stats.component.html',
  styleUrls: ['./stats.component.css'],
})
export class StatsComponent implements OnInit {

  private inventoryWrapper: InventoryWrapper;

  loaded: boolean;
  inventory?: Inventory[];

  totalStock: number = 0;
  minPrice: number = Number.MAX_VALUE;
  maxPrice: number = 0;
  avgPrice: number = 0;

  constructor(inventoryWrapper: InventoryWrapper) { 
    this.inventoryWrapper = inventoryWrapper;
    this.loaded = false;
  }

  ngOnInit(): void {
    this.inventoryWrapper.getAll().subscribe((inventory) => {
        this.inventory = inventory;

        inventory.forEach(item => {
          this.totalStock += item.quantity;
          this.avgPrice += item.price;
        
          this.minPrice = Math.min(this.minPrice, item.price);
          this.maxPrice = Math.max(this.maxPrice, item.price);
        });

        this.avgPrice = this.avgPrice/inventory.length;
        this.loaded = true;
    });
  }

}
