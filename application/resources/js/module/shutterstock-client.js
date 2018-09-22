/*
 * @copyright itsyndicate
 *
 * All rights reserved
 *
 * :: strict mode only ::
 */
'use strict';

/** @import */
import ShutterStockClient from '../src/ShutterStockClient';
import Image from '../src/Image';
import Vue from 'vue';

/** @const */
const
    MODULE_SELECTOR = '#shutterstock-query-form';

if (document.querySelector(MODULE_SELECTOR)) {
    new Vue({
        el: MODULE_SELECTOR,
        data: {
            query: null,
            dataLoaded: false,
            result: [],

            form: null
        },

        methods: {
            /**
             * Экшен нажатия кнопки загрузки
             */
            loadResult() {
                this.retrieveImagesFromShutterStock();
            },

            /**
             * Загрузка данных из ShutterStock
             */
            retrieveImagesFromShutterStock() {
                if (!this.query) {
                    return;
                }

                ShutterStockClient.searchImagesByQuery(this.query)
                    .then(response => {
                        if (response.total_count === 0) {
                            alert('No Results');
                            return;
                        }

                        this.result = response.data.map((image) => {
                            return new Image(image.assets.preview, image.assets.huge_thumb);
                        });
                        this.dataLoaded = true;
                    });
            }
        },

        mounted() {
            this.form = document.querySelector(MODULE_SELECTOR + ' form');
        }
    });
}