<template>
    <div>
        <input type="text" v-model="search" placeholder="search pins">
        <form v-on:submit.prevent="addNewPin" enctype="multipart/form-data">
            <label for="title">title</label>
            <input v-model="pintitle" type="text" name="title" id="title">
            <label for="description">Description</label>
            <input v-model="pindescription" type="text" name="description" id="description">
            <label for="image">Image</label>
            <input v-on:change="onFileChange" type="file" name="image" id="image">
            <input type="submit" value="Submit">
        </form>
        <div v-masonry transition-duration="0.3s" item-selector=".item">
            <div v-masonry-tile v-for="pin in filterpins" :key="pin.id"  class="grid-item item col-1 pin--list__item">
                <img class="image" v-bind:src="pin.img">
            </div>
        </div>
        <div v-if="!nomore" v-infinite-scroll="loadMore" infinite-scroll-disabled="busy">
            <img class="loader" src="http://localhost:8080/loader.gif">
        </div>
        <div v-if="nomore">
            no more posts
        </div>
    </div>
</template>

<script>
import axios from 'axios'

    export default {
        name:'pins',
        data() {
            return{
                pins: [],
                pintitle:'',
                pindescription:'',
                image:'',
                success: '',
                page: 2,
                busy: false,
                nomore: false,
                search: ''
            }
        },
        created() {
            this.getPins()
        },
        methods: {
            loadMore: function() {
                if(!this.nomore) {
                    this.busy = true;

                    setTimeout(() => {
                        axios
                            .get('http://127.0.0.1:8000/api/pins?page=' + this.page++)
                            .then(res => {
                                    const {
                                        data: {data}
                                    } = res
                                    if (data == '') {
                                        this.nomore = true;
                                        this.busy = false;
                                    } else {
                                        this.pins = [...this.pins, ...data];
                                    }
                                }
                            )
                            .catch(err => {
                                console.log(err)
                            })
                        this.busy = false;
                    }, 1000);
                }
            },

            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },

            createImage(file) {
                // var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            getPins: function() {
               axios
                   .get('http://127.0.0.1:8000/api/pins?page=1')
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
            },

            addNewPin: function() {
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                };

                let formData = new FormData();
                formData.append('title', this.pintitle);
                formData.append('description', this.pindescription);
                formData.append('img', this.image);
                axios
                    .post('http://127.0.0.1:8000/api/pins', formData ,config)
                    .then(
                        res => {
                            this.pintitle = ''
                            this.pindescription = ''
                            this.image = ''
                            this.getPins()
                            console.log(res)
                        }

                    )
                    .catch(err => {
                        console.log(err)
                    })
            }
        },
        computed: {
            filterpins: function () {
                return this.pins.filter((pin) => {
                    return pin.title.toLowerCase().match(this.search);
                })
            }
        }
    }
</script>
