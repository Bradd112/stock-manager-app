<template>
    <div class="container mt-5">
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
                        <p class="alert alert-danger" v-if="Object.values(storages).length == 0">
                            Még nincs egy raktár sem létrehozva.
                        </p>

                        <div v-else>
                            <Form @submit="updateStorage"
                                  :validation-schema="schema"
                                  v-for="storage in storages"
                            >
                                <Field name="id"
                                       type="hidden"
                                       v-model="storage.id"
                                />

                                <div>
                                    <div>
                                        <strong>Megnevezés: </strong>

                                        <span v-if="! this.editableStorages[storage.id]">
                                            {{ storage.title }}
                                        </span>

                                        <div class="form-group"
                                             v-if="!! this.editableStorages[storage.id]"
                                        >
                                            <Field name="title"
                                                   class="form-control"
                                                   type="text"
                                                   placeholder="Megnevezés"
                                                   v-model="storage.title"
                                                   :value="storage.title"
                                            />
                                            <ErrorMessage name="title" />
                                        </div>
                                    </div>

                                    <div>
                                        <strong>Cím: </strong>

                                        <span v-if="! this.editableStorages[storage.id]">
                                            {{ storage.address }}
                                        </span>

                                        <div class="form-group"
                                             v-if="!! this.editableStorages[storage.id]"
                                        >
                                            <Field name="address"
                                                   class="form-control"
                                                   type="text"
                                                   placeholder="Cím"
                                                   v-model="storage.address"
                                                   :value="storage.address"
                                            />
                                            <ErrorMessage name="address" />
                                        </div>
                                    </div>

                                    <div>
                                        <strong>Kapacitás: </strong>

                                        <span v-if="! this.editableStorages[storage.id]">
                                            {{ storage.capacity }}
                                        </span>

                                        <div class="form-group"
                                             v-if="!! this.editableStorages[storage.id]"
                                        >
                                            <Field name="capacity"
                                                   class="form-control"
                                                   type="number"
                                                   min="0"
                                                   placeholder="Kapacitás"
                                                   :value="storage.capacity"
                                            />
                                            <ErrorMessage name="capacity" />
                                        </div>
                                    </div>

                                    <div>
                                        <label :for="'isInAbroadCheckbox' + storage.id" class="d-inline-block">
                                            <strong>Külföldön van? </strong>
                                        </label>

                                        <span v-if="! this.editableStorages[storage.id]">
                                             {{ storage.is_in_abroad }}
                                        </span>

                                        <div class="form-group"
                                             :class="{'d-none': ! this.editableStorages[storage.id]}"
                                        >
                                            <Field name="is_in_abroad"
                                                   type="checkbox"
                                                   :value="true"
                                                   :unchecked-value="false"
                                                   v-slot="{ field }"
                                            >
                                                <input type="checkbox"
                                                       name="is_in_abroad"
                                                       class="d-block"
                                                       :id="'isInAbroadCheckbox' + storage.id"
                                                       v-bind="field"
                                                       :true-value="true"
                                                       :false-value="false"
                                                       :checked="storage.is_in_abroad == 'Igen'"
                                                >
                                            </Field>
                                            <ErrorMessage name="is_in_abroad" />
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-2">
                                        <button type="button"
                                                class="btn btn-danger mr-10px"
                                                @click="deleteStorage(storage)"
                                                v-if="! this.editableStorages[storage.id]"
                                        >
                                            Törlés
                                        </button>

                                        <button type="button"
                                                class="btn btn-outline-primary mr-10px"
                                                @click="editStorage(storage)"
                                                v-if="! this.editableStorages[storage.id]"
                                        >
                                            Szerkesztés
                                        </button>

                                        <button type="button"
                                                class="btn btn-outline-danger mr-10px"
                                                @click="editStorage(storage)"
                                                v-if="!! this.editableStorages[storage.id]"
                                        >
                                            Mégse
                                        </button>

                                        <button type="submit"
                                                class="btn btn-primary"
                                                v-if="!! this.editableStorages[storage.id]"
                                        >
                                            Mentés
                                        </button>
                                    </div>
                                    <hr>
                                </div>
                            </Form>
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
import * as _ from 'lodash';

export default {
    props: [
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
                is_in_abroad: yup.boolean(),
            }),
            editableStorages: [],
        }
    },

    mounted() {
        this.keyStoragesById();
    },

    methods: {
        createStorage(values) {
            let self = this;

            axios({
                method: 'post',
                url: route('storage.store'),
                responseType: 'stream',
                data: values
            })
                .then(function (response) {
                    self.storages = Object.values(self.storages).concat(response.data.data);

                    self.keyStoragesById();
                });
        },

        deleteStorage(storage) {
            let self = this;

            axios({
                method: 'delete',
                url: route('storage.destroy', {storage: storage.id}),
                responseType: 'stream',
            })
                .then(function () {
                    self.storages = Object.values(self.storages).filter(storageToDelete => {
                        return storageToDelete.id != storage.id;
                    })

                    self.keyStoragesById();
                });
        },

        editStorage(storage) {
            this.editableStorages[storage.id] = ! this.editableStorages[storage.id];
        },

        updateStorage(values) {
            let self = this;

            if (document.querySelector('#isInAbroadCheckbox' + values.id + ':checked')) {
                values.is_in_abroad = true;
            }

            axios({
                method: 'put',
                url: route('storage.update', {storage: values.id}),
                responseType: 'stream',
                data: values
            })
                .then(function (response) {
                    self.storages[values.id].title = values.title;
                    self.storages[values.id].address = values.address;
                    self.storages[values.id].capacity = values.capacity;
                    self.storages[values.id].is_in_abroad = values.is_in_abroad ? 'Igen' : 'Nem';

                    self.editableStorages[values.id] = false;
                });
        },

        keyStoragesById() {
            this.storages = _.mapKeys(this.storages, function(value) {
                return value.id;
            });
        },
    }
}
</script>
