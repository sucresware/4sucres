import axios from 'axios';

let userMeta = document.querySelectorAll("meta[name=user-data]");
let user;

if (userMeta.length) {
    user = JSON.parse(userMeta[0].getAttribute("content"));
}

const AuthedAxios = axios.create({
    baseURL: '/api/v1/',
    headers: {
        'Authorization': 'Bearer ' + (user ? user.api_token : null),
        "Content-Type": "application/json",
        "Accept": "application/json"
    }
});

export default AuthedAxios;
export {
    AuthedAxios,
};
