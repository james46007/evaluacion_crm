<template>
    <div class="mt-3">
        <h2> Prueba BluBear </h2>
        <form v-on:submit.prevent="checkForm">
            <div v-if="errors.length">
                <b>Errores:</b>
            <ul>
                <li v-for="error in errors">{{ error }}</li>
            </ul>
            </div>

            <div class="form-group">
                <label for="n">Talla del array</label>
                <input type="number" class="form-control" id="n" name="n" placeholder="Ingrese la talla del array" v-model="form.n">
            </div>

            <div class="form-group">
                <label for="k">Valor objetivo</label>
                <input type="number" class="form-control" id="k" name="k" placeholder="Ingrese el valor objetivo" v-model="form.k">
            </div>

            <div class="form-group">
                <label for="array">Array</label>
                <input type="text" class="form-control" id="array" name="array" placeholder="Ingrese los numeros enteros" v-model="form.array">
            </div>

            <div class="form-group">
                <button class="btn btn-primary">Submit</button>
            </div>

        </form>

        <h2> Resultados </h2>
        <ul>
            <li v-for="result in results">{{ result }}</li>
        </ul>

    </div>
</template>

<script>
import {isNumber} from "lodash";

export default {
    name: "ArrayMain",
    data: () => ({
        errors: [],
        form: {
            k: "",
            n: "",
            array: ""
        },
        results: []
    }),
    mounted(){
        // invocar los métodos
        this.listResult();
    },
    methods: {
        checkForm: function (e) {
            this.errors = [];

            if (!this.form.n) {
                this.errors.push("N requerido.");
            } else if (!Number.isInteger(Number(this.form.n))) {
                this.errors.push("n no es un numero");
            } else if ((2 > this.form.n) || (this.form.n > 100000)) {
                this.errors.push("No cumple la validacion n");
            }

            if (!this.form.k) {
                this.errors.push('K requerido.');
            } else if (!Number.isInteger(Number(this.form.k))) {
                this.errors.push("k no es un numero");
            } else if ((0 > this.form.k) || (this.form.k > 1000000000)) {
                this.errors.push("No cumple la validacion k");
            }
            const arraySplit = this.form.array.trim().split(' ');
            const uniqueItems = [...new Set(arraySplit)]
            const numerico = arraySplit.filter((item) => {
                if (!Number.isInteger(Number(item))) {
                    return item;
                }
            });
            if (!arraySplit.length) {
                this.errors.push("Array vacio");
            }
            if (arraySplit.length !== uniqueItems.length) {
                this.errors.push("Array con numeros repetidos");
            }
            if (numerico.length) {
                this.errors.push("Array no contiene numeros enteros");
            }

            if (this.form.n !== arraySplit.length) {
                this.errors.push("El tamaño del array no es igual a n");
            }

            if (this.errors.length > 0) {
                return true;
            }

            this.form.array = arraySplit;
            axios.post('/verify', this.form).then((result) => {
                this.results = result.data;
            }).catch((error) => alert('Ocurrio un error'));
            this.form = {
                k: "",
                n: "",
                array: ""
            };
        },
        listResult: function () {
            axios.get('/result/list').then((result) => {
                this.results = result.data;
            }).catch((error) => alert('Ocurrio un error'));
        }
    }
}
</script>


<style scoped>

</style>
