<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                Raktárak
                            </div>

                            <button class="btn btn-primary"
                                    @click="showNewStorageForm = true"
                            >
                                Új raktár
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        I'm an example component.

                        <form method="post" :action="newStorageStoreUrl" v-if="showNewStorageForm">
                            <div class="form-group">
                                <input class="form-control"
                                       type="text"
                                       placeholder="Megnevezés"
                                       v-model="newStorageData.title"
                                >
                            </div>

                            <div class="form-group mt-2">
                                <input class="form-control"
                                       type="text"
                                       placeholder="Cím"
                                       v-model="newStorageData.address"
                                >
                            </div>

                            <div class="form-group mt-2">
                                <input class="form-control"
                                       type="number"
                                       placeholder="Kapacitás"
                                       min="0"
                                       v-model="newStorageData.capacity"
                                >
                            </div>

                            <div class="form-group mt-2">
                                <label for="isInAbroadCheckbox">Külföldön van?</label>

                                <input type="checkbox"
                                       id="isInAbroadCheckbox"
                                       class="d-block"
                                       v-model="newStorageData.is_in_abroad"
                                >
                            </div>

                            <div class="form-group mt-2">
                                <button type="button"
                                        class="btn btn-primary"
                                        @click="createStorage"
                                >
                                    Létrehozás
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: [
        'newStorageStoreUrl',
    ],

    data: function () {
        return {
            showNewStorageForm: false,
            newStorageData: {
                title: '',
                address: '',
                capacity: null,
                is_in_abroad: false,
            },
        }
    },

    mounted() {

    },

    methods: {
        createStorage() {
            axios({
                method: 'post',
                url: this.newStorageStoreUrl,
                responseType: 'stream'
            })
                .then(function (response) {
                    console.log(response);
                });
        },
    }
}
</script>
