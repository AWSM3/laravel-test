/*
 * @copyright itsyndicate
 * @description 
 *
 * All rights reserved
 *
 * :: strict mode only ::
 */
'use strict';

/** @import */
import $ from 'jquery';

/** @const */
const
    API_URL = 'https://api.shutterstock.com/v2',

    MIX_SHUTTERSTOCK_CLIENT_ID = process.env.MIX_SHUTTERSTOCK_CLIENT_ID,
    MIX_SHUTTERSTOCK_CLIENT_SECRET = process.env.MIX_SHUTTERSTOCK_CLIENT_SECRET;

/** @export */
export default class ShutterStockClient {
    /**
     * Base 64 encode Client ID and Client Secret for use in the Authorization header
     *
     * @return String
     */
    static encodeAuthorization() {
        return 'Basic ' + window.btoa(MIX_SHUTTERSTOCK_CLIENT_ID + ':' + MIX_SHUTTERSTOCK_CLIENT_SECRET);
    }

    /**
     * @return {Object}
     */
    static composeQueryOptions(options) {
        let defaultOptions = {
            headers: {
                Authorization: this.encodeAuthorization(),
            }
        };

        return Object.assign({}, defaultOptions, options)
    }

    /**
     * @param query
     * @param perPage
     */
    static searchImagesByQuery(query, perPage = 20) {
        let options = this.composeQueryOptions({params: {query, per_page: perPage}});
        return $.ajax({
                url: API_URL + '/images/search',
                data: {query, per_page: perPage},
                headers: {
                    Authorization: this.encodeAuthorization()
                }
            })
            .done(data => {
                return Promise.resolve(data);
            })
            .fail((xhr, status, err) => {
                console.log('Failed');
            });
    }
}