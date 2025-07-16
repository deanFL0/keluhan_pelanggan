<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div
                        class="card-header d-flex align-items-center"
                        style="gap: 1rem"
                    >
                        <span>Keluhan Pelanggan</span>
                        <div class="flex-grow-1"></div>
                        <div
                            v-if="showMessage"
                            class="alert alert-success mb-0 py-1 px-3"
                            style="white-space: nowrap; font-size: 0.95em"
                        >
                            {{ message }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="flex flex-row">
                            <div
                                class="d-flex align-items-center mb-3"
                                style="gap: 1rem"
                            >
                                <router-link
                                    :to="{ name: 'create_keluhan_pelanggan' }"
                                >
                                    <button class="btn btn-primary">
                                        Buat Keluhan +
                                    </button>
                                </router-link>
                                <div class="flex-grow-1"></div>
                                <div class="dropdown">
                                    <button
                                        class="btn btn-outline-secondary dropdown-toggle"
                                        type="button"
                                        id="exportDropdown"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        Export
                                    </button>
                                    <ul
                                        class="dropdown-menu"
                                        aria-labelledby="exportDropdown"
                                    >
                                        <li>
                                            <a
                                                class="dropdown-item"
                                                href="#"
                                                @click.prevent="
                                                    exportData('txt')
                                                "
                                                >Text (.txt)</a
                                            >
                                        </li>
                                        <li>
                                            <a
                                                class="dropdown-item"
                                                href="#"
                                                @click.prevent="
                                                    exportData('csv')
                                                "
                                                >CSV (.csv)</a
                                            >
                                        </li>
                                        <li>
                                            <a
                                                class="dropdown-item"
                                                href="#"
                                                @click.prevent="
                                                    exportData('xls')
                                                "
                                                >Excel (.xls)</a
                                            >
                                        </li>
                                        <li>
                                            <a
                                                class="dropdown-item"
                                                href="#"
                                                @click.prevent="
                                                    exportData('pdf')
                                                "
                                                >PDF (.pdf)</a
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="flex-1 mt-3">
                                <!-- Table -->
                                <div
                                    class="table-responsive"
                                    style="max-height: 65vh; overflow: auto"
                                >
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama Pelanggan</th>
                                                <th>Email</th>
                                                <th>Nomor HP</th>
                                                <th>Status</th>
                                                <th>Keluhan</th>
                                                <th class="sticky-col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="item in keluhanList"
                                                :key="item.id"
                                            >
                                                <td>{{ item.id }}</td>
                                                <td class="noshrink">
                                                    {{ item.nama }}
                                                </td>
                                                <td class="noshrink">
                                                    {{ item.email }}
                                                </td>
                                                <td class="noshrink">
                                                    {{ item.nomor_hp }}
                                                </td>
                                                <td class="noshrink">
                                                    <span
                                                        class="badge"
                                                        :style="{
                                                            backgroundColor:
                                                                statusMap[
                                                                    item.status_keluhan
                                                                ]?.color,
                                                            color: '#fff',
                                                        }"
                                                    >
                                                        {{
                                                            statusMap[
                                                                item.status_keluhan
                                                            ]?.label
                                                        }}
                                                    </span>
                                                </td>
                                                <td>{{ item.keluhan }}</td>
                                                <td class="noshrink sticky-col">
                                                    <div
                                                        class="btn-group gap-2"
                                                    >
                                                        <router-link
                                                            :to="{
                                                                name: 'detail_keluhan_pelanggan',
                                                                params: {
                                                                    id: item.id,
                                                                },
                                                            }"
                                                        >
                                                            <button
                                                                class="btn btn-info btn-sm"
                                                            >
                                                                Detail
                                                            </button>
                                                        </router-link>
                                                        <router-link
                                                            :to="{
                                                                name: 'edit_keluhan_pelanggan',
                                                                params: {
                                                                    id: item.id,
                                                                },
                                                            }"
                                                        >
                                                            <button
                                                                class="btn btn-primary btn-sm"
                                                            >
                                                                Edit
                                                            </button>
                                                        </router-link>
                                                        <button
                                                            class="btn btn-danger btn-sm"
                                                            @click="
                                                                confirmDelete(
                                                                    item.id
                                                                )
                                                            "
                                                        >
                                                            Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="pagination mt-3 gap-2">
                                    <button
                                        class="btn btn-secondary"
                                        :disabled="pagination.current_page <= 1"
                                        @click="changePage(1)"
                                    >
                                        First
                                    </button>
                                    <button
                                        class="btn btn-secondary"
                                        :disabled="pagination.current_page <= 1"
                                        @click="
                                            changePage(
                                                pagination.current_page - 1
                                            )
                                        "
                                    >
                                        Previous
                                    </button>
                                    <span
                                        >Page {{ pagination.current_page }} of
                                        {{ pagination.last_page }}</span
                                    >
                                    <button
                                        class="btn btn-secondary"
                                        :disabled="
                                            pagination.current_page >=
                                            pagination.last_page
                                        "
                                        @click="
                                            changePage(
                                                pagination.current_page + 1
                                            )
                                        "
                                    >
                                        Next
                                    </button>
                                    <button
                                        class="btn btn-secondary"
                                        :disabled="
                                            pagination.current_page >=
                                            pagination.last_page
                                        "
                                        @click="
                                            changePage(pagination.last_page)
                                        "
                                    >
                                        Last
                                    </button>
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
import { statusMap } from "../constant/constant";
import {
    deleteKeluhanPelanggan,
    fetchKeluhanPelanggan,
    exportKeluhanPelanggan,
} from "../services/KeluhanPelanggan";

export default {
    data() {
        return {
            statusMap,
            keluhanList: [],
            pagination: {
                current_page: 1,
                last_page: 1,
                prev_page_url: null,
                next_page_url: null,
            },
            showMessage: false,
            message: "",
        };
    },
    mounted() {
        if (this.$route.query.success) {
            this.message = this.$route.query.success;
            this.showMessage = true;
            this.$router.replace({ query: {} });
            setTimeout(() => {
                this.showMessage = false;
                this.message = this.$route.query.success;
            }, 3000);
        }
        this.getKeluhanList(1);
    },
    methods: {
        getKeluhanList(page = 1) {
            fetchKeluhanPelanggan(page).then((response) => {
                this.keluhanList = response.data.data;
                this.pagination = {
                    current_page: response.data.meta.current_page,
                    last_page: response.data.meta.last_page,
                    prev_page_url: response.data.links.prev,
                    next_page_url: response.data.links.next,
                    links: response.data.meta.links,
                };
            });
        },
        confirmDelete(id) {
            if (confirm("Apakah Anda yakin ingin menghapus keluhan ini?")) {
                this.deleteKeluhan(id);
            }
        },
        async deleteKeluhan(id) {
            try {
                await deleteKeluhanPelanggan(id);
                this.getKeluhanList(this.pagination.current_page);
                alert("Keluhan berhasil dihapus.");
            } catch (e) {
                alert("Gagal menghapus keluhan. Silakan coba lagi.");
            }
        },
        changePage(page) {
            this.getKeluhanList(page);
        },
        async exportData(format) {
            try {
                const response = await exportKeluhanPelanggan(format);

                const disposition = response.headers["content-disposition"];
                let fileName = `keluhan_pelanggan.${format}`;

                if (disposition && disposition.indexOf("filename=") !== -1) {
                    const match = disposition.match(
                        /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/
                    );
                    if (match && match[1]) {
                        fileName = match[1].replace(/['"]/g, "");
                    }
                }

                const blob = new Blob([response.data], {
                    type: response.headers["content-type"],
                });

                const link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = fileName;
                link.click();
                window.URL.revokeObjectURL(link.href);
            } catch (error) {
                alert("Gagal mengekspor data. Silakan coba lagi.");
            }
        },
    },
};
</script>

<style>
.noshrink {
    white-space: nowrap;
}
.sticky-col {
    position: sticky;
    right: 0;
    background-color: white;
    z-index: 2;
}
</style>
