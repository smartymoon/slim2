<?php
namespace lib;
class Page{
    //base data
    private $total = 0;
    private $rows =  0;
    private $current = 0;
    private $baseUrl = '/';

    //buttons
    private $first = 1;
    private $last = 0;
    private $prev = 0;
    private $next = 0;

    //number page list
    private $pages = array();
    private $totalPage;

    //result
    public $html = '';

    /**
     * Page constructor.
     * @param $total
     * @param $rows
     * @param $current
     * @param $baseUrl
     */
    public  function __construct($total, $rows, $current,$baseUrl)
    {

        $this->total = $total;
        $this->rows = $rows;
        $this->current = $current;
        $this->baseUrl = $baseUrl;
        $this->initButtons();
        $this->pages = $this->initNumbers();

        $this->firstUrl = $this->baseUrl.'/'.$this->first;
        $this->lastUrl  =  $this->baseUrl.'/'.$this->last;

        $this->prevUrl   = $this->baseUrl.'/'.$this->prev;
        $this->nextUrl     = $this->baseUrl.'/'.$this->next;

        $this->html = $this->makeHtml();
    }



    // page = 0 means no show
    private function initButtons()
    {
       $this->last =  ceil($this->total / $this->rows); //always there
       $this->totalPage = $this->last;

       $this->prev =  $this->current - 1; //if prev 0 , set class no active
       $this->next =  $this->last == $this->current? 0: $this->current+1;

    }

    //显示数字, 展示７个数字
    private function initNumbers()
    {
        //第一步，确定current page 位置, first middle last
        $pages = array();

        $number_button_count = $this->totalPage > 7? 7: $this->totalPage;
        if($this->current == $this->first){
            for($i = 0;$i<$number_button_count;$i++){
                $pages[$i] = $i+1;
            }
            return $pages;
        }

        if($this->current == $this->last){
            $current = $this->current;
            for($i = $number_button_count;$i>0;$i--){
               $pages[$i] = $current;
               $current--;
            }
            return $pages;
        }

        //middle
        $first = $this->current-1;
        for($i = 0;$i<($this->totalPage - $this->current + 2);$i++){
            $pages[$i] = $first;
            $first++;
        }
        return $pages;
    }

    public function makeHtml(){
        $html = '<div class="row"><div class="col-sm-5"></div>';
        $html .= '<div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers"><ul class="pagination">';
        $html .= "<li class='paginate_button previous '><a href='{$this->firstUrl}' aria-controls='example2' data-dt-idx='0' tabindex='0'>首页</a></li>";
        if($this->prev){
            $html .= "<li class='paginate_button '><a href='{$this->prevUrl}' aria-controls='example2' data-dt-idx='2' tabindex='0'>上一页</a></li>";
        }
        foreach($this->pages as $page){
            $html .= "<li class='paginate_button '><a href='{$this->baseUrl}"."/$page"."' aria-controls='example2' data-dt-idx='2' tabindex='0'>{$page}</a></li>";
        }
        if($this->next){
            $html .= "<li class='paginate_button '><a href='{$this->nextUrl}' aria-controls='example2' data-dt-idx='2' tabindex='0'>下一页</a></li>";
        }
        $html .= "<li class='paginate_button next'><a href='{$this->lastUrl}' aria-controls='example2' data-dt-idx='0' tabindex='0'>尾页</a></li>";
        return $html;
    }
}