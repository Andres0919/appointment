
export class Transaction {

    constructor() {
    }

    static get typeTransaction() {
        return {compra: 1, traslado: 2, prestamo_salida: 3, prestamo_entrada: 4};
    }

};