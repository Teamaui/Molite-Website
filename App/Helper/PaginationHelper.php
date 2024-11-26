<?php

namespace App\Helper;

class PaginationHelper
{

    public static function render($currentPage, $totalPages, $baseUrl)
    {
        if ($totalPages < 1) {
            return '';
        }

        $html = '<div class="pagination">';

        if ($currentPage > 1) {
            $html .= '<a href="' . $baseUrl . ($currentPage - 1) . '">Previous</a>';
        } else {
            $html .= '<a class="disabled">Previous</a>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                $html .= '<a class="active">' . $i . '</a>';
            } else {
                $html .= '<a href="' . $baseUrl . $i . '">' . $i . '</a>';
            }
        }

        if ($currentPage < $totalPages) {
            $html .= '<a href="' . $baseUrl . ($currentPage + 1) . '">Next</a>';
        } else {
            $html .= '<a class="disabled">Next</a>';
        }

        $html .= '</div>';
        return $html;
    }

    public static function renderMonth($currentPage, $totalPages, $baseUrl = '?page=', $month = null) {
        if ($totalPages < 1) {
            return '';
        }

        $html = '<div class="pagination">';

        // Tombol Previous
        if ($currentPage > 1) {
            $html .= '<a href="' . $baseUrl . ($currentPage - 1) . '&month=' . $month . '">Previous</a>';
        } else {
            $html .= '<a class="disabled">Previous</a>';
        }

        // Tautan Nomor Halaman
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                $html .= '<a class="active">' . $i . '</a>';
            } else {
                $html .= '<a href="' . $baseUrl . $i . '&month=' . $month . '">' . $i . '</a>';
            }
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

    public static function renderDate($currentPage, $totalPages, $baseUrl = '?page=', $startDate = null, $endDate = null) {
        if ($totalPages < 1) {
            return '';
        }

        $html = '<div class="pagination">';

        // Tombol Previous
        if ($currentPage > 1) {
            $html .= '<a href="' . $baseUrl . ($currentPage - 1) . '&start_date=' . $startDate . '&end_date=' . $endDate . '">Previous</a>';
        } else {
            $html .= '<a class="disabled">Previous</a>';
        }

        // Tautan Nomor Halaman
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                $html .= '<a class="active">' . $i . '</a>';
            } else {
                $html .= '<a href="' . $baseUrl . $i . '&start_date=' . $startDate . '&end_date=' . $endDate . '">' . $i . '</a>';
            }
        }

        // Tombol Next
        if ($currentPage < $totalPages) {
            $html .= '<a href="' . $baseUrl . ($currentPage + 1) . '&start_date=' . $startDate . '&end_date=' . $endDate . '">Next</a>';
        } else {
            $html .= '<a class="disabled">Next</a>';
        }

        $html .= '</div>';
        return $html;
    }

    public static function renderSearch($currentPage, $totalPages, $baseUrl = '?page=', $search = null) {
        if ($totalPages < 1) {
            return '';
        }

        $html = '<div class="pagination">';

        // Tombol Previous
        if ($currentPage > 1) {
            $html .= '<a href="' . $baseUrl . ($currentPage - 1) . '&search=' . urlencode($search) . '">Previous</a>';
        } else {
            $html .= '<a class="disabled">Previous</a>';
        }

        // Tautan Nomor Halaman
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                $html .= '<a class="active">' . $i . '</a>';
            } else {
                $html .= '<a href="' . $baseUrl . $i . '&search=' . urlencode($search) . '">' . $i . '</a>';
            }
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
