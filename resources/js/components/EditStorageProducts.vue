<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                "{{ storage.title }}" raktár termékei
                            </div>

                            <button class="btn btn-primary"
                                    @click="showNewProductForm = ! showNewProductForm"
                                    v-if="storage.has_more_capacity"
                            >
                                Új termék
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="alert alert-danger" v-if="Object.values(products).length == 0">
                            Még nincs egy termék sem létrehozva.
                        </p>

                        <p class="alert alert-info" v-if="! storage.has_more_capacity">
                            A raktár kapacitása megtelt, nem fér el több termék benne.
                        </p>

                        <div v-if="Object.values(products).length > 0">
                            <Form @submit="updateProduct"
                                  :validation-schema="schema"
                                  v-for="product in products"
                                  :ref="'productForm' + product.id"
                            >
                                <Field name="id"
                                       type="hidden"
                                       v-model="product.id"
                                />

                                <Field name="storage_id"
                                       type="hidden"
                                       v-model="storage.id"
                                />

                                <div>
                                    <div>
                                        <strong>Megnevezés: </strong>

                                        <span v-if="! this.editableProducts[product.id]">
                                            {{ product.title }}
                                        </span>

                                        <div class="form-group"
                                             v-if="!! this.editableProducts[product.id]"
                                        >
                                            <Field name="title"
                                                   class="form-control"
                                                   type="text"
                                                   placeholder="Megnevezés"
                                                   v-model="product.title"
                                                   :value="product.title"
                                            />
                                            <ErrorMessage name="title" />
                                        </div>
                                    </div>

                                    <div>
                                        <strong>Cikkszám: </strong>

                                        <span v-if="! this.editableProducts[product.id]">
                                            {{ product.sku }}
                                        </span>

                                        <div class="form-group"
                                             v-if="!! this.editableProducts[product.id]"
                                        >
                                            <Field name="sku"
                                                   class="form-control"
                                                   type="text"
                                                   placeholder="Cikkszám"
                                                   v-model="product.sku"
                                                   :value="product.sku"
                                            />
                                            <ErrorMessage name="sku" />
                                        </div>
                                    </div>

                                    <div>
                                        <strong>Ár: </strong>

                                        <span v-if="! this.editableProducts[product.id]">
                                            {{ product.price }}
                                        </span>

                                        <div class="form-group"
                                             v-if="!! this.editableProducts[product.id]"
                                        >
                                            <Field name="price"
                                                   class="form-control"
                                                   type="number"
                                                   min="0"
                                                   placeholder="Ár"
                                                   :value="product.price"
                                            />
                                            <ErrorMessage name="price" />
                                        </div>
                                    </div>

                                    <div>
                                        <strong>ÁFA%: </strong>

                                        <span v-if="! this.editableProducts[product.id]">
                                            {{ product.tax_percentage }}
                                        </span>

                                        <div class="form-group"
                                             v-if="!! this.editableProducts[product.id]"
                                        >
                                            <Field name="tax_percentage"
                                                   class="form-control"
                                                   type="number"
                                                   min="0"
                                                   placeholder="ÁFA%"
                                                   :value="product.tax_percentage"
                                            />
                                            <ErrorMessage name="tax_percentage" />
                                        </div>
                                    </div>

                                    <div>
                                        <label :for="'brandSelect' + product.id">
                                            <strong>Márka:</strong>
                                        </label>

                                        <span v-if="! this.editableProducts[product.id] && product.brand">
                                            {{ product.brand.title }}
                                        </span>

                                        <span v-else-if="! this.editableProducts[product.id]">
                                            Nincs márka hozzárendelve.
                                        </span>

                                        <div class="form-group"
                                             v-if="!! this.editableProducts[product.id]"
                                        >
                                            <Field name="brand_id"
                                                   as="select"
                                                   class="form-control"
                                                   id="brandSelect"
                                            >
                                                <option value="" disabled>Válassz egyet</option>

                                                <option v-for="brand in brands"
                                                        :value="brand.id"
                                                        :selected="product.brand && product.brand.id == brand.id"
                                                        selected
                                                >
                                                    {{ brand.title }}
                                                </option>
                                            </Field>
                                            <ErrorMessage name="brand_id" />
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-2">
                                        <button type="button"
                                                class="btn btn-danger mr-10px"
                                                @click="deleteProduct(product)"
                                                v-if="! this.editableProducts[product.id]"
                                        >
                                            Törlés
                                        </button>

                                        <button type="button"
                                                class="btn btn-outline-primary mr-10px"
                                                @click="editProduct(product)"
                                                v-if="! this.editableProducts[product.id]"
                                        >
                                            Szerkesztés
                                        </button>

                                        <button type="button"
                                                class="btn btn-outline-danger mr-10px"
                                                @click="editProduct(product)"
                                                v-if="!! this.editableProducts[product.id]"
                                        >
                                            Mégse
                                        </button>

                                        <button type="submit"
                                                class="btn btn-primary"
                                                v-if="!! this.editableProducts[product.id]"
                                        >
                                            Mentés
                                        </button>
                                    </div>
                                    <hr>
                                </div>
                            </Form>
                        </div>

                        <Form @submit="createProduct" :validation-schema="schema" v-if="showNewProductForm">
                            <Field name="storage_id"
                                   type="hidden"
                                   v-model="storage.id"
                            />

                            <div class="form-group">
                                <Field name="title"
                                       class="form-control"
                                       type="text"
                                       placeholder="Megnevezés"
                                />
                                <ErrorMessage name="title" />
                            </div>

                            <div class="form-group mt-2">
                                <Field name="sku"
                                       class="form-control"
                                       type="text"
                                       placeholder="Cikkszám"
                                />
                                <ErrorMessage name="sku" />
                            </div>

                            <div class="form-group mt-2">
                                <Field name="price"
                                       class="form-control"
                                       type="number"
                                       min="1"
                                       placeholder="Ár"
                                />
                                <ErrorMessage name="price" />
                            </div>

                            <div class="form-group mt-2">
                                <Field name="tax_percentage"
                                       class="form-control"
                                       type="number"
                                       min="1"
                                       placeholder="ÁFA%"
                                />
                                <ErrorMessage name="tax_percentage" />
                            </div>

                            <div class="form-group mt-2">
                                <label for="brandSelect">Márka</label>
                                <Field name="brand_id"
                                       as="select"
                                       class="form-control"
                                       id="brandSelect"
                                >
                                    <option value="" disabled>Válassz egyet</option>
                                    <option v-for="brand in brands"
                                            :value="brand.id"
                                    >
                                        {{ brand.title }}
                                    </option>
                                </Field>
                                <ErrorMessage name="brand_id" />
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
        'existingProducts',
        'storage',
        'brands',
    ],

    components: {
        Field,
        Form,
        ErrorMessage,
    },

    data: function () {
        return {
            products: this.existingProducts,
            showNewProductForm: false,
            schema: yup.object({
                title: yup.string().required('A megnevezés megadása kötelező!'),
                sku: yup.string().required('A cikkszám megadása kötelező!'),
                price: yup.number()
                    .required('A cikkszám megadása kötelező!')
                    .positive('A cikkszámnak pozitív számnak kell lennie!')
                    .integer('A cikkszámnak számnak kell lennie!'),
                tax_percentage: yup.number()
                    .required('Az ÁFA% megadása kötelező!')
                    .positive('A ÁFA%-nak pozitív számnak kell lennie!')
                    .integer('A ÁFA%-nak számnak kell lennie!'),
                brand_id: yup.number(),
                storage_id: yup.number(),
            }),
            editableProducts: [],
        }
    },

    mounted() {
        this.keyProductsById();

        let self = this;
        Object.values(this.products).forEach(function (product) {
            self.setBrandIdValueInFormCorrectly(product);
        });
    },

    methods: {
        createProduct(values) {
            let self = this;

            axios({
                method: 'post',
                url: route('product.store'),
                responseType: 'stream',
                data: values
            })
                .then(function (response) {
                    self.products = Object.values(self.products).concat(response.data.data);

                    self.keyProductsById();
                });
        },

        deleteProduct(product) {
            let self = this;

            axios({
                method: 'delete',
                url: route('product.destroy', {product: product.id}),
                responseType: 'stream',
            })
                .then(function () {
                    self.products = Object.values(self.products).filter(productToDelete => {
                        return productToDelete.id != product.id;
                    })

                    self.keyProductsById();
                });
        },

        editProduct(product) {
            this.editableProducts[product.id] = ! this.editableProducts[product.id];
            this.setBrandIdValueInFormCorrectly(product);
        },

        updateProduct(values) {
            let self = this;

            if (document.querySelector('#isInAbroadCheckbox' + values.id + ':checked')) {
                values.is_in_abroad = true;
            }

            axios({
                method: 'put',
                url: route('product.update', {product: values.id}),
                responseType: 'stream',
                data: values
            })
                .then(function (response) {
                    self.products[values.id] = response.data.data;

                    self.editableProducts[values.id] = false;
                });
        },

        keyProductsById() {
            this.products = _.mapKeys(this.products, function(value) {
                return value.id;
            });
        },

        setBrandIdValueInFormCorrectly(product) {
            if (! product.brand) {
                return;
            }

            let productFormRef = 'productForm' + product.id;

            this.$refs[productFormRef][0].setFieldValue('brand_id', product.brand.id);
        }
    }
}
</script>
