import { Injectable, NgModule } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Inventory } from './Models';
import { environment } from 'src/environments/environment';

@Injectable()
@NgModule()
export class InventoryWrapper {

    private url = `${environment.api_url}/inventory`;

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