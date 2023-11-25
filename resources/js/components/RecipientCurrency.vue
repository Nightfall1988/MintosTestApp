<template>
    <div>
        <div class="flex flex-row">
            <label for='recipientId'><b>Recipient account ID:&nbsp;&nbsp;</b></label>
            <input id='recipientId' v-on:input="getCurrency" class="outline-black" name='recipientId' type="text" style="width: 11rem;"/>
        </div>
        <div>
            {{ this.recipientMessage }}
        </div>
        <input type="hidden" id="recipientCurrency" :value="recipientCurrency"/>
    </div>
</template>

<script>
export default {
    
    data () {
        return {
            recipientAccountId: '',
            recipientCurrency: '',
            recipientMessage: ''
        }
    },

    methods: {
        getCurrency () {
            this.recipientAccountId = document.getElementById('recipientId').value
            console.log(this.recipientAccountId)
            if (this.recipientAccountId != '') {
                axios.get('/get-reciever-currency/' + this.recipientAccountId)
                .then((response) => {
                    if (response.data == 0) {
                        this.recipientMessage = 'Account with this ID hasn\'t been found.'
                    } else {
                        this.recipientCurrency = response.data;
                        this.recipientMessage =  'Recipient account currency: ' + this.recipientCurrency;
                    }
                })
            } else {
                this.recipientMessage = '';
            }
        }
    }
}
</script>