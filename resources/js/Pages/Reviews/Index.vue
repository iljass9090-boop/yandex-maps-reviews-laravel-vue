<script setup>
import { computed, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();

const allReviews = computed(() => page.props.reviews || []);
const totalReviews = computed(() => page.props.totalReviews || 0);
const averageRating = computed(() => page.props.averageRating || 0);

// Параметры пагинации
const perPage = 2; // сколько отзывов на страницу
const currentPage = ref(1);

const totalPages = computed(() => {
    return Math.max(1, Math.ceil(allReviews.value.length / perPage));
});

const paginatedReviews = computed(() => {
    const start = (currentPage.value - 1) * perPage;
    const end = start + perPage;
    return allReviews.value.slice(start, end);
});

const canPrev = computed(() => currentPage.value > 1);
const canNext = computed(() => currentPage.value < totalPages.value);

function goPrev() {
    if (canPrev.value) {
        currentPage.value -= 1;
    }
}

function goNext() {
    if (canNext.value) {
        currentPage.value += 1;
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Отзывы" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Отзывы с Яндекс Карт
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Блок с рейтингом и общей информацией -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Общий рейтинг
                            </h3>
                            <p class="mt-1 text-3xl font-bold text-yellow-400">
                                {{ averageRating }}
                                <span class="text-base text-gray-500 dark:text-gray-400 ml-1">
                                    из 5
                                </span>
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Всего отзывов
                            </h3>
                            <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                {{ totalReviews }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Список отзывов + сортировка/пагинация -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Список отзывов
                        </h3>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Сортировка: по новизне (сначала новые)
                        </div>
                    </div>

                    <div v-if="allReviews.length === 0" class="text-gray-500 dark:text-gray-400">
                        Отзывов пока нет.
                    </div>

                    <div v-else class="space-y-4">
                        <!-- Текущая страница отзывов -->
                        <div
                            v-for="(review, index) in paginatedReviews"
                            :key="index"
                            class="border border-gray-200 dark:border-gray-700 rounded-lg p-4"
                        >
                            <div class="flex items-center justify-between mb-2">
                                <div class="font-semibold text-gray-900 dark:text-gray-100">
                                    {{ review.author }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ review.date }}
                                </div>
                            </div>

                            <div class="flex items-center mb-2">
                                <div class="flex items-center">
                                    <span
                                        v-for="star in 5"
                                        :key="star"
                                        class="text-yellow-400"
                                    >
                                        {{ star <= review.rating ? '★' : '☆' }}
                                    </span>
                                </div>
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">
                                    {{ review.rating }} / 5
                                </span>
                            </div>

                            <p class="text-gray-800 dark:text-gray-200">
                                {{ review.text }}
                            </p>
                        </div>

                        <!-- Пагинация -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                Страница {{ currentPage }} из {{ totalPages }}
                            </div>
                            <div class="flex gap-2">
                                <button
                                    type="button"
                                    @click="goPrev"
                                    :disabled="!canPrev"
                                    class="px-3 py-1 text-sm rounded-md border border-gray-300 dark:border-gray-600
                                           text-gray-700 dark:text-gray-200
                                           bg-white dark:bg-gray-800
                                           disabled:opacity-50 disabled:cursor-not-allowed
                                           hover:bg-gray-100 dark:hover:bg-gray-700"
                                >
                                    Назад
                                </button>
                                <button
                                    type="button"
                                    @click="goNext"
                                    :disabled="!canNext"
                                    class="px-3 py-1 text-sm rounded-md border border-gray-300 dark:border-gray-600
                                           text-gray-700 dark:text-gray-200
                                           bg-white dark:bg-gray-800
                                           disabled:opacity-50 disabled:cursor-not-allowed
                                           hover:bg-gray-100 dark:hover:bg-gray-700"
                                >
                                    Вперёд
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
