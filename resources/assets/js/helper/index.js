import axios from "axios"

class Helper {
    static getBaseURL() {
        const url = new URL(location)
        return url.origin
    }

    static deepCopy(object) {
        return JSON.parse(JSON.stringify(object))
    }

    static axios() {
        axios.defaults.baseURL = Helper.getBaseURL()
        return axios
    }

    static currencyFormat(value) {
        const options = {
            style: "currency",
            currency: "IDR",
            maximumFractionDigits: 0,
        }

        return Number(value).toLocaleString("id-ID", options)
    }

    static dateFormat(value, format = {}) {
        const date = new Date(value * 1000)
        return date.toLocaleDateString("id-ID", format)
    }

    static phoneFormat(value) {
        if (value) {
            const splitted = value.match(/.{1,3}/g)
            return splitted.join('-')
        }
        return value
    }

    static unitFormat(value) {
        let text = ' unit'
        if (value) {
            if (Number(value) > 1) {
                text = ' units'
            }
        } else {
            value = 0
        }

        return value + text
    }

    static getMixins() {
        // TODO: (Documentation) Desctructurize line below and put note on every steps later for better readability.
        const methods = Object.fromEntries(
            Object.getOwnPropertyNames(Helper)
                .filter(name => !['length', 'name', 'prototype'].includes(name))
                .map(name => [name, Helper[name]])
        )
        return { methods }
    }
}

const mixin = Helper.getMixins()
export { Helper as default, mixin }