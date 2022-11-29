<template>
    <app-layout>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-wrap sm:flex-no-wrap items-center mb-2">
                        <inertia-link
                            v-if="$can([{name: 'create programs'}])"
                            class="bg-indigo-500 p-2 hover:bg-indigo-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
                            :href="route('programs.create')"
                        >
                            Crear programa
                        </inertia-link>
                    </div>
                    <div class="bg-white rounded shadow overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr>
                                    <th class="py-2 px-2">Nombre</th>
                                    <th class="py-2 px-2">Owner</th>
                                    <th class="py-2 px-2">Alta</th>
                                    <th class="py-2 px-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="program in programs.data" :key="program.id">
                                    <td class="border-t py-3 px-3">
                                        <a href="" class="text-center font-medium whitespace-no-wrap">
                                            {{ program.name }}
                                        </a>
                                    </td>
                                    <td class="border-t">
                                        <a href="" class="text-center font-medium whitespace-no-wrap">
                                            {{ program.user_id }}
                                        </a>
                                    </td>
                                    <td class="border-t">{{ program.created_at }}</td>
                                    <td class="border-t w-56">
                                        <div class="flex justify-center items-center">
                                            <inertia-link
                                                :href="route('programs.show', program.id)"
                                                class="disabled text-xs px-4 py-2 rounded-full bg-gray-200 hover:bg-hp-400 hover:text-black text-gray-800 inline-flex items-center"
                                                v-if="!program.deleted_at && $can([{name: 'show programs'}, {name: 'show own programs', owner: program.user_id}])"
                                            >
                                                Detalle
                                            </inertia-link>
                                            <inertia-link
                                                :href="route('programs.edit', program.id)"
                                                class="disabled text-xs px-4 py-2 rounded-full bg-gray-200 hover:bg-hp-400 hover:text-black text-gray-800 inline-flex items-center"
                                                v-if="!program.deleted_at && $can([{name: 'update programs'}, {name: 'update own programs', owner: program.user_id}])"
                                            >
                                                Editar
                                            </inertia-link>
                                            <button
                                                class="text-xs px-4 py-2 rounded-full bg-red-200 hover:bg-hp-400 hover:text-black text-gray-800 inline-flex items-center"
                                                v-if="!program.deleted_at && $can([{name: 'delete programs'}, {name: 'delete own programs', owner: program.user_id}])"
                                                @click="remove(program)"
                                            >
                                                Borrar
                                            </button>
                                            <button
                                                class="text-xs px-4 py-2 rounded-full bg-red-200 hover:bg-hp-400 hover:text-black text-gray-800 inline-flex items-center"
                                                v-if="program.deleted_at && $can([{name: 'restore programs'}, {name: 'restore own programs', owner: program.user_id}])"
                                                @click="restore(program)"
                                            >
                                                Restaurar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </nav>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout.vue";
    export default {
        name: "Programs",
        components: {AppLayout},
        props: ["programs"],
        methods: {
            remove(program) {
                const formData = new FormData;
                formData.append("_method", "DELETE");
                this.$inertia.post(this.route("programs.destroy", program.id), formData)
                    .then(() => {})
            },
            restore(program) {
                const formData = new FormData;
                formData.append("_method", "PUT");
                this.$inertia.post(this.route("programs.restore", program.id), formData)
                    .then(() => {})
            }
        }
    }
</script>
