<template>
    <div class="container">
        <button class="bg-blue-800 hover:bg-blue-400 text-white font-bold py-2 px-4 border border-black-700 rounded" ref='submitButton' v-on:click="check()">Transfer</button>
    </div>
</template>

<script>
export default {
    data () {
        return {
            enoughResources: false,
            balance: 0,
            id: 0,
            amount: 0,
            message: '',
            form: Element,
            senderAccount: '',
            recipientAccount: '',
        }
    },

    methods: {
        check ($event) {
            event.preventDefault()
            this.form = document.getElementById('transferForm')
            this.id = document.getElementById('recipientId').value;
            console.log(this.id)
            this.amount = document.getElementById('amount').value;            
            this.senderAccount = document.getElementById('senderId').value
            this.recipientAccount = document.getElementById('recipientId').value

            if (this.senderAccount == this.recipientAccount || this.recipientAccount == '')
            {
                this.message = 'The recipient ID is incorrect. Please check your spelling'
                alert(this.message)
            } else {
                this.balance = axios.get('/get-balance/' + this.senderAccount)
                    .then((response) => {
                    this.balance = response.data;
                    console.log(this.senderAccount)
                    console.log(this.amount)
                    console.log(this.balance)
                    console.log(response.data)
                    if (this.amount <= this.balance)
                    {
                        this.form.submit()
                    } else {
                        this.message = 'Unfortunately, You do not have enough money on your account'
                        alert(this.message)
                    }
                })
            }
            },
        }
    }
</script>