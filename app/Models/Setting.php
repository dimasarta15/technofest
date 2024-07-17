<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = ['key'];

    public const LABELS = [
        'style_btn_style_one' => 'Style Button 1',
        'style_info_box' => 'Style Info Box',
        'style_image_box' => 'Style Image Box',
        'style_scroll_to_top' => 'Style Scroll to Top',
        'style_selection' => 'Style Selection',
        'style_btn_box' => 'Style Button Box',
        'style_pagination' => 'Style Pagination',
        'style_footer' => 'Style Footer',
        'style_page_title' => 'Style Page Title',
        'style_btn_style_two' => 'Style Button 2',
        'style_scroll_to_top_hover' => 'Style Scroll to Top Hover',
        'style_btn_style_two_hover' => 'Style Button 2 Hover',
        'style_navigation_hover_1' => 'Style Navigation Hover 1',
        'style_navigation_hover_2' => 'Style Navigation Hover 2'
    ];
    
    public const DEFAULT_COLOR =  [
        'style_btn_style_one' => '#ec167f',
        'style_info_box' => '#f20487',
        'style_image_box' => '#682372',
        'style_scroll_to_top' => '#e1137b',
        'style_scroll_to_top_hover' => '#4c35a9',
        'style_selection' => '#ec167f',
        'style_selection' => '#ec167f',
        'style_selection' => '#ec167f',
        'style_btn_box' => '#1d95d2',
        'style_pagination' => '#ec167f',
        'style_footer' => '#101130',
        'style_page_title' => '#232323',
        'style_btn_style_two' => '#faaC1D',
        'style_btn_style_two_hover' => '#faaC1D',
        'style_navigation_hover_1' => '#e1137b',
        'style_navigation_hover_2' => '#e1137b'
    ];

    public function scopeKey($query, $value)
    {
        return $query->where('key', $value)->first();
    }
}
