/*
 * @copyright itsyndicate
 * @description 
 *
 * All rights reserved
 *
 * :: strict mode only ::
 */
'use strict';

/** @export */
export default class Image {
    constructor(preview, src) {
        this.preview = preview;
        this.src = src;
    }

    getPreview() {
        return this.preview;
    }

    getSrc() {
        return this.src;
    }
}