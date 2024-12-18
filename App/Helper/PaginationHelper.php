<?php

namespace App\Helper;

class PaginationHelper
{

    public static function render($currentPage, $totalPages, $baseUrl)
    {
        if ($totalPages < 1) {
            return '';
        }

        // Tentukan rentang halaman yang akan ditampilkan (maksimal 5 halaman)
        $pageRange = 5;
        $halfRange = floor($pageRange / 2);

        // Menentukan halaman mulai dan halaman akhir yang akan ditampilkan
        $startPage = max(1, $currentPage - $halfRange);
        $endPage = min($totalPages, $currentPage + $halfRange);

        // Jika rentang lebih kecil dari 5, sesuaikan
        if (($endPage - $startPage) < $pageRange - 1) {
            if ($startPage > 1) {
                $startPage = max(1, $endPage - $pageRange + 1);
            } else {
                $endPage = min($totalPages, $startPage + $pageRange - 1);
            }
        }

        $html = '<div class="pagination">';

        // Tombol Previous
        if ($currentPage > 1) {
            $html .= '<a href="' . $baseUrl . ($currentPage - 1) . '">Previous</a>';
        } else {
            $html .= '<a class="disabled">Previous</a>';
        }

        // Menampilkan halaman pertama dengan "..."
        if ($startPage > 1) {
            $html .= '<a href="' . $baseUrl . '1">1</a>';
            if ($startPage > 2) {
                $html .= '<span class="dots">...</span>';
            }
        }

        // Menampilkan halaman
        for ($i = $startPage; $i <= $endPage; $i++) {
            if ($i == $currentPage) {
                $html .= '<a class="active">' . $i . '</a>';
            } else {
                $html .= '<a href="' . $baseUrl . $i . '">' . $i . '</a>';
            }
        }

        // Menampilkan halaman terakhir dengan "..."
        if ($endPage < $totalPages) {
            if ($endPage < $totalPages - 1) {
                $html .= '<span class="dots">...</span>';
            }
            $html .= '<a href="' . $baseUrl . $totalPages . '">' . $totalPages . '</a>';
        }

        // Tombol Next
        if ($currentPage < $totalPages) {
            $html .= '<a href="' . $baseUrl . ($currentPage + 1) . '">Next</a>';
        } else {
            $html .= '<a class="disabled">Next</a>';
        }

        $html .= '</div>';
        return $html;
    }


    public static function renderMonth($currentPage, $totalPages, $baseUrl = '?page=', $month = null)
    {
        if ($totalPages < 1) {
            return '';
        }

        // Tentukan rentang halaman yang akan ditampilkan (maksimal 5 halaman)
        $pageRange = 5;
        $halfRange = floor($pageRange / 2);

        // Menentukan halaman mulai dan halaman akhir yang akan ditampilkan
        $startPage = max(1, $currentPage - $halfRange);
        $endPage = min($totalPages, $currentPage + $halfRange);

        // Jika rentang lebih kecil dari 5, sesuaikan
        if (($endPage - $startPage) < $pageRange - 1) {
            if ($startPage > 1) {
                $startPage = max(1, $endPage - $pageRange + 1);
            } else {
                $endPage = min($totalPages, $startPage + $pageRange - 1);
            }
        }

        $html = '<div class="pagination">';

        // Tombol Previous
        if ($currentPage > 1) {
            $html .= '<a href="' . $baseUrl . ($currentPage - 1) . '&month=' . $month . '">Previous</a>';
        } else {
            $html .= '<a class="disabled">Previous</a>';
        }

        // Menampilkan halaman pertama dengan "..."
        if ($startPage > 1) {
            $html .= '<a href="' . $baseUrl . '1' . '&month=' . $month . '">1</a>';
            if ($startPage > 2) {
                $html .= '<span class="dots">...</span>';
            }
        }

        // Menampilkan halaman
        for ($i = $startPage; $i <= $endPage; $i++) {
            if ($i == $currentPage) {
                $html .= '<a class="active">' . $i . '</a>';
            } else {
                $html .= '<a href="' . $baseUrl . $i . '&month=' . $month . '">' . $i . '</a>';
            }
        }

        // Menampilkan halaman terakhir dengan "..."
        if ($endPage < $totalPages) {
            if ($endPage < $totalPages - 1) {
                $html .= '<span class="dots">...</span>';
            }
            $html .= '<a href="' . $baseUrl . $totalPages . '&month=' . $month . '">' . $totalPages . '</a>';
        }

        // Tombol Next
        if ($currentPage < $totalPages) {
            $html .= '<a href="' . $baseUrl . ($currentPage + 1) . '&month=' . $month . '">Next</a>';
        } else {
            $html .= '<a class="disabled">Next</a>';
        }

        $html .= '</div>';
        return $html;
    }


    public static function renderDate($currentPage, $totalPages, $baseUrl = '?page=', $startDate = null, $endDate = null, $rows = 10)
    {
        if ($totalPages < 1) {
            return '';
        }

        // Tentukan rentang halaman yang akan ditampilkan (maksimal 5 halaman)
        $pageRange = 5;
        $halfRange = floor($pageRange / 2);

        // Menentukan halaman mulai dan halaman akhir yang akan ditampilkan
        $startPage = max(1, $currentPage - $halfRange);
        $endPage = min($totalPages, $currentPage + $halfRange);

        // Jika rentang lebih kecil dari 5, sesuaikan
        if (($endPage - $startPage) < $pageRange - 1) {
            if ($startPage > 1) {
                $startPage = max(1, $endPage - $pageRange + 1);
            } else {
                $endPage = min($totalPages, $startPage + $pageRange - 1);
            }
        }

        $html = '<div class="pagination">';

        // Tombol Previous
        if ($currentPage > 1) {
            $html .= '<a href="' . $baseUrl . ($currentPage - 1) . '&rows=' . $rows . '&start_date=' . $startDate . '&end_date=' . $endDate . '">Previous</a>';
        } else {
            $html .= '<a class="disabled">Previous</a>';
        }

        // Menampilkan halaman pertama dengan "..."
        if ($startPage > 1) {
            $html .= '<a href="' . $baseUrl . '1' . '&rows=' . $rows . '&start_date=' . $startDate . '&end_date=' . $endDate . '">1</a>';
            if ($startPage > 2) {
                $html .= '<span class="dots">...</span>';
            }
        }

        // Menampilkan halaman
        for ($i = $startPage; $i <= $endPage; $i++) {
            if ($i == $currentPage) {
                $html .= '<a class="active">' . $i . '</a>';
            } else {
                $html .= '<a href="' . $baseUrl . $i . '&rows=' . $rows . '&start_date=' . $startDate . '&end_date=' . $endDate . '">' . $i . '</a>';
            }
        }

        // Menampilkan halaman terakhir dengan "..."
        if ($endPage < $totalPages) {
            if ($endPage < $totalPages - 1) {
                $html .= '<span class="dots">...</span>';
            }
            $html .= '<a href="' . $baseUrl . $totalPages . '&rows=' . $rows . '&start_date=' . $startDate . '&end_date=' . $endDate . '">' . $totalPages . '</a>';
        }

        // Tombol Next
        if ($currentPage < $totalPages) {
            $html .= '<a href="' . $baseUrl . ($currentPage + 1) . '&rows=' . $rows . '&start_date=' . $startDate . '&end_date=' . $endDate . '">Next</a>';
        } else {
            $html .= '<a class="disabled">Next</a>';
        }

        $html .= '</div>';
        return $html;
    }


    public static function renderSearch($currentPage, $totalPages, $baseUrl = '?page=', $search = null)
    {
        if ($totalPages < 1) {
            return '';
        }

        // Tentukan rentang halaman yang akan ditampilkan (maksimal 5 halaman)
        $pageRange = 5;
        $halfRange = floor($pageRange / 2);

        // Menentukan halaman mulai dan halaman akhir yang akan ditampilkan
        $startPage = max(1, $currentPage - $halfRange);
        $endPage = min($totalPages, $currentPage + $halfRange);

        // Jika rentang lebih kecil dari 5, sesuaikan
        if (($endPage - $startPage) < $pageRange - 1) {
            if ($startPage > 1) {
                $startPage = max(1, $endPage - $pageRange + 1);
            } else {
                $endPage = min($totalPages, $startPage + $pageRange - 1);
            }
        }

        $html = '<div class="pagination">';

        // Tombol Previous
        if ($currentPage > 1) {
            $html .= '<a href="' . $baseUrl . ($currentPage - 1) . '&search=' . urlencode($search) . '">Previous</a>';
        } else {
            $html .= '<a class="disabled">Previous</a>';
        }

        // Menampilkan halaman pertama dengan "..."
        if ($startPage > 1) {
            $html .= '<a href="' . $baseUrl . '1' . '&search=' . urlencode($search) . '">1</a>';
            if ($startPage > 2) {
                $html .= '<span class="dots">...</span>';
            }
        }

        // Menampilkan halaman
        for ($i = $startPage; $i <= $endPage; $i++) {
            if ($i == $currentPage) {
                $html .= '<a class="active">' . $i . '</a>';
            } else {
                $html .= '<a href="' . $baseUrl . $i . '&search=' . urlencode($search) . '">' . $i . '</a>';
            }
        }

        // Menampilkan halaman terakhir dengan "..."
        if ($endPage < $totalPages) {
            if ($endPage < $totalPages - 1) {
                $html .= '<span class="dots">...</span>';
            }
            $html .= '<a href="' . $baseUrl . $totalPages . '&search=' . urlencode($search) . '">' . $totalPages . '</a>';
        }

        // Tombol Next
        if ($currentPage < $totalPages) {
            $html .= '<a href="' . $baseUrl . ($currentPage + 1) . '&search=' . urlencode($search) . '">Next</a>';
        } else {
            $html .= '<a class="disabled">Next</a>';
        }

        $html .= '</div>';
        return $html;
    }
}
