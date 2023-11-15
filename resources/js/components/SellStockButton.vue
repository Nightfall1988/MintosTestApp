<template>
    <div class="container">
        <button ref='submitButton' v-on:click="handleClick($event)">SELL ALL</button>
    </div>
</template>

<script>
export default {
    data () {
        return {
            stockSymbol: '',
            row: Element,
            index: 0,
            table: Element,
            amount: 0,
            currentPrice: 0,
            profit: 0,
            id: 0,
            data: 0

        }
    },

    methods: {

    handleClick(e) {
      e.preventDefault()
      this.table = document.getElementById('stockTable')
      this.id = document.getElementById('id').value
      this.row = e.target.parentNode.parentNode.parentNode
      this.stockSymbol = this.row.cells[0].innerHTML
      this.amount = this.row.cells[1].innerHTML
      this.currentPrice = this.row.cells[4].innerHTML
      this.profit = this.currentPrice * this.amount
      this.data = this.profit
      axios.post('/update-stock/' + this.id + '/' + this.stockSymbol, JSON.stringify({
            id: this.id,
            stockSymbol: this.stockSymbol,
            profit: this.profit
        })).then((response) => {
          console.log(response)
      }),
      this.index = this.row.rowIndex
    }
  }
        
    }
</script>