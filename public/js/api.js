const callApi = async (method, url, data) => {
    return axios({method, url, data})
}

const displayMessage = async (type, title, message) => {
    return Swal.fire(title, message, type)
}