<template>
    <div>
        <div v-if='errors.length' class="alert alert-warning" role="alert">
            <span v-for='(error, idx) in errors' :key='idx'>{{error}} <br></span>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for='(product, idx) in products' :key='product.id'>
                    <td>{{idx + 1}}</td>
                    <td>{{product.name}}</td>
                    <td>{{product.price}}</td>
                    <td class="product-buttons">
                        <button @click="cartAction('removeFrom', product.id)" class="btn btn-outline-dark">-</button>
                        {{ product.quantity }}
                        <button @click="cartAction('addTo', product.id)" class="btn btn-outline-dark">+</button>
                    </td>
                    <td>
                        {{ Number(product.price * product.quantity).toFixed(2) }}
                    </td>
                </tr>
                <tr v-if='!products.length'>
                    <td class="text-center" colspan="5">
                        Корзина пока пуста, начните <a href="/">покупать!</a>
                    </td>
                </tr>

                <tr>
                    <td colspan="4" class="text-end">Итого:</td>
                    <td>
                        <strong>
                        {{ Number(summ).toFixed(2) }}
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <input placeholder="Имя" class="form-control mb-2" name='name' v-model="userName">
        <input placeholder="Почта" class="form-control mb-2" name='email' v-model="userEmail">
        <input placeholder="Адрес" class="form-control mb-2" name='address' v-model="userAddress">
        <template v-if='!userName'>
            <!-- не забудьте добавить оферту -->    
            <input id='register_confirmation' name='register_confirmation' type="checkbox">
            <label for="register_confirmation">Вы будете автоматически зарегистрированы</label>
            <br>
        </template>

        <button v-if='loading' class="btn btn-outline-dark" type="button" disabled>
            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
            Оформляем заказ...
        </button>
        <button v-else @click='createOrder' type="submit" class="btn btn-outline-dark">Оформить заказ</button>

    </div>
</template>

<script>

export default {
    props: ['prods', 'user', 'address'],
    
    data () {
        return {
            products: this.prods,
            errors: [],
            loading: false,
            userName: null,
            userEmail: null,
            userAddress: null
        }
    },
    computed:  {
        summ () {
            return this.products.reduce((sum, product) => {
                return sum += product.price * product.quantity
            }, 0)
        }
    },
    methods: {
        cartAction (type, id) {
            const params = {
                id
            }
            axios.post(`/cart/${type}Cart`, params)
                .then(response => {
                    const index = this.products.findIndex((product) => {
                        return product.id == id
                    })
                    if (response.data > 0) {
                        this.products[index].quantity = response.data
                    } else {
                        this.products.splice(index, 1)
                    }
                })
        },
        createOrder () {
            this.loading = true
            this.errors = []
            const params = {
                name: this.user.name,
                email: this.user.email,
                address: this.address
            }            
            axios.post('/cart/createOrder', params)
                .then(() => {
                    document.location.href = '/'
                })
                .catch(error => {
                    const errors = error.response.data.errors
                    for (let err in errors) {
                        errors[err].forEach(e => {
                            this.errors.push(e)
                        })
                    }
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
    mounted () {
        if (this.user) {
            this.userName = this.user.name
            this.userEmail = this.user.email
        }
        if (this.address) {
            this.userAddress = this.address
        }
    }
}
</script>

<style>
</style>