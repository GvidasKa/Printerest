<template>
    <div>
        <div v-for="pin in pins" :key="pin.id">
            <h1>{{pin.title}}</h1>
            <p>{{pin.description}}</p>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name:'pins',
        data() {
            return{
                pins: null,
            }
        },
        created() {
            this.getPins()
        },
        methods: {
            getPins: function() {
                axios
                    .get('http://127.0.0.1:8000/api/pins')
                    .then(res => {
                            const {
                                data:{data}
                            } = res
                            this.pins = data
                            console.log(res)
                        }
                    )
                    .catch(err => {
                        console.log(err)
                    })
            }
        }
    }
</script>
