<?php

use App\DetailExtra;
use App\Extra;
use App\Meta;
use App\Page;
use App\PageDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       for ($i=1; $i < 200; $i++)
       {
           $page = new Page();
           $page->page_id = 0;
           $page->order = 15;
           $page->status = true;
           $page->type = 0;
           $page->save();

           $pd = new PageDetail();
           $pd->page_id = $i;
           $pd->lang_id = 1;
           $pd->name = 'ingilizce isim';
           $pd->content = 'ingilizce içerik';
           $pd->url = 'ingilizce_url';
           $pd->status = true;
           $pd->save();

           $pd = new PageDetail();
           $pd->page_id = $i;
           $pd->lang_id = 3;
           $pd->name = 'fransizca isim';
           $pd->content = 'fransizca içerik';
           $pd->url = 'fransizca_url';
           $pd->status = true;
           $pd->save();

           $pd = new PageDetail();
           $pd->page_id = $i;
           $pd->lang_id = 2;
           $pd->name = 'türkçe isim';
           $pd->content = 'türkçe içerik';
           $pd->url = 'turkce_url';
           $pd->status = true;
           $pd->save();

           $pde = new DetailExtra();
           $pde->page_detail_id = $i;
           $pde->key = "aras";
           $pde->value = "İngilizce extra";
           $pde->save();

           $pde = new DetailExtra();
           $pde->page_detail_id = $i;
           $pde->key = "aras";
           $pde->value = "Fransızca extra";
           $pde->save();

           $pde = new DetailExtra();
           $pde->page_detail_id = $i;
           $pde->key = "aras";
           $pde->value = "Türkçe extra";
           $pde->save();

           $pe = new Extra();
           $pe->page_id = $i;
           $pe->key = "mert";
           $pe->value = "dilsiz extra";
           $pe->save();
       }

        for ($i=1; $i < 600; $i++)
        {
            $meta = new Meta();
            $meta->page_detail_id = $i;
            $meta->description = "description ".$i;
            $meta->keywords = "keywords".$i.",keywords".$i.",keywords".$i;
            $meta->robots = 1;
            $meta->save();
        }
    }
}
