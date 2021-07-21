import { Injectable, NgModule } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Inventory } from './Models';

@Injectable()
@NgModule()
export class InventoryWrapper {

    private url = "http://localhost:80/inventory";

    constructor(private http: HttpClient) { }

    public getAll() : Observable<Inventory[]> {
        return this.http.get<Inventory[]>(this.url);
    }

    public get(id: number) : Observable<Inventory> {
        return this.http.get<Inventory>(`${this.url}/${id}`);
    }

    public update(inventory: Inventory) {
        return this.http.put(this.url, inventory);
    }

    public create(inventory: Inventory) {
        return this.http.post(this.url, inventory);
    }  
   
}