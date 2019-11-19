function maskCPF(cpf) {
    return cpf.substr(0, 3) + "." + cpf.substr(3, 3) + "." + cpf.substr(6, 3) + "-" + cpf.substr(-2)
}

function maskData(data) {
    dataFormat = new Date(data)
    return dataFormat.getDate() + '/' + (dataFormat.getMonth() + 1) + '/' + dataFormat.getFullYear()
}

function maskTelefone(tel) {
    if (tel.length < 11) {
        return "(" + tel.substr(0, 2) + ") " + tel.substr(2, 4) + "-" + tel.substr(-4)
    } else {
        return "(" + tel.substr(0, 2) + ") " + tel.substr(2, 5) + "-" + tel.substr(-4)
    }
}

function maskCep(cep) {
    return cep.substr(0, 5) + "-" + cep.substr(-3)
}