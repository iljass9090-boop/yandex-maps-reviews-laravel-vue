<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewsController extends Controller
{
    public function index(Request $request)
    {
        // Мок‑данные — временно, вместо реальных отзывов с Яндекса
        $reviews = [
            [
                'author' => 'Иван Петров',
                'rating' => 5,
                'date' => '2025-01-10',
                'text' => 'Отличный сервис, всё быстро и качественно.',
            ],
            [
                'author' => 'Анна Смирнова',
                'rating' => 4,
                'date' => '2025-01-05',
                'text' => 'В целом понравилось, но были небольшие задержки.',
            ],
            [
                'author' => 'Сергей Иванов',
                'rating' => 3,
                'date' => '2024-12-20',
                'text' => 'Нормально, но можно улучшить обслуживание.',
            ],
        ];

        // Подсчёт общего количества и среднего рейтинга
        $totalReviews = count($reviews);
        $averageRating = $totalReviews > 0
            ? round(array_sum(array_column($reviews, 'rating')) / $totalReviews, 1)
            : 0;

        // Сортировка по новизне (по дате)
        usort($reviews, function ($a, $b) {
            return strcmp($b['date'], $a['date']); // сначала новые
        });

        return Inertia::render('Reviews/Index', [
            'reviews' => $reviews,
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating,
        ]);
    }
}
