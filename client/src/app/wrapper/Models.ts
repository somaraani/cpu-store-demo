
export class Inventory {
    id!: number;
    quantity!: number;
    price!: number;

    constructor(id: number, quantity: number, price: number) {
        this.id = id;
        this.quantity = quantity;
        this.price = price;
    }
}

export class Cpu {
    product_id!: number;
    manufacturer!: string;
    model!: string;
    speed!: number;
    cores!: number;
    img?: string;
}