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
                                    @click="showNewStorageForm = ! showNewStorageForm"
                            >
                                Új raktár
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="alert alert-danger" v-if="storages.length == 0">
                            Még nincs egy raktár sem létrehozva.
                        </p>

                        <div v-else
                             v-for="storage in storages"
                        >
                            <div>
                                <strong>Megnevezés:</strong>
                                {{ storage.title }}
                            </div>

                            <div>
                                <strong>Cím:</strong>
                                {{ storage.address }}
                            </div>

                            <div>
                                <strong>Kapacitás:</strong>
                                {{ storage.capacity }}
                            </div>

                            <div>
                                <strong>Külföldön van?</strong>
                                {{ storage.is_in_abroad }}
                            </div>

                            <hr>
                        </div>

                        <Form @submit="createStorage" :validation-schema="schema" v-if="showNewStorageForm">
                            <div class="form-group">
                                <Field name="title"
                                       class="form-control"
                                       type="text"
                                       placeholder="Megnevezés"
                                />
                                <ErrorMessage name="title" />
                            </div>

                            <div class="form-group mt-2">
                                <Field name="address"
                                       class="form-control"
                                       type="text"
                                       placeholder="Cím"
                                />
                                <ErrorMessage name="address" />
                            </div>

                            <div class="form-group mt-2">
                                <Field name="capacity"
                                       class="form-control"
                                       type="number"
                                       min="0"
                                       placeholder="Kapacitás"
                                />
                                <ErrorMessage name="capacity" />
                            </div>

                            <div class="form-group mt-2">
                                <label for="isInAbroadCheckbox">Külföldön van?</label>

                                <Field name="is_in_abroad"
                                       class="d-block"
                                       type="checkbox"
                                       id="isInAbroadCheckbox"
                                       :value="true"
                                       :unchecked-value="undefined"
                                />
                                <ErrorMessage name="is_in_abroad" />
                            </div>

                            <div class="form-group mt-2">
                                <button type="submit"
                                        class="btn btn-primary"
                                >
                                    Létrehozás
                                </button>
                            </div>
                        </Form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {ErrorMessage, Field, Form} from 'vee-validate';
import * as yup from 'yup';

export default {
    props: [
        'newStorageStoreUrl',
        'existingStorages',
    ],

    components: {
        Field,
        Form,
        ErrorMessage,
    },

    data: function () {
        return {
            storages: this.existingStorages,
            showNewStorageForm: false,
            schema: yup.object({
                title: yup.string().required('A megnevezés megadása kötelező!'),
                address: yup.string().required('A cím megadása kötelező!'),
                capacity: yup.number()
                    .required('A kapacitás megadása kötelező!')
                    .positive('A kapacitásnak pozitív számnak kell lennie!')
                    .integer('A kapacitásnak számnak kell lennie!'),
            })
        }
    },

    mounted() {

    },

    methods: {
        createStorage(values) {
            let self = this;

            axios({
                method: 'post',
                url: this.newStorageStoreUrl,
                responseType: 'stream',
                data: values
            })
                .then(function (response) {
                    self.storages = self.storages.concat(response.data.data);
                });
        },

        isRequired(value) {
            if (value && value.trim()) {
                return true;
            }

            return 'A mező kitöltése kötelező!';
        }
    }
}
</script>
