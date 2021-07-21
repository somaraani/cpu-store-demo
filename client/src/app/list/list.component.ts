import { Component, Inject, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';
import { MatCheckboxChange } from '@angular/material/checkbox';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { CpuWrapper } from '../wrapper/CpuWrapper';
import { InventoryWrapper } from '../wrapper/InventoryWrapper';
import { Cpu, Inventory } from '../wrapper/Models';

@Component({
  selector: 'app-list',
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.css']
})
export class ListComponent implements OnInit {

  private cpuWrapper: CpuWrapper;
  private inventoryWrapper: InventoryWrapper;

  currentInventory?: Inventory;
  inventoryEmpty: boolean = false;

  priceInput = new FormControl();
  quantityInput = new FormControl();

  loaded: boolean = false;
  cpus?: Cpu[];

  inventoryLoaded: boolean = false;
  editing: boolean = false;

  onlyShowInStock: boolean = false;

  constructor(cpuWrapper: CpuWrapper, inventoryWrapper: InventoryWrapper, public dialog: MatDialog) {
    this.inventoryWrapper = inventoryWrapper;
    this.cpuWrapper = cpuWrapper;
    this.loaded = false;
  }


  ngOnInit(): void {
    this.cpuWrapper.getAll().subscribe((cpus) => {
      this.cpus = cpus;
      this.loaded = true;
    });
  }

  edit(id: number) {
    if (this.editing) {

      if (this.currentInventory) {
        this.currentInventory!.price = this.priceInput.value;
        this.currentInventory!.quantity = this.quantityInput.value;
      }

      // If no inventory of this CPU, create (POST) otherwise, update (PUT)
      if (this.inventoryEmpty) {
        this.currentInventory = new Inventory(id, this.quantityInput.value, this.priceInput.value);
        this.inventoryWrapper.create(this.currentInventory).subscribe(() => {
          this.inventoryEmpty = false;
        });
      } else {
        this.inventoryWrapper.update(this.currentInventory!).subscribe();
      }

    }
    this.editing = !this.editing;
  }

  load(id: number) {
    this.editing = false;
    this.inventoryEmpty = false;
    this.inventoryLoaded = false;

    this.inventoryWrapper.get(id).subscribe(inventory => {
      this.currentInventory = inventory;
      this.priceInput.setValue(inventory.price);
      this.quantityInput.setValue(inventory.quantity);
      this.inventoryLoaded = true;
    }, (error) => {
      // Doesn't have inventory
      if (error.status == 404) {
        this.inventoryEmpty = true;
        this.inventoryLoaded = true;
        this.priceInput.setValue("");
        this.quantityInput.setValue("");
      }
    });
  }

  onCheck(event: MatCheckboxChange) {
    this.loaded = false;
    this.cpuWrapper.getAll(event.checked).subscribe((cpus) => {
      this.cpus = cpus;
      this.loaded = true;
    });
  }

  openDialog(): void {
    const dialogRef = this.dialog.open(CreateDialog, {
      width: '400px',
      data: {}
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log('The dialog was closed');
    });
  }

}

@Component({
  selector: 'create-dialog',
  templateUrl: 'create-dialog.html',
})
export class CreateDialog {

  constructor(
    public dialogRef: MatDialogRef<Cpu>,
    @Inject(MAT_DIALOG_DATA) public data: Cpu, private cpuWrapper: CpuWrapper) { }

  onNoClick(): void {
    this.dialogRef.close();

    if(this.data.model && this.data.manufacturer && this.data.speed && this.data.cores) {
      this.cpuWrapper.create(this.data).subscribe();
    }
  }

}