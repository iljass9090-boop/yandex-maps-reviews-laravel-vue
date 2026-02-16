<script setup>
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

const page = usePage();
const flashSuccess = computed(() => page.props.flash?.success || null);

const props = defineProps({
    yandexIntegration: {
        type: Object,
        default: null,
    },
});

const form = useForm({
    place_url: props.yandexIntegration?.place_url || '',
});

const submit = () => {
    form.post(route('settings.update'));
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Настройки" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Настройки интеграции с Яндекс Картами
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Сообщение об успехе -->
                <div
                    v-if="flashSuccess"
                    class="mb-4 rounded-md bg-green-100 px-4 py-3 text-sm text-green-800 dark:bg-green-900 dark:text-green-100"
                >
                    {{ flashSuccess }}
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="mb-4">
                            Вставьте ссылку на карточку вашей компании в Яндекс.Картах.
                        </p>

                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label
                                    for="place_url"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                                >
                                    Ссылка на карточку в Яндекс.Картах
                                </label>
                                <input
                                    id="place_url"
                                    type="text"
                                    v-model="form.place_url"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500
                                           dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                                    placeholder="https://yandex.ru/maps/..."
                                />
                                <p v-if="form.errors.place_url" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.place_url }}
                                </p>
                            </div>

                            <div>
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                                           rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                           hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800
                                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                                           dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                    :disabled="form.processing"
                                >
                                    Сохранить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
