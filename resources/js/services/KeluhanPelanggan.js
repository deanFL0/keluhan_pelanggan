import axios from "axios";

export function fetchKeluhanPelanggan(page = 1, perPage = 20) {
    return axios.get('/api/keluhan-pelanggan?per_page=' + perPage + '&page=' + page);
}

export function fetchKeluhanPelangganById(id) {
    return axios.get(`/api/keluhan-pelanggan/${id}`);
}

export function createKeluhanPelanggan(data) {
    return axios.post('/api/keluhan-pelanggan', data);
}

export function updateKeluhanPelanggan(id, data) {
    return axios.put(`/api/keluhan-pelanggan/${id}`, data);
}

export function deleteKeluhanPelanggan(id) {
    return axios.delete(`/api/keluhan-pelanggan/${id}`);
}

export function exportKeluhanPelanggan(format) {
    return axios.get(`/api/keluhan-pelanggan/export/${format}`, {
        responseType: 'blob',
        headers: {
            'Accept': 'application/octet-stream'
        }
    });
}