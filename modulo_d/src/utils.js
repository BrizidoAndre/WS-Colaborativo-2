import {reactive} from "vue";

export async function request(url, options, header = null) {
    return await fetch('http://172.16.66.36/modulo_d_SP/server/api/v1/' + url, {
        headers: {
            "Content-Type": "application/json",
            ...header,
        },
        ...options
    })
}
export async function requestWithoutHeaders(url, options, header = null) {
    return await fetch('http://172.16.66.36/modulo_d_SP/server/api/v1/' + url, {
    // return await fetch('http://localhost/modulo_d_SP/server/api/v1/' + url, {
        ...options
    })
}


export const siteInfo = reactive({
    isWhiteTheme: true,
    userToken: undefined,
    userEmail: undefined,
    clearUser: ()=>{
        this.userToken = null;
        this.userEmail = null;
    }
})

export function debug(message) {
    console.log(JSON.parse(JSON.stringify(message)));
}