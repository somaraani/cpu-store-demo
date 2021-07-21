import { Injectable, NgModule } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Cpu } from './Models';

@Injectable()
@NgModule()
export class CpuWrapper {

    private url = "cpu-server/cpu";

    constructor(private http: HttpClient) { }

    public getAll(filterInStock: boolean = false) : Observable<Cpu[]> {
        return this.http.get<Cpu[]>(this.url + `?filterInStock=${filterInStock}`);
    }

    public create(cpu: Cpu) {
        return this.http.post<Cpu>(this.url, cpu);
    }
   
}