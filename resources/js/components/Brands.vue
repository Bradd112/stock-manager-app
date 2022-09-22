<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                Márkák
                            </div>

                            <button class="btn btn-primary"
                                    @click="showNewBrandForm = ! showNewBrandForm"
                            >
                                Új márka
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="alert alert-danger" v-if="Object.values(brands).length == 0">
                            Még nincs egy márka sem létrehozva.
                        </p>

                        <div v-else>
                            <Form @submit="updateBrand"
                                  :validation-schema="schema"
                                  v-for="brand in brands"
                            >
                                <Field name="id"
                                       type="hidden"
                                       v-model="brand.id"
                                />

                                <div>
                                    <div>
                                        <strong>Megnevezés: </strong>

                                        <span v-if="! this.editableBrands[brand.id]">
                                            {{ brand.title }}
                                        </span>

                                        <div class="form-group"
                                             v-if="!! this.editableBrands[brand.id]"
                                        >
                                            <Field name="title"
                                                   class="form-control"
                                                   type="text"
                                                   placeholder="Megnevezés"
                                                   v-model="brand.title"
                                                   :value="brand.title"
                                            />
                                            <ErrorMessage name="title" />
                                        </div>
                                    </div>

                                    <div>
                                        <strong>Minőség kategória: </strong>

                                        <span v-if="! this.editableBrands[brand.id]">
                                            {{ brand.quality_level }}
                                        </span>

                                        <div class="form-group"
                                             v-if="!! this.editableBrands[brand.id]"
                                        >
                                            <Field name="quality_level"
                                                   class="form-control"
                                                   type="text"
                                                   placeholder="Minőség kategória"
                                                   v-model="brand.quality_level"
                                                   :value="brand.quality_level"
                                            />
                                            <ErrorMessage name="quality_level" />
                                        </div>
                                    </div>

                                    <div>
                                        <strong>Weboldal link: </strong>

                                        <a :href="brand.website_url" target="_blank" v-if="! this.editableBrands[brand.id]">
                                            {{ brand.website_url }}
                                        </a>

                                        <div class="form-group"
                                             v-if="!! this.editableBrands[brand.id]"
                                        >
                                            <Field name="website_url"
                                                   class="form-control"
                                                   type="text"
                                                   placeholder="Weboldal link"
                                                   v-model="brand.website_url"
                                                   :value="brand.website_url"
                                            />
                                            <ErrorMessage name="website_url" />
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-2">
                                        <button type="button"
                                                class="btn btn-danger mr-10px"
                                                @click="deleteBrand(brand)"
                                                v-if="! this.editableBrands[brand.id]"
                                        >
                                            Törlés
                                        </button>

                                        <button type="button"
                                                class="btn btn-outline-primary mr-10px"
                                                @click="editBrand(brand)"
                                                v-if="! this.editableBrands[brand.id]"
                                        >
                                            Szerkesztés
                                        </button>

                                        <button type="button"
                                                class="btn btn-outline-danger mr-10px"
                                                @click="editBrand(brand)"
                                                v-if="!! this.editableBrands[brand.id]"
                                        >
                                            Mégse
                                        </button>

                                        <button type="submit"
                                                class="btn btn-primary"
                                                v-if="!! this.editableBrands[brand.id]"
                                        >
                                            Mentés
                                        </button>
                                    </div>
                                    <hr>
                                </div>
                            </Form>
                        </div>

                        <Form @submit="createBrand" :validation-schema="schema" v-if="showNewBrandForm">
                            <div class="form-group">
                                <Field name="title"
                                       class="form-control"
                                       type="text"
                                       placeholder="Megnevezés"
                                />
                                <ErrorMessage name="title" />
                            </div>

                            <div class="form-group mt-2">
                                <Field name="quality_level"
                                       class="form-control"
                                       type="number"
                                       min="0"
                                       max="5"
                                       placeholder="Minőség kategória (1-5)"
                                />
                                <ErrorMessage name="quality_level" />
                            </div>

                            <div class="form-group mt-2">
                                <Field name="website_url"
                                       class="form-control"
                                       type="text"
                                       placeholder="Weboldal link"
                                />
                                <ErrorMessage name="website_url" />
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
        'existingBrands',
    ],

    components: {
        Field,
        Form,
        ErrorMessage,
    },

    data: function () {
        return {
            brands: this.existingBrands,
            showNewBrandForm: false,
            schema: yup.object({
                title: yup.string().required('A megnevezés megadása kötelező!'),
                quality_level: yup.number()
                    .max(5, 'A minőség kategória maximum 5 lehet!')
                    .required('A minőség kategória megadása kötelező!')
                    .positive('A kapacitásnak pozitív számnak kell lennie!')
                    .integer('A kapacitásnak számnak kell lennie!'),
                website_url: yup.string()
                    .url('A weboldal linknek érvényes URL-nek kell lennie!')
                    .nullable(),
            }),
            editableBrands: [],
        }
    },

    mounted() {
        this.keyBrandsById();
    },

    methods: {
        createBrand(values) {
            let self = this;

            axios({
                method: 'post',
                url: route('brand.store'),
                responseType: 'stream',
                data: values
            })
                .then(function (response) {
                    self.brands = Object.values(self.brands).concat(response.data.data);

                    self.keyBrandsById();
                });
        },

        deleteBrand(brand) {
            let self = this;

            axios({
                method: 'delete',
                url: route('brand.destroy', {brand: brand.id}),
                responseType: 'stream',
            })
                .then(function () {
                    self.brands = Object.values(self.brands).filter(brandToDelete => {
                        return brandToDelete.id != brand.id;
                    })

                    self.keyBrandsById();
                });
        },

        editBrand(brand) {
            this.editableBrands[brand.id] = ! this.editableBrands[brand.id];
        },

        updateBrand(values) {
            let self = this;

            if (document.querySelector('#isInAbroadCheckbox' + values.id + ':checked')) {
                values.is_in_abroad = true;
            }

            axios({
                method: 'put',
                url: route('brand.update', {brand: values.id}),
                responseType: 'stream',
                data: values
            })
                .then(function (response) {
                    self.brands[values.id] = response.data.data;

                    self.editableBrands[values.id] = false;
                });
        },

        keyBrandsById() {
            this.brands = _.mapKeys(this.brands, function(value) {
                return value.id;
            });
        },
    }
}
</script>
