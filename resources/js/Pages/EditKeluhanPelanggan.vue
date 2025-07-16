<template>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Buat Keluhan Baru</div>
                    <div class="card-body">
                        <div class="flex flex-row">
                            <div>
                                <router-link
                                    :to="{ name: 'keluhan_pelanggan' }"
                                    class="btn btn-secondary mb-3"
                                >
                                    Kembali
                                </router-link>
                            </div>
                            <div class="form-container">
                                <form @submit.prevent="submitForm">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label"
                                            >Nama</label
                                        >
                                        <input
                                            type="text"
                                            v-model="form.nama"
                                            class="form-control"
                                            id="nama"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label"
                                            >Email</label
                                        >
                                        <input
                                            type="email"
                                            v-model="form.email"
                                            class="form-control"
                                            id="email"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_hp" class="form-label"
                                            >Nomor HP</label
                                        >
                                        <input
                                            type="text"
                                            v-model="form.nomor_hp"
                                            class="form-control"
                                            id="nomor_hp"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="status_keluhan"
                                            class="form-label"
                                            >Status Keluhan</label
                                        >
                                        <select
                                            v-model="form.status_keluhan"
                                            class="form-control"
                                            id="status_keluhan"
                                            required
                                        >
                                            <option value="0">Received</option>
                                            <option value="1">
                                                In Process
                                            </option>
                                            <option value="2">Done</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keluhan" class="form-label"
                                            >Keluhan</label
                                        >
                                        <textarea
                                            v-model="form.keluhan"
                                            class="form-control"
                                            id="keluhan"
                                            required
                                        ></textarea>
                                    </div>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Kirim
                                    </button>
                                </form>
                                <div
                                    v-if="error"
                                    class="alert alert-danger mt-3"
                                >
                                    {{ error }}
                                </div>
                                <div
                                    v-if="success"
                                    class="alert alert-success mt-3"
                                >
                                    Keluhan berhasil dikirim!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import {
    fetchKeluhanPelangganById,
    updateKeluhanPelanggan,
} from "../services/KeluhanPelanggan";

export default {
    data() {
        return {
            form: {
                nama: "",
                email: "",
                nomor_hp: "",
                status_keluhan: "0",
                keluhan: "",
            },
            error: "",
            success: false,
        };
    },
    mounted() {
        this.fetchKeluhan();
    },
    methods: {
        async fetchKeluhan() {
            const id = this.$route.params.id;
            try {
                const response = await fetchKeluhanPelangganById(id);
                this.form = {
                    nama: response.data.data.nama,
                    email: response.data.data.email,
                    nomor_hp: response.data.data.nomor_hp,
                    status_keluhan: response.data.data.status_keluhan,
                    keluhan: response.data.data.keluhan,
                };
            } catch (e) {
                this.error = "Gagal memuat data keluhan.";
            }
        },
        async submitForm() {
            this.error = "";
            this.success = false;
            const id = this.$route.params.id;
            try {
                await updateKeluhanPelanggan(id, this.form);
                this.$router.push({
                    name: "keluhan_pelanggan",
                    query: { message: "Keluhan berhasil diperbaharui!" },
                });
            } catch (e) {
                if (e.response && e.response.data && e.response.data.errors) {
                    this.error = Object.values(e.response.data.errors)
                        .flat()
                        .join("\n");
                } else {
                    this.error =
                        e.message ||
                        "Terjadi kesalahan saat memperbaharui data.";
                }
            }
        },
    },
};
</script>
