<template>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div
                        class="card-header d-flex justify-content-between align-items-center"
                    >
                        <span>Detail Keluhan Pelanggan</span>
                        <router-link
                            :to="{ name: 'keluhan_pelanggan' }"
                            class="btn btn-secondary btn-sm"
                        >
                            ← Kembali
                        </router-link>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 180px">ID</th>
                                    <td>{{ keluhan.id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nama Pelanggan</th>
                                    <td>{{ keluhan.nama }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td>{{ keluhan.email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nomor HP</th>
                                    <td>{{ keluhan.nomor_hp }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Status Saat ini</th>
                                    <td>
                                        <span
                                            class="badge"
                                            :style="{
                                                backgroundColor:
                                                    statusMap[
                                                        keluhan.status_keluhan
                                                    ]?.color,
                                                color: '#fff',
                                            }"
                                        >
                                            {{
                                                statusMap[keluhan.status_keluhan]
                                                    ?.label
                                            }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Keluhan</th>
                                    <td>{{ keluhan.keluhan }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Dibuat Pada</th>
                                    <td>
                                        {{ formatDate(keluhan.created_at) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="my-4" />

                    <h5 class="mb-3">Riwayat Status</h5>
                    <ul class="list-group">
                        <li
                            v-for="(status, index) in keluhan.status_history"
                            :key="index"
                            class="list-group-item d-flex justify-content-between align-items-start"
                        >
                            <div
                                class="d-flex justify-content-between align-items-center"
                            >
                                <div class="fw-bold">
                                    {{
                                        statusMap[status.status_keluhan]?.label ||
                                        "Unknown"
                                    }}
                                </div>
                                <small class="text-muted ms-3">
                                    {{ formatDate(status.updated_at) }}
                                </small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { statusMap } from "../constant/constant";
import { fetchKeluhanPelangganById } from "../services/KeluhanPelanggan";

export default {
    data() {
        return {
            keluhan: {
                status_history: [],
            },
            statusMap,
        };
    },
    mounted() {
        const id = this.$route.params.id;
        this.getKeluhan(id);
    },
    methods: {
        async getKeluhan(id) {
            try {
                const response = await fetchKeluhanPelangganById(id);
                this.keluhan = response.data.data;
                this.keluhan.status_text =
                    this.statusMap[this.keluhan.status_keluhan] || "Unknown";
            } catch (error) {
                this.$toast.error("Gagal memuat detail keluhan.");
            }
        },
        formatDate(datetime) {
            const options = {
                year: "numeric",
                month: "long",
                day: "numeric",
                hour: "2-digit",
                minute: "2-digit",
            };
            return new Date(datetime).toLocaleString("id-ID", options);
        },
    },
};
</script>
